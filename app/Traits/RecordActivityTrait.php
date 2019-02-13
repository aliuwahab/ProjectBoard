<?php
/**
 * Created by PhpStorm.
 * User: aliuwahab
 * Date: 13/02/2019
 * Time: 10:29 AM
 */

namespace App\Traits;


use App\Activity;

trait RecordActivityTrait
{
    public $oldAttributes = [];

    public static function bootRecordActivityTrait(){
        static::updating(function ($model){
            $model->oldAttributes = $model->getOriginal();
        });


        $recordedEvents = ['created','updated','deleted'];

//        foreach ($recordedEvents as $event) {
//            static::$event(function ($model) use ($event){
//
//            });
//        }
    }

    public function activity(){
        return $this->morphMany(Activity::class,'subject')->latest();
    }

    /**
     * @param Project $project
     */
    public function recordActivity($description): void
    {
        $this->activity()->create([
            'project_id' => $this->id,
            'description' => $description,
            'changes' =>  $this->getActivityChanges()
        ]);
    }

    /**
     * @return array
     */
    private function getActivityChanges()
    {
        if ($this->wasChanged()) {
            return [
                'before' => array_diff($this->oldAttributes, $this->getAttributes()),
                'after' => $this->getChanges()
            ];
        }
    }

}
