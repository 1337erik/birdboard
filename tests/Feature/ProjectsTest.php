<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsTest extends TestCase
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

        $attributes = [

            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ];

        $this->post( '/projects', $attributes )->assertRedirect( '/projects' );

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

        $attributes = factory( 'App\Project' )->raw([ 'title' => '' ]);

        $this->post( '/projects', $attributes )->assertSessionHasErrors( 'title' );
    }

    /**
     * @test
     * 
     * this follow the same logic as the above test
     */
    public function a_project_requires_a_description()
    {

        $attributes = factory( 'App\Project' )->raw([ 'description' => '' ]);
        // $attributes = factory( 'App\Project' )->make([ 'description' => '' ]);
        // the difference being that 'raw' will return an array, where 'make' returns an 'Eloquent Object'

        $this->post( '/projects', $attributes )->assertSessionHasErrors( 'description' );
    }
}
