<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;


    protected function signIn($user = null){

       return $this->actingAs(factory($user ?: User::class)->create());

    }
}
