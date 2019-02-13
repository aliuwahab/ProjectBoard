<?php

namespace Tests\Feature;

use App\Project;
use App\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrackActivityTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
     function creating_a_project()
    {
//        $this->withoutExceptionHandling();

        $this->signIn();

        $project = factory(Project::class)->create();

        $this->assertCount(1, $project->activity);


        tap($project, function ($project){
            $this->assertEquals('created', $project->activity[0]->description);

            $this->assertNull($project->activity[0]->changes);
        });


    }


    /** @test */
    function updating_a_project()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $project = factory(Project::class)->create([
            'owner_id' => auth()->id()
        ]);

        $projectOriginalTitle = $project->title;

        $project->update($attributes  = [
            'title' => 'Update Project'
        ]);

        $this->patch($project->path(), $attributes)->assertRedirect($project->path());

        $this->assertCount(2, $project->activity);


        tap($project->activity->last(), function($activity) use($projectOriginalTitle) {
            $this->assertEquals('updated', $activity->description);

            $expected = [
                'before' => ['title' => $projectOriginalTitle],
                'after' => ['title' => 'Update Project']
            ];

            $this->assertEquals($expected, $activity->changes);
        });

    }


    /** @test */
     function creating_a_new_task()
    {

        $project = factory(Project::class)->create();

        $project->addTask('Sample Task');

        $this->assertCount(2, $project->activities);

        tap($project->activities->last(), function($activity){
//            dd($activity->toArray());
            $this->assertEquals('created_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
            $this->assertEquals('Sample Task', $activity->subject->body);
        });

    }



    /** @test */
     function completing_a_task()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $project->addTask('Sample Task');

        $task = $project->tasks[0];

        $attributes = ['body' => 'Change body', 'completed' => true];

        $this->patch($task->path(), $attributes);

        $this->assertCount(3, $project->activities);

        $this->assertEquals('completed_task', $project->activities->last()->description);

    }


    /** @test */
     function incompleting_a_task()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $project->addTask('Sample Task');

        $task = $project->tasks[0];

        $attributes = ['body' => 'Change body', 'completed' => false];

        $this->patch($task->path(), $attributes);

        $this->assertCount(3, $project->activities);

        $this->assertEquals('incomplete_task', $project->activities->last()->description);

    }


    /** @test */
    function deleting_a_task()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $project->addTask('Sample Task');


        $project->tasks[0]->delete();

        $this->assertCount(3, $project->activities);

    }


}
