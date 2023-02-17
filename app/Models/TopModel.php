<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopModel extends Model
{
    use HasFactory;

    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'top_model_activity', 'model_id', 'activity_id')->withPivot('count', 'episode_id');
    }

    public function episodes()
    {
        // return $this->belongsToMany(Episode::class, 'model_episode', 'model_id', 'episode_id');
        return Episode::all(); // for  now
    }
}
