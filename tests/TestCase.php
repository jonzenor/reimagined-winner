<?php

namespace Tests;

use App\Models\Role;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function createUser($role = 'Super Admin')
    {
        if ($role != "guest") {
            $role = Role::where('name', '=', $role)->first();
            $user = User::factory()->role($role->id)->create();
        } else {
            $user = User::factory()->create();
        }

        return $user;
    }
}
