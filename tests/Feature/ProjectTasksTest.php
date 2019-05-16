<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Project;
use App\Task;

class ProjectTasksTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    protected $projectRequirements = [

        'description',
        'title'
    ];

    protected $taskRequirements = [

        'body'
    ];

    /**
     * @test
     * 
     * this is adapted from Jeffrey's episode 12, asically instead of
     * creating individual functions to test whether an entity is
     * properly requiring some field, I abstracted away a factory
     * function that will read from a list of required fields..
     * 
     * then updated it to perform the same test for another entity
     * 
     * could probably even read from the Model itself.. I'll check later
     */
    public function test_entity_required_fields()
    {

        // $this->withoutExceptionHandling();
        $this->signIn();

        foreach( $this->projectRequirements as $attribute ){

            $attributes = factory( "App\Project" )->raw([ $attribute => '' ]);
            $this->post( '/projects', $attributes )->assertSessionHasErrors( $attribute );
        }

        $project = auth()->user()->projects()->create(

            factory( Project::class )->raw()
        );
        foreach( $this->taskRequirements as $attribute ){

            $attributes = factory( 'App\Task' )->raw([ $attribute => '' ]);
            $this->post( $project->path() . '/tasks', $attributes )->assertSessionHasErrors( $attribute );
        }
    }

    /**
     * @test
     * 
     * make sure that non-authenticated users cannot add tasks to a project
     * by making sure a redirect t ologin happens upon hitting that route
     */
    public function guests_cannot_add_tasks_to_projects()
    {
        $project = factory( 'App\Project' )->create();

        $this->post( $project->path() . '/tasks' )->assertRedirect( 'login' );
    }

    /**
     * @test
     * 
     * make sure that non-authenticated users cannot add tasks to a project
     * by making sure a redirect t ologin happens upon hitting that route
     */
    public function only_project_owner_can_add_tasks()
    {

        $this->signIn();

        $project = factory( 'App\Project' )->create();

        $this->post( $project->path() . '/tasks', [ 'body' => 'test task' ] )
            ->assertStatus( 403 );

        // this was brought up for an example, but I am keeping this as an awesome
        // example of a test that searches the database for a specific entity
        // $this->assertDatabaseMissing( 'tasks', [ 'body' => 'test task' ] );
    }

    /**
     * @test
     *
     * this tests the functionality of the project entity in two ways:
     * see below for specifics..
     * @return void
     */
    public function a_project_can_have_tasks()
    {

        $this->withoutExceptionHandling();
        $this->signIn();

        // this creates the task through the project member function
        // $project = factory( Project::class )->create( [ 'owner_id' => auth()->id() ] );

        // this creates the task through the entity relationship of the authenticated user
        $project = auth()->user()->projects()->create(
            factory( Project::class )->raw()
        );

        // first, that the project's member function 'addTask' works
        // via testing the 'post' route and controller functions and member function
        $this->post( $project->path() . '/tasks', [ 'body' => 'lorem ipsum' ] );

        // second, that the task appears on the 'get' route
        $this->get( $project->path() )
            ->assertSee( 'lorem ipsum' );
    }

    /**
     * @test
     */
    public function a_task_can_be_updated()
    {

        $this->withoutExceptionHandling();
        $this->signIn();

        $project = auth()->user()->projects()->create(

            factory( Project::class )->raw()
        );

        $task = $project->addTask( 'test task' );

        $attributes = [

            'body'      => 'changed',
            'completed' => true
        ];

        $this->patch( $task->path(), $attributes );

        $this->assertDatabaseHas( 'tasks', $attributes );
    }

    /**
     * @test
     * 
     * I was initially confused why I wouldn't just add this to the above test..
     * I'll explain why thats incorrect thinking here for educational reasons..
     * 
     * This test specifically checks for whether or not the update is being done by you or even a guest user,
     * being logged in is actually insignificant on its own.
     */
    public function only_the_owner_of_a_project_may_update_tasks()
    {

        $this->signIn();

        $project = factory( 'App\Project' )->create();

        $task = $project->addTask( 'test task' );

        $attributes = [

            'body'      => 'changed',
            'completed' => true
        ];

        $this->patch( $task->path(), $attributes )
            ->assertStatus( 403 );

        $this->assertDatabaseMissing( 'tasks', $attributes );
    }
}
