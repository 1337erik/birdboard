<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;
use App\Task;

class ActivityFeedTest extends TestCase
{

    use RefreshDatabase;

    /**
    * @test
    */
    public function creating_a_project_generates_activity()
    {

        $project = ProjectFactory::create();

        $this->assertCount( 1, $project->activity );
        $this->assertEquals( $project->activity[ 0 ]->description, 'created' );
    }

    /**
    * @test
    */
    public function updating_a_project_records_activity()
    {

        $project = ProjectFactory::create();
        $originalTitle = $project->title;

        $project->update([ 'title' => 'changed it' ]);

        $this->assertCount( 2, $project->activity );

        tap( $project->Activity->last(), function( $activity ) use( $originalTitle ) {

            $this->assertEquals( 'updated', $activity->description );

            $expected = [

                'before' => [

                    'title' => $originalTitle
                ],
                'after' => [

                    'title' => 'changed it'
                ]
            ];

            $this->assertEquals( $expected, $activity->changes );
        });
    }

    /**
    * @test
    */
    public function creating_a_new_task_records_project_activity()
    {
        $project = ProjectFactory::create();

        $project->addTask( 'some task' );

        $this->assertCount( 2, $project->activity );

        tap( $project->activity->last(), function( $activity ){

            // dd( $activity->toArray() );
            $this->assertEquals( $activity->description, 'created_task' );
            $this->assertEquals( $activity->subject->body, 'some task' );
            $this->assertInstanceOf( Task::class, $activity->subject );
        });
    }

    /**
    * @test
    */
    public function completing_a_new_task_records_project_activity()
    {

        $project = ProjectFactory::withTasks( 1 )->create();

        $this->actingAs( $project->owner )
            ->patch( $project->tasks[ 0 ]->path(), [

            'body' => 'foobar',
            'completed' => true
        ]);

        $this->assertCount( 3, $project->activity );

        tap( $project->activity->last(), function( $activity ){

            // dd( $activity->toArray() );
            $this->assertEquals( $activity->description, 'completed_task' );
            $this->assertEquals( $activity->subject->body, 'foobar' );
            $this->assertInstanceOf( Task::class, $activity->subject );
        });
    }

    /**
    * @test
    */
    public function incompleting_a_new_task_records_project_activity()
    {

        $project = ProjectFactory::withTasks( 1 )->create();

        $this->actingAs( $project->owner )
            ->patch( $project->tasks[ 0 ]->path(), [

            'body' => 'foobar',
            'completed' => true
        ]);

        $this->assertCount( 3, $project->activity );

        $this->actingAs( $project->owner )
            ->patch( $project->tasks[ 0 ]->path(), [

            'body' => 'foobar',
            'completed' => false
        ]);

        // note the difference here, grabbing a 'fresh' copy from the database
        // could call: $project->refresh();

        $this->assertCount( 4, $project->fresh()->activity );
        $this->assertEquals( $project->fresh()->activity->last()->description, 'incompleted_task' );
    }

    /**
    * @test
    */
    public function deleting_a_task()
    {

        $project = ProjectFactory::withTasks( 1 )->create();

        $project->tasks[ 0 ]->delete();

        $this->assertcount( 3, $project->activity );
    }
}
