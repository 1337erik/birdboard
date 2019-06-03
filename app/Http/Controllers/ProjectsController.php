<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProjectsController extends Controller
{

    public function index()
    {

        $projects = auth()->user()->projects()->orderBy( 'updated_at', 'desc' )->get();

        return view( 'projects.index', compact( 'projects' ) );
    }

    public function store()
    {

        // validate the data
        $attributes = request()->validate([

            'title'       => 'required',
            'description' => 'required',
            'notes'       => 'min:3'
        ]);

        // $attributes[ 'owner_id' ] = auth()->id();

        // persist the data
        $project = auth()->user()->projects()->create( $attributes );
        // Project::create( $attributes );

        // redirect
        return redirect( $project->path() );
    }

    public function update( Project $project )
    {

        // if( auth()->user()->isNot( $project->owner ) ) abort( 403 );
        $this->authorize( 'update', $project );

        $attributes = request()->validate([

            'notes'       => 'max: 255',
            'title'       => 'sometimes | required',
            'description' => 'sometimes | required'
        ]);

        $project->update( $attributes );

        return redirect( $project->path() );
    }

    public function edit( Project $project )
    {

        return view( 'projects.edit', compact( 'project' ) );
    }

    public function show( Project $project )
    {

        // $project = Project::findOrFail( request( 'project' ) );
        // this is not necessary now that we have 'binded' the model and route above via the passed argument ( passed from the route in web.php )
        // if( auth()->user()->isNot( $project->owner ) )abort( 403 );
        $this->authorize( 'update', $project );

        return view( 'projects.show', compact( 'project' ) );
    }

    public function create( Project $project )
    {

        return view( 'projects.create' );
    }
}
