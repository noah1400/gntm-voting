<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Episode;

class EpisodeController extends Controller
{

    public function getEpisodes() {
        $episodes = Episode::all();
        return response()->json($episodes);
    }

    public function getEpisode($id) {
        $episode = Episode::find($id);
        return response()->json($episode);
    }

    public function getEpisodeModels($id) {
        $episode = Episode::find($id);
        $models = $episode->models;
        return response()->json($models);
    }

    public function createEpisode(Request $request) {

        $request->validate([
            'number' => 'required|string',
        ]);

        $episode = new Episode();
        $episode->number = $request->number;
        $episode->save();

        if (!$request->session()->has('selected_episode')) {
            $request->session()->put('selected_episode', $episode->id);
        }

        return response()->json($episode);
    }

    public function getSelectedEpisode(Request $request) {
        // check for session key 'selected_episode'
        // if not found, return null
        // if found, return episode
        if (!$request->session()->has('selected_episode')) {
            return response()->json(null);
        }
        $episode = Episode::find($request->session()->get('selected_episode'));
        if ($episode == null) {
            return response()->json(Episode::first());
        }
        return response()->json($episode);

    }

    public function selectEpisode(Request $request, $id) {
        if (Episode::find($id) == null) {
            return response()->json(['error' => 'Episode not found'], 404);
        }
        $request->session()->put('selected_episode', $id);
        return response()->json($id);
    }
}