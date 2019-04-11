<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProjectsController extends Controller
{

    public function index()
    {

        $projects = Project::all();

        return view( 'projects.index', compact( 'projects' ) );
    }

    public function store()
    {

        // validate the data
        $attributes = request()->validate([

            'title'       => 'required',
            'description' => 'required'
        ]);

        // persist the data
        Project::create( $attributes );

        // redirect
        return redirect( '/projects' );
    }
}