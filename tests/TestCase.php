<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * This function is an abstraction of the common functionality of mocking
     * an authenticated user, bery useful for having clean code as this
     * function is used in a wide variety of tests.. especially since testing
     * non-auth prevention of functionality can usually be abstracted into the same function
     * so that would just be 1 spot where this is not being used.
     */
    protected function signIn( $user = null )
    {

        return $this->actingAs( $user ?? factory( 'App\User' )->create() );
    }
}
