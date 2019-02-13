<?php

namespace Tests\Feature;

use App\Project;
use App\User;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MonitorActivityTest extends TestCase
{
    use withFaker, RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();


    }


    /** @test */
    public function guests_cannot_manage_project()
    {
        $project = factory(Project::class)->create();

        $this->get(route('projects'))->assertRedirect(route('login'));
        $this->get($project->path())->assertRedirect(route('login'));
        $this->get(route('create.project'))->assertRedirect(route('login'));
        $this->get(route('edit.project',$project))->assertRedirect(route('login'));

        $this->post('/projects', $project->toArray())->assertRedirect(route('login'));
    }



    /** @test */
    public function a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();

        $this->signIn();
        $this->get(route('create.project'))->assertStatus(200);

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'notes' => 'General Notes'
        ];

        $response = $this->post('/projects', $attributes);

        $project = Project::where($attributes)->first();

        $response->assertRedirect(route('show.project', $project));

        $this->assertDatabaseHas('projects', $attributes);

        $this->get(route('show.project', $project))
            ->assertSeeText($attributes['title'])
            ->assertSeeText($attributes['description'])
            ->assertSeeText($attributes['notes']);

    }


    /** @test */
    public function a_user_can_update_a_project()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $project = factory(Project::class)->create([
            'owner_id' => auth()->id()
        ]);

        $attributes  = [
            'title' => 'Title is changed',
            'description' => 'Description is changed',
            'notes' => 'Changed Notes',
        ];

        $this->patch($project->path(), $attributes)->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);

    }




    /** @test */
    public function a_user_can_update_a_project_only_the_general_notes_of_project()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $project = factory(Project::class)->create([
            'owner_id' => auth()->id()
        ]);

        $attributes  = [
            'notes' => 'Changed Notes',
        ];

        $this->patch($project->path(), $attributes)->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);

    }





    /** @test */
    public function a_user_can_view_a_project()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }


    /** @test */
    public function an_authenticated_user_cannot_view_project_of_others()
    {

//        $this->withoutExceptionHandling();

        $this->signIn();

        $project = factory(Project::class)->create();

        $this->get($project->path())->assertStatus(403);


    }


    /** @test */
    public function an_authenticated_user_cannot_update_project_of_others()
    {

//        $this->withoutExceptionHandling();

        $this->signIn();

        $project = factory(Project::class)->create();

        $this->patch($project->path(), [])->assertStatus(403);


    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->signIn();

        $attributes = factory(Project::class)->raw(['title' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }


    /** @test */
    public function a_project_requires_a_description()
    {
        $this->signIn();

        $attributes = factory(Project::class)->raw(['description' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }


    /** @test */
    public function a_project_belongs_to_user()
    {
//        $this->be(factory(User::class)->create([
//            'email' => 'aliuwahab@gmail.com'
//        ]));

        $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $this->assertInstanceOf(User::class, $project->owner);

//        assertEquals('aliuwahab@gmail.com', $project->user->email);



    }












}
