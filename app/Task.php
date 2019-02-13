<?php

namespace App;

use App\Traits\RecordActivityTrait;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use RecordActivityTrait;

    protected $guarded = [];


    protected $touches = ['project'];

    protected $casts = ['completed' => 'boolean'];



    public function project(){
        return $this->belongsTo(Project::class, 'project_id');
    }


    public function path(){
         return $this->project->path() .'/tasks/' .$this->id;
    }



    public function completed(){
          $this->update(['completed' => true]);
          $this->recordActivity('completed_task');
    }


    public function incomplete(){
        $this->update(['completed' => false]);
        $this->recordActivity('incomplete_task');
    }

}
