<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_user_manager_shows_in_dashboard()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSee(route('user.index'));
    }

    public function test_user_manager_page_loads()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->get(route('user.index'));

        $response->assertStatus(200);
        $response->assertViewIs('user.index');
    }

    public function test_user_manager_page_has_dashboard_link()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->get(route('user.index'));
        
        $response->assertSeeInOrder(['Users', route('dashboard')]);
    }

    public function test_users_show_on_index_page()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->get(route('user.index'));
        
        $response->assertSeeInOrder(['Users', $user->name]);
        $response->assertSeeInOrder(['Users', route('user.edit', $user->id)]);
    }

    public function test_user_edit_page_loads()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->get(route('user.edit', $user->id));

        $response->assertStatus(200);
        $response->assertViewIs('user.edit');
    }

    public function test_user_edit_page_loads_user()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->get(route('user.edit', $user->id));

        $response->assertSee(route('user.update', $user->id));
        $response->assertSee("value=\"$user->name\"", false);
        $response->assertSee("value=\"$user->email\"", false);
        $response->assertSee(__("Update User"));
    }

    public function test_user_count_shows_on_dashboard()
    {
        $user = $this->createUser();
        $this->createUser();
        $this->createUser();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSeeInOrder(['Users', '3', 'Manage']);
    }

    public function test_user_update_saves_user_data()
    {
        $admin = $this->createUser();
        $user = $this->createUser();
        $data = [
            'name' => 'River',
            'email' => 'River@InTheDark.serenty',
        ];

        $response = $this->actingAs($admin)->post(route('user.update', $user->id), $data);

        $this->assertDatabaseHas('users', $data);
    }

    public function test_user_update_redirects_to_user_manager()
    {
        $admin = $this->createUser();
        $user = $this->createUser();
        $data = [
            'name' => 'River',
            'email' => 'River@InTheDark.serenty',
        ];

        $response = $this->actingAs($admin)->post(route('user.update', $user->id), $data);

        $response->assertRedirect(route('user.index'));
    }

    public function test_reg_users_do_not_see_user_stats_on_dashboard()
    {
        $user = $this->createUser('guest');

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertDontSee('User Stats');
        $response->assertDontSee(route('user.index'));
    }

    public function test_reg_users_can_not_load_user_management_page()
    {
        $user = $this->createUser('guest');

        $response = $this->actingAs($user)->get(route('user.index'));

        $response->assertStatus(403);
    }

    public function test_reg_user_cannot_load_user_edit_page()
    {
        $user = $this->createUser('guest');
        $dummyUser = $this->createUser();

        $response = $this->actingAs($user)->get(route('user.edit', $dummyUser->id));

        $response->assertStatus(403);
    }

    public function test_reg_user_cannot_update_a_user()
    {
        $user = $this->createUser('guest');
        $dummyUser = $this->createUser();

        $data['name'] = 'Bob';
        $data['email'] = 'Attacked@hacker.com';
        $data['role'] = 1;

        $response = $this->actingAs($user)->post(route('user.update', $dummyUser->id), $data);

        $data['role_id'] = $data['role'];
        unset($data['role']);

        $this->assertDatabaseMissing('users', $data);
    }

    public function test_regu_user_cannot_load_role_manager_page()
    {
        $user = $this->createUser('guest');

        $response = $this->actingAs($user)->get(route('role.index'));

        $response->assertStatus(403);
    }

    public function test_regu_user_cannot_load_role_edit_page()
    {
        $user = $this->createUser('guest');

        $response = $this->actingAs($user)->get(route('role.edit', 1));

        $response->assertStatus(403);
    }

    public function test_reg_user_cannot_update_a_role()
    {
        $user = $this->createUser('guest');

        $data['name'] = 'Pwned';
        $data['color'] = 'error';

        $response = $this->actingAs($user)->post(route('role.update', 1), $data);

        $this->assertDatabaseMissing('roles', $data);
    }
}
