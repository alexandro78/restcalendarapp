<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalendarController extends Controller
{

    public function getCalendar()
    {
        $calendar = DB::table('calendars')->where('date', '<', '2022-06-01', 'AND', 'date', '>', '2022-05-01')->get();
        // 'start_time', '<', '10:30'
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
        $calendar->update($request->all());
        return response()->json($calendar, 200);
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
    //     $calendar = Calendar::find($id);
    //     if (is_null($calendar)) {
    //         return response()->json(['error' => 'true', 'message' => 'Not found'], 404);
    //     }
    //     return response()->json(Calendar::find($id), 200);
    // }

}
