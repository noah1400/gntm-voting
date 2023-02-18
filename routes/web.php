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


Route::get('/stats', function () {
    return view('welcome');
})->name('stats');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');

Route::middleware(['logged_in'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/models', function () {
        return view('welcome');
    });
    Route::get('/settings', function () {
        return view('welcome');
    })->name('settings');


    Route::get('/api/models', [App\Http\Controllers\TopModelController::class, 'getModels']);
    Route::post('/api/models', [App\Http\Controllers\TopModelController::class, 'createModel']);
    Route::delete('/api/models/{id}', [App\Http\Controllers\TopModelController::class, 'deleteModel']);

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

    Route::post('/api/lastcall/revoke', [App\Http\Controllers\LastcallController::class, 'revoke']);
    Route::get('/api/lastcall', [App\Http\Controllers\LastcallController::class, 'get']);
});







Route::get('/debug', function () {

    // check if debug is enabled
    if (config('app.debug') == false) {
        abort(404);
    }
    dd(storage_path('app/public/models/'));
    return;
});


