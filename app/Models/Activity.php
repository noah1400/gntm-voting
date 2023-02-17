<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    public function models()
    {
        return $this->belongsToMany(TopModel::class, 'top_model_activity', 'activity_id', 'model_id')->withPivot('count', 'episode_id');
    }

    public function episodes()
    {
        return $this->belongsToMany(Episode::class, 'top_model_activity', 'activity_id', 'episode_id');
    }
}
