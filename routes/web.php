<?php

use App\Models\Lastcall;
use App\Models\TopModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/models', function () {
    return view('welcome');
});
Route::get('/settings', function () {
    return view('welcome');
});
Route::get('/stats', function () {
    return view('welcome');
});

Route::get('/api/models', [App\Http\Controllers\TopModelController::class, 'getModels']);
Route::post('/api/models', [App\Http\Controllers\TopModelController::class, 'createModel']);

Route::get('/api/activities', [App\Http\Controllers\ActivityController::class, 'getActivities']);
Route::get('/api/activity/{id}', [App\Http\Controllers\ActivityController::class, 'getActivity']);
Route::post('/api/activity', [App\Http\Controllers\ActivityController::class, 'createActivity']);
Route::get('/api/models/activities/{id}', [App\Http\Controllers\TopModelController::class, 'getModelsActivities']);
Route::post('/api/models/{m_id}/incr/{a_id}', [App\Http\Controllers\TopModelController::class, 'incrModelActivity']);

Route::get('/api/episodes', [App\Http\Controllers\EpisodeController::class, 'getEpisodes']);
Route::post('/api/episode', [App\Http\Controllers\EpisodeController::class, 'createEpisode']);
Route::get('/api/models/episodes/{id}', [App\Http\Controllers\TopModelController::class, 'getModelsEpisodes']);
Route::post('/api/models/{m_id}/episode/{e_id}', [App\Http\Controllers\TopModelController::class, 'addModelEpisode']);

Route::get('/api/episode/selected', [App\Http\Controllers\EpisodeController::class, 'getSelectedEpisode']);
Route::post('/api/episode/select/{e_id}', [App\Http\Controllers\EpisodeController::class, 'selectEpisode']);

Route::get('/api/episode/{id}', [App\Http\Controllers\EpisodeController::class, 'getEpisode']);


Route::get('/api/stats', [App\Http\Controllers\TopModelController::class, 'getModelsStats']);



Route::get('/debug', function () {
    $participates = DB::table('top_model_activity')
    ->where('model_id', 1)
    ->where('activity_id', 1)
    ->where('episode_id', 2)->value('count');
    dd($participates);
    return;
});

Route::post('/api/lastcall/revoke', [App\Http\Controllers\LastcallController::class, 'revoke']);
Route::get('/api/lastcall', [App\Http\Controllers\LastcallController::class, 'get']);
