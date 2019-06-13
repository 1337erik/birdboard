<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    public $old = [];

    public function path()
    {

        return "/projects/{$this->id}";
    }

    public function activity()
    {

        return $this->hasMany( Activity::class )->latest();
    }

    public function recordActivity( $description )
    {

        $this->activity()->create([

            'description' => $description,
            'changes'     => [

                'before' => array_diff( $this->old, $this->getAttributes() ),
                'after'  => array_diff( $this->getAttributes(), $this->old )
            ]
        ]);
    }
 
    public function owner()
    {

        return $this->belongsTo( User::class );
    }

    public function tasks()
    {

        return $this->hasMany( Task::class );
    }

    public function addTask( $body )
    {

        return $this->tasks()->create( [ 'body' => $body ] );
    }
}
