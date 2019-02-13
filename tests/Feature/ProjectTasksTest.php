<?php

namespace Tests\Feature;

use App\Project;
use App\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function guest_cannot_add_a_project_task()
    {
        $project = factory(Project::class)->create();

        $this->post($project->path() . '/tasks', ['body' => 'Sample Task'])->assertRedirect('login');
    }


    /** @test */
    function only_the_owner_of_a_project_may_add_tasks()
    {
        $this->signIn();

        $project = factory(Project::class)->create();

        $this->post($project->path() . '/tasks', ['body' => 'Sample Task'])->assertStatus(403);

        $this->assertDatabaseMissing('tasks',['body' => 'Sample Task']);

    }





    /** @test */
    function a_project_can_have_a_tasks()
    {

        $this->signIn();

        $project = auth()->user()->projects()->create(factory(Project::class)->raw());

        $this->post($project->path() . '/tasks', ['body' => 'Sample Task']);

        $this->get(route('show.project', $project))
            ->assertSee('Sample Task');

    }


    /** @test */
     function a_task_can_be_updated()
    {

        $this->withoutExceptionHandling();

        $this->signIn();

        $project = auth()->user()->projects()->create(factory(Project::class)->raw());

        $task = $project->addTask('Sample Task');

        $task_attributes = ['body' => 'Change Sample Task'];

        $this->patch($project->path() .'/tasks/'.$task->id, $task_attributes);

        $this->assertDatabaseHas('tasks', $task_attributes);
        
    }

    /** @test */
    function a_task_can_be_completed()
    {

        $this->withoutExceptionHandling();

        $this->signIn();

        $project = auth()->user()->projects()->create(factory(Project::class)->raw());

        $task = $project->addTask('Sample Task');

        $task_attributes = ['body' => 'Change Sample Task', 'completed' => true];

        $this->patch($project->path() .'/tasks/'.$task->id, $task_attributes);

        $this->assertDatabaseHas('tasks', $task_attributes);

    }



    /** @test */
    function a_task_can_be_mark_incomplete()
    {

        $this->withoutExceptionHandling();

        $this->signIn();

        $project = auth()->user()->projects()->create(factory(Project::class)->raw());

        $task = $project->addTask('Sample Task');

        $task_attributes = ['body' => 'Change Sample Task', 'completed' => true];

        $this->patch($project->path() .'/tasks/'.$task->id, $task_attributes);

        $this->assertDatabaseHas('tasks', $task_attributes);


        $task_attributes = ['body' => 'Change Sample Task', 'completed' => false];

        $this->patch($project->path() .'/tasks/'.$task->id, $task_attributes);

        $this->assertDatabaseHas('tasks', $task_attributes);



    }


    /** @test */
    function only_the_owner_of_a_project_may_update_its_tasks()
    {
        $this->signIn();

        $project = factory(Project::class)->create();

        $task = $project->addTask("Sample Task");

        $task_attributes = ['body' => 'Change Sample Task', 'completed' => true];

        $this->patch($task->path(), $task_attributes)->assertStatus(403);

        $this->assertDatabaseMissing('tasks',['body' => 'Change Sample Task']);

    }


    /** @test */
     function a_task_requires_a_body()
    {

        $this->signIn();

        $project = auth()->user()->projects()->create(factory(Project::class)->raw());

        $attributes = factory(Task::class)->raw(['body' => '']);


        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');

    }





}
