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
        $project = auth()->user()->projects()->create( $attributes );
        // Project::create( $attributes );

        // redirect
        return redirect( $project->path() );
    }

    public function show( Project $project )
    {

        // $project = Project::findOrFail( request( 'project' ) );
        // this is not necessary now that we have 'binded' the model and route above via the passed argument ( passed from the route in web.php )
        if( auth()->user()->isNot( $project->owner ) ){

            abort( 403 );
        }

        return view( 'projects.show', compact( 'project' ) );
    }

    public function create( Project $project )
    {

        return view( 'projects.create' );
    }
}
