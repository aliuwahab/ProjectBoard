<?php

namespace Tests\Unit;

use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_has_a_path()
    {
        $project = factory(Project::class)->create();
        $this->assertEquals(route('show.project', $project),$project->path());

    }


    /** @test */
     function it_can_add_a_task()
    {

        $project = factory(Project::class)->create();

        $tasks = $project->addTask('Sample Task');

        $this->assertCount(1, $project->tasks);

        $this->assertTrue($project->tasks->contains($tasks));


    }
}
