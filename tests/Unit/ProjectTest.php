<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     * 
     * this is a great abstraction. This is testing a 'virtual field' for the object.
     * Not an actual database field, but something created as a part
     * of the relationship it has with the environment of the project
     */
    public function it_has_a_path()
    {

        $project = factory( 'App\Project' )->create();

        $this->assertEquals( '/projects/' . $project->id, $project->path() );
    }

    /**
     * @test
     * 
     * again, a test of a relationship established, but this time
     * by the relationship between two tables. Basically asserting
     * that if an entity exists ( of project ), then it has a related
     * instance of a User entity attached to it.
     */
    public function it_belongs_to_an_owner()
    {

        $project = factory( 'App\Project' )->create();

        $this->assertInstanceOf( 'App\User', $project->owner );
    }

    /**
     * @test
     * 
     * this is testing a functionality for a project entity to add a
     * task to itself, making sure that the entity relationship exists and
     * works properly
     */
    public function it_can_add_a_task()
    {

        // step 1: create the entity from scratch
        $project = factory( 'App\Project' )->create();

        // setp 2: call the member function of the project
        $task = $project->addTask( 'Test task' );
        // *note* upon creation of this test, this member function doesnt exist,
        // therefore is a valid example of 'test-driven' development

        // step 3: verify it works by checking if the task exists now
        $this->assertCount( 1, $project->tasks );
        // *note* this is a good method of doing so - which is querying the entity relationship in eloquent..
        // this is also 'test-driven' as it now forces us to create the entity relationship
        // in order to pass.. this tests to just see if one task exists, however

        $this->assertTrue( $project->tasks->contains( $task ) );
        // this is a more precise way of ensuring that the task was created.
        // specifically, the difference here is that this is making
        // sure that the specific task exists, as opposed
        // to 'just any one' as the above test checks
    }
}
