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
}
