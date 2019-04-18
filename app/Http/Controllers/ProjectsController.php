<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProjectsController extends Controller
{

    public function index()
    {

        $projects = auth()->user()->projects;

        return view( 'projects.index', compact( 'projects' ) );
    }

    public function store()
    {

        // validate the data
        $attributes = request()->validate([

            'title'       => 'required',
            'description' => 'required'
        ]);

        // $attributes[ 'owner_id' ] = auth()->id();

        // persist the data
        auth()->user()->projects()->create( $attributes );
        // Project::create( $attributes );

        // redirect
        return redirect( '/projects' );
    }

    public function show( Project $project )
    {

        // $project = Project::findOrFail( request( 'project' ) );
        // this is not necessary now that we have 'binded' the model and route above via the passed argument ( passed from the route in web.php )
        if( auth()->id()->isNot( $project->owner ) ){

            abort( 403 );
        }

        return view( 'projects.show', compact( 'project' ) );
    }
}
