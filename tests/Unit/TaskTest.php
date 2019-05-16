<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Task;
use App\Project;

class TaskTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    /**
    * @test
    */
    public function it_belongs_to_a_project()
    {

        $task = factory( Task::class )->create();

        $this->assertInstanceOf( Project::class, $task->project );
    }

    /**
     * @test
     * 
     * testing a virtual attribute of an entity
     *
     * @return void
     */
    public function it_has_a_path()
    {

        $task = factory( Task::class )->create();

        $this->assertEquals( '/projects/' . $task->project->id . '/tasks/' . $task->id, $task->path() );
    }
}
