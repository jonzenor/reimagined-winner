<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\LifeLog;

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

    // Life Log Dashboard Panel
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

    public function test_life_log_count_shows_on_dashboard()
    {
        $user = $this->createUser();
        $this->createLifeLog();
        $this->createLifeLog();

        $result = $this->actingAs($user)->get(route('dashboard'));

        $result->assertSeeInOrder([__('Log Entries'), "2", __('Manage')], false);
    }

    // New Life Log
    public function test_life_log_new_page_loads()
    {
        $user = $this->createUser();

        $result = $this->actingAs($user)->get(route('lifelog.create'));

        $result->assertStatus(200);
        $result->assertViewIs('lifelog.index');
    }

    public function test_life_log_create_page_has_creation_form()
    {
        $user = $this->createUser();

        $result = $this->actingAs($user)->get(route('lifelog.create'));

        $result->assertSee(route('lifelog.save'));
        $result->assertSee('input type="submit"', false);
    }

    public function test_life_log_create_page_has_back_button()
    {
        $user = $this->createUser();

        $result = $this->actingAs($user)->get(route('lifelog.create'));

        $result->assertSee(route('dashboard'));
        $result->assertSee(__('Back to Dashboard'));
    }

    // Life Log Save New
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

    // Life Log Index / Management
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

        $result = $this->actingAs($user)->followingRedirects()->post(route('lifelog.save'), $data);

        $result->assertSee($data['date']);
        $result->assertSee($data['message']);
    }

    // Life Log Edit Page
    public function test_life_log_manage_page_has_link_to_edit_message()
    {
        $user = $this->createUser();
        $lifeLog = $this->createLifeLog();

        $result = $this->actingAs($user)->get(route('lifelog.index'));

        $result->assertSee(route('lifelog.edit', $lifeLog->id));
    }

    public function test_life_log_edit_page_loads_log_entry()
    {
        $user = $this->createUser();
        $lifeLog = $this->createLifeLog();

        $result = $this->actingAs($user)->get(route('lifelog.edit', $lifeLog->id));

        $result->assertViewIs('lifelog.index');
        $result->assertSeeInOrder(["form", 'name="message"', "value=", $lifeLog->message, "/form"], false);
        $result->assertSeeInOrder(["form", 'name="date"', "value=", date('m/d/Y', strtotime($lifeLog->date)), "/form"], false);
    }

    // Life Log Update Record
    public function test_life_log_update_page_updates_record()
    {
        $user = $this->createUser();
        $lifeLog = $this->createLifeLog();

        $data = [
            'date' => '3/1/2023',
            'message' => 'This is an updated test',
        ];

        $result = $this->actingAs($user)->post(route('lifelog.update', $lifeLog->id), $data);

        $data['date'] = '2023-03-01';

        $this->assertDatabaseHas('life_logs', $data);
    }

    // Life Log on Home Page
    public function test_life_log_entries_show_on_home_page()
    {
        $lifeLog = $this->createLifeLog();

        $result = $this->get(route('home'));

        $result->assertSee($lifeLog->message);
        $result->assertSee(date('m/d/Y', strtotime($lifeLog->date)));
    }

    // Helper Functions
    private function createLifeLog()
    {
        return LifeLog::factory()->create();
    }
}
