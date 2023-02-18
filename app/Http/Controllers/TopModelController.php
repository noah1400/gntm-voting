<?php

namespace App\Http\Controllers;

use App\Models\TopModel;
use App\Models\Activity;
use App\Models\Lastcall;
use App\Models\Episode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;

class TopModelController extends Controller
{

    public function getModels()
    {
        $models = TopModel::all();
        return response()->json($models);
    }

    public function createModel(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $model = new TopModel();

        if (request()->has('photo')) {
            $url = request()->file('photo')->store('public/models');
            $parameters['image_url'] = substr($url, 7);
            Image::configure(array('driver' => 'gd'));

            Image::make(storage_path('app/' . $url))
                ->resize(300, 300)
                ->save(storage_path('app/' . $url));


            $model->image = $parameters['image_url'];
        }



        $model->name = $request->name;
        $model->save();

        Lastcall::set([
            'type' => 'create',
            'affected' => 'model',
            'model_id' => $model->id,
        ]);

        return response()->json($model);
    }

    public function deleteModel($id)
    {
        $model = TopModel::find($id);
        if ($model == null) {
            return response()->json(['error' => 'Model not found'], 404);
        }

        DB::transaction(function () use ($model) {
            $model->activities()->detach();
            //$model->episodes()->detach();

            $photo = $model->image;
            $model->delete();
            if ($photo != null && file_exists(storage_path('app/public/' . $photo))) {
                unlink(storage_path('app/public/' . $photo));
            }


        }, 5);
    }

    public function getModelsActivities($id)
    {
        $models = TopModel::find($id);
        $activities = $models->activities;
        return response()->json($activities);
    }

    public function incrModelActivity($m_id, $t_id)
    {

        $episode_id = request()->session()->get('selected_episode');
        if ($episode_id == null) {
            return response()->json(['error' => 'Episode id not found'], 404);
        }

        $model = null;

        DB::transaction(function () use ($m_id, $t_id, $episode_id, $model) {
            $model = TopModel::find($m_id);
            $activity = Activity::find($t_id);

            if ($model == null || $activity == null) {
                return response()->json(['error' => 'Model or activity not found'], 404);
            }

            // if model participated in this activity in this episode
            $participates = DB::table('top_model_activity')
                ->where('model_id', $model->id)
                ->where('activity_id', $activity->id)
                ->where('episode_id', $episode_id)
                ->exists();

            if (!$participates) {
                // attach model to activity
                $model->activities()->attach($activity->id, ['count' => 1, 'episode_id' => $episode_id]);
            } else {
                // increment count
                DB::table('top_model_activity')
                    ->where('model_id', $model->id)
                    ->where('activity_id', $activity->id)
                    ->where('episode_id', $episode_id)
                    ->increment('count');
            }

            Lastcall::set([
                'type' => 'incr',
                'affected' => 'model_activity',
                'model_id' => $model->id,
                'activity_id' => $activity->id,
            ]);
        }, 5);

        return response()->json($model);
    }

    public function getModelsStats(Request $request)
    {


        $request->validate([
            'episode' => 'nullable|integer',
            'model' => 'nullable|integer',
            'activity' => 'nullable|integer',
        ]);

        $episode_id = $request->episode;
        $model_id = $request->model;
        $activity_id = $request->activity;

        if ($model_id) {
            $models = TopModel::where('id', $model_id)->get();
        } else {
            $models = TopModel::all();
        }

        $stats = [];
        foreach ($models as $model) {
            $stats[$model->name] = [];
            if ($episode_id) {
                $episodes = Episode::where('id', $episode_id)->get();
            } else {
                $episodes = $model->episodes(); // TODO: fix this : remove () after fixing the relationship
            }
            foreach ($episodes as $episode) {
                $stats[$model->name][$episode->number] = [];
                if ($activity_id) {
                    $activities = Activity::where('id', $activity_id)->get();
                } else {
                    $activities = $model->activities;
                    $all_activities = Activity::all();
                    foreach ($all_activities as $activity) {
                        $stats[$model->name][$episode->number][$activity->name] = [];
                        $stats[$model->name][$episode->number][$activity->name]['count'] = 0;
                        $stats[$model->name][$episode->number][$activity->name]['multiplier'] = floatval($activity->multiplier ?? 1);
                    }
                }
                foreach ($activities as $activity) {
                    $stats[$model->name][$episode->number][$activity->name] = [];
                    $stats[$model->name][$episode->number][$activity->name]['count'] = DB::table('top_model_activity')
                        ->where('model_id', $model->id)
                        ->where('activity_id', $activity->id)
                        ->where('episode_id', $episode->id)
                        ->value('count') ?? 0;
                    $stats[$model->name][$episode->number][$activity->name]['multiplier'] = floatval($activity->multiplier ?? 1);
                    $stats[$model->name][$episode->number][$activity->name]['count'] = intval($stats[$model->name][$episode->number][$activity->name]['count']);
                }
            }
        }

        return response()->json($stats);
    }

    public function getModelsEpisodes($id)
    {
        // In which episodes did the model participate?
        $model = TopModel::find($id);
        $episodes = $model->episodes;
        return response()->json($episodes);
    }

    public function addModelEpisode($m_id, $e_id)
    {
        $episode = Episode::find($e_id);
        $model = TopModel::find($m_id);
        if ($episode == null || $model == null) {
            return response()->json(['error' => 'Model or episode not found'], 404);
        }
        if (!$model->episodes->contains($episode)) {
            $model->episodes()->attach($episode);
            $model->refresh(); // refresh model to get new pivot
        }
        return response()->json($model);
    }
}
