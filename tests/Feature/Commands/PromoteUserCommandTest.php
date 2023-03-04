<?php

namespace Tests\Feature\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PromoteUserCommandTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_promote_user_command_exists()
    {
        $user = $this->createUser('guest');

        $response = $this->artisan("user:promote {$user->email}");

        $response->assertExitCode(0);
    }

    public function promote_user_command_sets_user_as_super_admin()
    {
        $user = $this->createUser('guest');

        $response = $this->artisan("user:promote {$user->email}")->assertSuccessful();

        $role = Role::where('name', '=', 'Super Admin')->first();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'role_id' => $role->id
        ]);
    }

    public function test_promote_user_command_gives_output()
    {
        $user = $this->createUser('guest');

        $response = $this->artisan("user:promote {$user->email}");

        $response->expectsOutput("User {$user->name} was promoted to Super Admin");
    }
}
