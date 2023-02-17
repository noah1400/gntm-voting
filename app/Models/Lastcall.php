<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lastcall extends Model
{
    use HasFactory;
    protected $table = 'lastcall';

    protected $fillable = [
        'type',
        'affected',
        'model_id',
        'activity_id',
    ];

    public static $lastcall = null;

    public function model()
    {
        return $this->belongsTo(TopModel::class, 'model_id');
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }

    public static function set($data)
    {
        // validate
        $type = $data['type'];
        $affected = $data['affected'];
        $model_id = $data['model_id'] ?? null;
        $activity_id = $data['activity_id'] ?? null;
        if (!in_array($type, ['create', 'increase', 'incr'])) {
            throw new \Exception('Invalid type');
        }
        if (!in_array($affected, ['model', 'activity', 'model_activity'])) {
            throw new \Exception('Invalid affected');
        }
        if ($type == 'increase' && $affected != 'model_activity') {
            throw new \Exception('Invalid type and affected combination');
        }
        if ($affected == 'model' && $model_id == null) {
            throw new \Exception('Invalid model_id');
        }
        if ($affected == 'activity' && $activity_id == null) {
            throw new \Exception('Invalid activity_id');
        }
        if ($affected == 'model_activity' && ($model_id == null || $activity_id == null)) {
            throw new \Exception('Invalid model_id or activity_id');
        }




        // remove all previous lastcalls
        Lastcall::truncate();
        // create new lastcall
        $lastcall = new Lastcall();
        $lastcall->type = $type;
        $lastcall->affected = $affected;
        $lastcall->model_id = $model_id;
        $lastcall->activity_id = $activity_id;
        $lastcall->save();
        return $lastcall;
    }

    private static function lastcall() {
        if (static::$lastcall == null) {
            static::$lastcall = Lastcall::first();
        }
        return static::$lastcall;
    }

    public static function revoke()
    {
        if (static::lastcall() == null) {
            return false;
        }
        if (static::lastcall()->type == 'create') {
            if (static::lastcall()->affected == 'model') {
                $model = static::lastcall()->model;
                $model->delete();
            } else if (static::lastcall()->affected == 'activity') {
                $activity = static::lastcall()->activity;
                $activity->delete();
            }
        } else if (in_array(static::lastcall()->type, ['increase', 'incr']) ) {
            $model = static::lastcall()->model;
            $activity = static::lastcall()->activity;
            // decrease count in pivot table
            $act = $model->activities->find($activity);
            // if count is 1 then detach
            if ($act->pivot->count == 1) {
                $model->activities()->detach($activity);
            } else {
                $model->activities()->updateExistingPivot($activity, ['count' => $act->pivot->count - 1]);
            }
        }
        // remove lastcall
        static::lastcall()->delete();
        static::$lastcall = null;

        return true;
    }

    public static function get()
    {
        $l = static::lastcall();
        if ($l == null) {
            return null;
        }
        $model = $l->model;
        $activity = $l->activity;
        return $l;
    }
}
