<?php

namespace Tests\Setup;

use App\Project;
use App\User;
use App\Task;

class ProjectFactory
{

    protected $tasksCount = 0;
    protected $user;

    public function withTasks( $count )
    {

        $this->tasksCount = $count;

        return $this;
    }

    public function ownedBy( $user )
    {

        $this->user = $user;

        return $this;
    }

    /**
     * The idea behind this factory is not only abstraction of code,
     * but also world-building for the application's tests
     * 
     * In this application, projects are the main entity of focus.
     * The User and Task entities matter only with respect to the Project.
     */
    public function create()
    {

        // create a project & user to own it
        $project = factory( Project::class )->create([

            'owner_id' => $this->user ?? factory( User::class )
        ]);

        // if any, create tasks and associate it to the newly created project
        factory( Task::class, $this->tasksCount )->create([

            'project_id' => $project->id
        ]);

        // return the project, owner and associated tasks for test purposes
        return $project;
    }
}

// app( ProjectFactory::class )->create();