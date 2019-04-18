<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;

class UserTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     * 
     * specifiucally, this test will create a user and verify if the returned eloquent structure
     * is indeed a type of Collection - which would be true if it had a join relationship with another table
     */
    public function a_user_has_projects()
    {

        $user = factory( 'App\User' )->create();

        $this->assertInstanceOf( Collection::class, $user->projects );
    }
}
