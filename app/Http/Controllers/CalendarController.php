<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalendarController extends Controller
{

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
        $calendar = Calendar::create($request->all());
        return response()->json($calendar, 201);
    }

    public function updateEntry(Request $request, $id)
    {
        $calendar = Calendar::find($id);
        if (is_null($calendar)) {
            return response()->json(['error' => 'true', 'message' => 'Not found'], 404);
        }
        date_default_timezone_set("Europe/Kiev");
        $currentTime = strtotime(date('H:i:s'));
        $taskStart = strtotime($calendar->start_time);
        $mins = ($taskStart - $currentTime) / 60;
        if (floor($mins) > 180) {
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
        $calendar->delete($request->all());
        return response()->json('', 204);
    }

    // public function getEntryById($id)
    // {
    // $calendar = Calendar::find($id);
    // if (is_null($calendar)) {
    //     return response()->json(['error' => 'true', 'message' => 'Not found'], 404);
    // }
    //     return response()->json($calendar, 200);
    // }

}
