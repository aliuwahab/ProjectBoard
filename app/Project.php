<?php

namespace App;

use App\Traits\RecordActivityTrait;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use RecordActivityTrait;

    protected $guarded = [];

    public function path(){
        return route('show.project', $this);
    }


    public function owner(){
        return $this->belongsTo(User::class, 'owner_id');
    }


    public function addTask($body){

        return $this->tasks()->create(['body' => $body]);
    }


    public function tasks(){

        return $this->hasMany(Task::class, 'project_id');
    }

    public function activities(){
        return $this->hasMany(Activity::class, 'project_id');
    }



}
