<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LifeLogControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_life_log_control_panel_shows_in_dashboard()
    {
        $user = $this->createUser();

        $result = $this->actingAs($user)->get(route('dashboard'));

        $result->assertSee(route('lifelog.index'));
    }

    public function test_life_log_control_panel_shows_new_button()
    {
        $user = $this->createUser();

        $result = $this->actingAs($user)->get(route('dashboard'));

        $result->assertSee(route('lifelog.create'));
    }

    public function test_life_log_new_page_loads()
    {
        $user = $this->createUser();

        $result = $this->actingAs($user)->get(route('lifelog.create'));

        $result->assertStatus(200);
        $result->assertViewIs('lifelog.create');
    }

    public function test_life_log_create_page_has_creation_form()
    {
        $user = $this->createUser();

        $result = $this->actingAs($user)->get(route('lifelog.create'));

        $result->assertSee(route('lifelog.save'));
        $result->assertSee('input type="submit"', false);
    }

    public function test_life_log_save_form_saves_data()
    {
        $user = $this->createUser();

        $data['date'] = '2/28/2023';
        $data['message'] = 'This is a test';

        $result = $this->actingAS($user)->post(route('lifelog.save'), $data);

        $data['date'] = '2023-02-28';

        $this->assertDatabaseHas('life_logs', $data);
    }

    public function test_life_log_save_redirects_to_life_log_management_page()
    {
        $user = $this->createUser();

        $data['date'] = '2/28/2023';
        $data['message'] = 'This is a test';

        $result = $this->actingAS($user)->post(route('lifelog.save'), $data);

        $result->assertRedirect(route('lifelog.index'));
    }

    public function test_life_log_manage_page_displays_view()
    {
        $user = $this->createUser();

        $result = $this->actingAs($user)->get(route('lifelog.index'));

        $result->assertStatus(200);
        $result->assertViewIs('lifelog.index');
    }

    public function test_life_log_manage_page_has_link_back_to_dashboard()
    {
        $user = $this->createUser();

        $result = $this->actingAs($user)->get(route('lifelog.index'));

        $result->assertSee(route('dashboard'));
        $result->assertSee(__('Back to Dashboard'));
    }

    public function test_life_log_management_page_shows_entries()
    {
        $user = $this->createUser();

        $data['date'] = '02/28/2023';
        $data['message'] = 'This is a test';

        $result = $this->actingAS($user)->followingRedirects()->post(route('lifelog.save'), $data);

        $result->assertSee($data['date']);
        $result->assertSee($data['message']);
    }
}
