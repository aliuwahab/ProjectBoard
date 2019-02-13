<?php

namespace Tests\Unit;

use App\Project;
use App\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{

    use RefreshDatabase;


    /** @test */
    public function a_task_belongs_to_a_project()
    {
        $task = factory(Task::class)->create();

        $this->assertInstanceOf(Project::class, $task->project);

    }




    /** @test */
    public function a_task_has_a_path()
    {
        $task = factory(Task::class)->create();

        $this->assertEquals($task->project->path() .'/tasks/' .$task->id, $task->path());
    }


    /** @test */
    function a_task_can_be_mark_as_completed()
    {
        $this->withoutExceptionHandling();

        $task = factory(Task::class)->create();

        $this->assertFalse($task->completed);

        $task->completed();

        $this->assertTrue($task->fresh()->completed);

    }




    /** @test */
    function a_task_can_be_mark_as_incomplete()
    {
        $this->withoutExceptionHandling();

        $task = factory(Task::class)->create();

        $this->assertFalse($task->completed);

        $task->completed();

        $this->assertTrue($task->fresh()->completed);

        $task->incomplete();

        $this->assertFalse($task->fresh()->completed);

    }
}
