<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_role_manager_shows_in_dashboard()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSee(route('role.index'));
    }

    public function test_role_count_shows_on_dashboard()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSeeInOrder(['Roles', '3', 'Manage']);
    }

    public function test_role_list_shows_in_user_edit_page()
    {
        $admin = $this->createUser();
        $user = $this->createUser();

        $response = $this->actingAs($admin)->get(route('user.edit', $user->id));

        $response->assertSee('Super Admin');
        $response->assertSee('Admin');
        $response->assertSee('Friends & Family');
    }

    public function test_user_edit_page_saves_role_to_user()
    {
        $admin = $this->createUser();
        $user = $this->createUser();
        $role = Role::where('name', '=', 'Friends & Family')->first();
        
        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $role->id,
        ];

        $response = $this->actingAs($admin)->post(route('user.update', $user->id), $data);

        $data['role_id'] = $data['role'];
        unset($data['role']);

        $this->assertDatabaseHas('users', $data);
    }

    public function test_user_update_removes_role_from_user()
    {
        $admin = $this->createUser();
        $user = User::factory()->role(3)->create();

        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'role' => 0,
        ];

        $response = $this->actingAs($admin)->post(route('user.update', $user->id), $data);

        $data['role_id'] = null;
        unset($data['role']);

        $this->assertDatabaseHas('users', $data);
    }

    public function test_users_role_shows_on_user_list()
    {
        $admin = $this->createUser();
        $role = Role::where('name', '=', 'Friends & Family')->first();
        $user = User::factory()->role($role->id)->create();
        
        $response = $this->actingAs($admin)->get(route('user.index'));

        $response->assertSee($role->name);
    }

    public function test_role_manager_page_loads()
    {
        $admin = $this->createUser();

        $response = $this->actingAs($admin)->get(route('role.index'));

        $response->assertStatus(200);
        $response->assertViewIs('role.index');
    }

    public function test_roles_show_on_role_manager_page()
    {
        $admin = $this->createUser();

        $response = $this->actingAs($admin)->get(route('role.index'));

        $response->assertSee('Super Admin');
        $response->assertSee('Admin');
        $response->assertSee('Friends & Family');
    }

    public function test_role_manager_has_link_to_edit_roles()
    {
        $admin = $this->createUser();
        $roles = Role::all();

        $response = $this->actingAs($admin)->get(route('role.index'));

        foreach ($roles as $role) {
            $response->assertSee(route('role.edit', $role->id));
        }
    }

    public function test_role_edit_page_loads()
    {
        $admin = $this->createUser();
        $role = Role::where('name', '=', 'Super Admin')->first();

        $response = $this->actingAs($admin)->get(route('role.edit', $role->id));

        $response->assertStatus(200);
        $response->assertViewIs('role.edit');
        $response->assertSee(route('role.update', $role->id));
        $response->assertSee("value=\"{$role->name}\"", false);
    }

    public function test_role_update_saves_info()
    {
        $admin = $this->createUser();
        $role = Role::where('name', '=', 'Super Admin')->first();

        $data = [
            'name' => "Jedi Master",
            'color' => 'error',
        ];

        $response = $this->actingAs($admin)->post(route('role.update', $role->id), $data);

        $this->assertDatabaseHas('roles', $data);
    }

    public function test_role_update_redirects_to_role_manage_page()
    {
        $admin = $this->createUser();
        $role = Role::where('name', '=', 'Super Admin')->first();

        $data = [
            'name' => "Jedi Master",
            'color' => 'error',
        ];

        $response = $this->actingAs($admin)->post(route('role.update', $role->id), $data);

        $response->assertRedirect(route('role.index'));
    }

    public function test_role_edit_page_has_link_back_to_roles_index()
    {
        $admin = $this->createUser();
        $role = Role::where('name', '=', 'Super Admin')->first();

        $response = $this->actingAs($admin)->get(route('role.edit', $role->id));

        $response->assertSee(route('role.index'));
    }
}
