<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{

    private function timeToTask($id)
    {
        $calendar = Calendar::find($id);
        date_default_timezone_set("Europe/Kiev");
        $currentTime = strtotime(date('H:i:s'));
        $taskStart = strtotime($calendar->start_time);
        $mins = ($taskStart - $currentTime) / 60;
        return (floor($mins) > 180);
    }

    public function getCalendar(Request $request)
    {
        $calendar = DB::table('calendars')
            ->where('date', '>', $request->input('date_start'))
            ->where('date', '<', $request->input('date_end'))
            ->get();
        return response()->json($calendar, 200);
    }

    public function createEntry(Request $request)
    {
        if ((Auth::guard('sanctum')->user() and ($request->start_time or $request->end_time)) or (!Auth::guard('sanctum')->user() and !$request->start_time and !$request->end_time )){
            $calendar = Calendar::create($request->all());
            return response()->json($calendar, 201);
        }
            return response()->json('Для наложение времени войдите в account', 200);
        
    }

    public function updateEntry(Request $request, $id)
    {
        $calendar = Calendar::find($id);
        if (is_null($calendar)) {
            return response()->json(['error' => 'true', 'message' => 'Not found'], 404);
        }
        if ($this->timeToTask($id)) {
            $calendar->update($request->all());
            return response()->json($calendar, 200);
        }
        return response()->json(['error' => 'true', 'message' => 'time expired'], 404);

    }

    public function deleteEntry(Request $request, $id)
    {
        $calendar = Calendar::find($id);
        if (is_null($calendar)) {
            return response()->json(['error' => 'true', 'message' => 'Not found'], 404);
        }
        if ($this->timeToTask($id)) {
            $calendar->delete($request->all());
            return response()->json('', 204);
        }
        return response()->json(['error' => 'true', 'message' => 'delete time expired'], 404);

    }

    public function createToken(Request $request)
    {
        $token = $request->user()->createToken($request->remember_token);
        return response()->json(['token' => $token->plainTextToken], 404);

    }

}
