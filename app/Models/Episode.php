<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;

    public function models()
    {
        return $this->belongsToMany(TopModel::class, 'model_episode', 'episode_id', 'model_id');
    }

    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'top_model_activity', 'episode_id', 'activity_id');
    }
}
