<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Project;

class ManageProjectsTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    /**
     * @test
     * 
     * this essentially tests that, if given an entity:
     * - I can send it to an endpoint,
     * - prove that it is persisted,
     * - retrieve it and see it
     */
    public function a_user_can_create_a_project()
    {

        $this->withoutExceptionHandling();
        // $this->actingAs( factory( 'App\User' )->create() );
        $this->signIn(); // abstracted in testCase for easy test auth

        $this->get( 'projects/create' )->assertStatus( 200 );

        $attributes = [

            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ];

        $response = $this->post( '/projects', $attributes );

        $response->assertRedirect( Project::where( $attributes )->first()->path() );

        $this->assertDatabaseHas( 'projects', $attributes );

        $this->get( '/projects' )->assertSee( $attributes[ 'title' ] );
    }

    /**
     * @test
     * 
     * this tests that certain fields are required by attempting to create
     * and entity without the required fields, and then verifying that
     * problems ensue from that attempted action
     * 
     * this works because I am passing an empty array in an attempt to send an entity to the endpoint,
     * however, I am checking that there will be a complaint for a 'missing title'.
     * At first, there will be a problem because 'no problem' will be found, this
     * is a sort of backwards-logical test, in that way..
     * Instead, this test will only work once I create a vlaidatiuon rule of 'required' for the
     * title attribute of the entity, and thus try to create that entity without a title here.
     */
    public function a_project_requires_a_title()
    {

        $this->signIn();
        $attributes = factory( 'App\Project' )->raw([ 'title' => '' ]);
        // 'raw' will return an array, where 'make' returns an 'Eloquent Object'

        $this->post( '/projects', $attributes )->assertSessionHasErrors( 'title' );
    }

    /**
     * @test
     * 
     * this follow the same logic as the above test
     */
    public function a_project_requires_a_description()
    {

        $this->signIn();
        $attributes = factory( 'App\Project' )->raw([ 'description' => '' ]);
        // $attributes = factory( 'App\Project' )->make([ 'description' => '' ]);
        // the difference being that 'raw' will return an array, where 'make' returns an 'Eloquent Object'

        $this->post( '/projects', $attributes )->assertSessionHasErrors( 'description' );
    }

    /**
     * @test
     * 
     * this test used to be 3 separate tests, but jeffrey shows how most functionality can be concatenated into one test
     * for the purpose of brevity and efficiency and readability
     */
    public function guests_cannot_manage_projects()
    {

        // $this->withoutExceptionHandling();

        $project = factory( 'App\Project' )->create();

        // toArray() is a great functio nto convert an Eloquent object into an array! remember this!
        $this->post( '/projects', $project->toArray() )->assertRedirect( 'login' );
        $this->get( 'projects/create' )->assertRedirect( 'login' );
        $this->get( '/projects' )->assertRedirect( 'login' );
        $this->get( $project->path() )->assertRedirect( 'login' );

    }

    /**
     * @test
     */
    public function a_user_can_view_their_project()
    {

        $this->withoutExceptionHandling();
        $this->signIn();

        // given a project..
        $project = factory( 'App\Project' )->create([ 'owner_id' => auth()->id() ]);

        $this->get( $project->path() )
            ->assertSee( $project->title )
            ->assertSee( str_limit( $project->description, 100 ) );
    }

    /**
     * @test
     */
    public function an_authenticated_user_cannot_view_the_projects_of_others()
    {

        // $this->withoutExceptionHandling();
        $this->signIn();

        // given a project..
        $project = factory( 'App\Project' )->create();

        $this->get( $project->path() )->assertStatus( 403 );
    }
}
