<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Lastcall;
use App\Models\TopModel;

class ActivityController extends Controller
{

    public function createActivity(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'multiplier' => 'nullable|numeric',
        ]);

        $activity = new Activity();
        $activity->name = $request->name;
        $activity->description = $request->description;
        $activity->multiplier = $request->multiplier ?? 1;
        $activity->save();

        Lastcall::set([
            'type' => 'create',
            'affected' => 'activity',
            'activity_id' => $activity->id,
        ]);

        return response()->json($activity);
    }

    public function getModelsActivities($id) {
        $model = TopModel::find($id);
        $activities = $model->activities;
        return response()->json($activities);
    }

    public function getActivities() {
        $activities = Activity::all();
        return response()->json($activities);
    }

    public function getActivity($id) {
        // get activity by id
        // with models of this activity
        $activity = Activity::find($id);
        $models = $activity->models; // get models of this activity
        return response()->json($activity);
    }

}
