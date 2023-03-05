<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\LifeLog;
use App\Models\LifeLogCategory;

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
        $category = $this->createLifeLogCategory();

        $data['date'] = '2/28/2023';
        $data['message'] = 'This is a test';
        $data['category'] = $category->id;

        $result = $this->actingAS($user)->post(route('lifelog.save'), $data);

        $data['date'] = '2023-02-28';
        $data['category_id'] = $data['category'];
        unset($data['category']);

        $this->assertDatabaseHas('life_logs', $data);
    }

    public function test_life_log_save_redirects_to_life_log_management_page()
    {
        $user = $this->createUser();
        $category = $this->createLifeLogCategory();

        $data['date'] = '2/28/2023';
        $data['message'] = 'This is a test';
        $data['category'] = $category->id;

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
        $category = $this->createLifeLogCategory();

        $data['date'] = '02/28/2023';
        $data['message'] = 'This is a test';
        $data['category'] = $category->id;

        $result = $this->actingAs($user)->followingRedirects()->post(route('lifelog.save'), $data);

        $result->assertSee($data['date']);
        $result->assertSee($data['message']);
    }

    public function test_life_log_management_page_orders_entries_by_date()
    {
        $user = $this->createUser();
        $category = $this->createLifeLogCategory();
        $lifeLog2 = LifeLog::factory()->category($category)->date('2023-01-01')->create();
        $lifeLog1 = LifeLog::factory()->category($category)->date('2022-01-01')->create();
        $lifeLog3 = LifeLog::factory()->category($category)->date('2023-03-04')->create();

        $result = $this->actingAs($user)->get(route('lifelog.index'));

        $result->assertSeeInOrder([$lifeLog3->message, $lifeLog2->message, $lifeLog1->message]);
    }

    // Life Log Edit Page
    public function test_life_log_manage_page_has_link_to_edit_message()
    {
        $user = $this->createUser();
        $category = $this->createLifeLogCategory();
        $lifeLog = $this->createLifeLog();

        $result = $this->actingAs($user)->get(route('lifelog.index'));

        $result->assertSee(route('lifelog.edit', $lifeLog->id));
    }

    public function test_life_log_edit_page_loads_log_entry()
    {
        $user = $this->createUser();
        $category = $this->createLifeLogCategory();
        $lifeLog = LifeLog::factory()->category($category)->create();

        $result = $this->actingAs($user)->get(route('lifelog.edit', $lifeLog->id));

        $result->assertViewIs('lifelog.index');
        $result->assertSeeInOrder(["form", 'name="category"', "SELECTED", $lifeLog->category->name, "/form"], false);
        $result->assertSeeInOrder(["form", 'name="message"', "value=", $lifeLog->message, "/form"], false);
        $result->assertSeeInOrder(["form", 'name="date"', "value=", date('m/d/Y', strtotime($lifeLog->date)), "/form"], false);
    }

    public function test_life_log_edit_page_orders_entries_by_date()
    {
        $user = $this->createUser();
        $category = $this->createLifeLogCategory();
        $lifeLog2 = LifeLog::factory()->category($category)->date('2023-01-01')->create();
        $lifeLog1 = LifeLog::factory()->category($category)->date('2022-01-01')->create();
        $lifeLog3 = LifeLog::factory()->category($category)->date('2023-03-04')->create();

        $result = $this->actingAs($user)->get(route('lifelog.edit', $lifeLog1->id));

        $result->assertSeeInOrder([$lifeLog3->message, $lifeLog2->message, $lifeLog1->message]);
    }

    // Life Log Update Record
    public function test_life_log_update_page_updates_record()
    {
        $user = $this->createUser();
        $lifeLogCategory1 = $this->createLifeLogCategory();
        $lifeLogCategory2 = $this->createLifeLogCategory();
        $lifeLog = LifeLog::factory()->category($lifeLogCategory1)->create();

        $data = [
            'date' => '3/1/2023',
            'message' => 'This is an updated test',
            'category' => $lifeLogCategory2->id,
        ];

        $result = $this->actingAs($user)->post(route('lifelog.update', $lifeLog->id), $data);

        $data['date'] = '2023-03-01';
        $data['category_id'] = $data['category'];
        unset($data['category']);

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

    public function test_home_page_orders_life_log_entries_by_date()
    {
        $user = $this->createUser();
        $category = $this->createLifeLogCategory();
        $lifeLog2 = LifeLog::factory()->category($category)->date('2023-01-01')->create();
        $lifeLog1 = LifeLog::factory()->category($category)->date('2022-01-01')->create();
        $lifeLog3 = LifeLog::factory()->category($category)->date('2023-03-04')->create();

        $result = $this->actingAs($user)->get(route('home'));

        $result->assertSeeInOrder([$lifeLog3->message, $lifeLog2->message, $lifeLog1->message]);
    }


    // *******************
    // Life Log Categories
    // *******************

    // Dashboard Panel
    public function test_life_log_categories_panel_shows_in_dashboard()
    {
        $user = $this->createUser();

        $result = $this->actingAs($user)->get(route('dashboard'));

        $result->assertSee(route('lifelogcategory.index'));
    }

    public function test_life_log_category_count_shows_on_dashboard()
    {
        $user = $this->createUser();
        $this->createLifeLogCategory();
        $this->createLifeLogCategory();
        $this->createLifeLogCategory();

        $result = $this->actingAs($user)->get(route('dashboard'));

        $result->assertSeeInOrder([__('Categories'), "3", __('Manage')], false);
    }

    // Management Page
    public function test_life_log_categories_management_page_loads()
    {
        $user = $this->createUser();

        $result = $this->actingAs($user)->get(route('lifelogcategory.index'));

        $result->assertStatus(200);
        $result->assertViewIs('lifelog.categories');
    }

    public function test_life_log_categories_show_on_management_page()
    {
        $user = $this->createUser();
        $category = $this->createLifeLogCategory();

        $result = $this->actingAs($user)->get(route('lifelogcategory.index'));

        $result->assertSee($category->name);
    }

    public function test_life_log_categories_have_edit_button()
    {
        $user = $this->createUser();
        $category = $this->createLifeLogCategory();

        $result = $this->actingAs($user)->get(route('lifelogcategory.index'));

        $result->assertSee(route('lifelogcategory.edit', $category->id));
    }

    // New Category
    public function test_life_log_category_managemnt_has_create_form()
    {
        $user = $this->createUser();

        $result = $this->actingAs($user)->get(route('lifelogcategory.index'));

        $result->assertSee(route('lifelogcategory.save'));
        $result->assertSee('input type="submit"', false);
    }

    // Save New Category
    public function test_life_log_category_create_form_saves_to_database()
    {
        $user = $this->createUser();
        $data['name'] = 'This is a test';
        $data['icon'] = 'fa-solid fa-house';
        $data['color'] = 'primary';

        $result = $this->actingAS($user)->post(route('lifelogcategory.save'), $data);

        $this->assertDatabaseHas('life_log_categories', $data);
    }

    public function test_life_log_category_create_form_redirects_to_index()
    {
        $user = $this->createUser();
        $data['name'] = 'This is a test';
        $data['icon'] = 'fa-solid fa-house';
        $data['color'] = 'primary';

        $result = $this->actingAS($user)->post(route('lifelogcategory.save'), $data);

        $result->assertRedirect(route('lifelogcategory.index'));
    }

    // Category Edit Page
    public function test_life_log_category_test_page_loads()
    {
        $user = $this->createUser();
        $category = $this->createLifeLogCategory();

        $result = $this->actingAs($user)->get(route('lifelogcategory.edit', $category->id));

        $result->assertSee(route('lifelogcategory.update', $category->id));
        $result->assertSeeInOrder(["form", 'name="name"', "value=", $category->name, "/form"], false);
        $result->assertSeeInOrder(["form", 'name="icon"', "value=", $category->icon, "/form"], false);
        $result->assertSeeInOrder(["form", 'name="color"', "value=", $category->color, "/form"], false);
        $result->assertSee('input type="submit"', false);
    }

    // Category Update
    public function test_life_log_category_update_saves_record()
    {
        $user = $this->createUser();
        $category = $this->createLifeLogCategory();

        $data = [
            'icon' => 'fa-solid fa-image',
            'color' => 'accent',
            'name' => 'Updated Category',
        ];

        $result = $this->actingAs($user)->post(route('lifelogcategory.update', $category->id), $data);

        $this->assertDatabaseHas('life_log_categories', $data);
    }

    public function test_life_log_category_update_redirects_to_manage_page()
    {
        $user = $this->createUser();
        $category = $this->createLifeLogCategory();

        $data = [
            'icon' => 'fa-solid fa-image',
            'color' => 'accent',
            'name' => 'Updated Category',
        ];

        $result = $this->actingAs($user)->post(route('lifelogcategory.update', $category->id), $data);

        $result->assertRedirect(route('lifelogcategory.index'));
    }

    // Life Log Category Usage
    public function test_category_can_be_selected_on_life_log_new_form()
    {
        $user = $this->createUser();
        $category = $this->createLifeLogCategory();

        $result = $this->actingAs($user)->get(route('lifelog.index'));

        $result->assertSeeInOrder(['Create Life Log Entry', $category->name, 'Add Life Log']);
    }

    public function test_life_log_entry_page_adds_category()
    {
        $user = $this->createUser();
        $category = $this->createLifeLogCategory();

        $data = [
            'date' => '3/3/2023',
            'message' => 'Testing',
            'category' => $category->id,
        ];

        $result = $this->actingAs($user)->post(route('lifelog.save'), $data);

        $data['date'] = '2023-03-03';
        $data['category_id'] = $data['category'];
        unset($data['category']);

        $this->assertDatabaseHas('life_logs', $data);
    }

    public function test_life_log_does_not_show_on_dashboard_for_regular_users()
    {
        $user = $this->createUser('guest');

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertDontSee(__('Life Log Stats'));
        $response->assertDontSee(route('lifelog.index'));
    }

    public function test_life_log_management_page_not_usable_by_guests()
    {
        $response = $this->get(route('lifelog.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_life_log_management_page_not_usable_by_reg_users()
    {
        $user = $this->createUser('guest');

        $response = $this->actingAs($user)->get(route('lifelog.index'));

        $response->assertStatus(403);
    }

    public function test_reg_user_cannot_edit_life_log()
    {
        $user = $this->createUser('guest');
        $lifeLog = $this->createLifeLog();

        $response = $this->actingAs($user)->get(route('lifelog.edit', $lifeLog->id));

        $response->assertStatus(403);
    }

    public function test_reg_user_cannot_update_life_log()
    {
        $user = $this->createUser('guest');
        $lifeLog = $this->createLifeLog();
        $data = $this->getLifeLogData('update');

        $response = $this->actingAs($user)->post(route('lifelog.update', $lifeLog->id), $data);

        $data = $this->translateDataToDatabse($data, 'update');
        $response->assertStatus(403);
        $this->assertDatabaseMissing('life_logs', $data);
    }

    public function test_reg_user_cannot_create_life_log()
    {
        $user = $this->createUser('guest');

        $response = $this->actingAs($user)->get(route('lifelog.create'));

        $response->assertStatus(403);
    }

    public function test_reg_user_cannot_save_a_new_life_log()
    {
        $user = $this->createUser('guest');
        $data = $this->getLifeLogData('new');
        $category = $this->createLifeLogCategory();

        $response = $this->actingAs($user)->post(route('lifelog.save'), $data);

        $data = $this->translateDataToDatabse($data, 'new');
        $response->assertStatus(403);
        $this->assertDatabaseMissing('life_logs', $data);
    }

    public function test_admins_can_create_life_log()
    {
        $user = $this->createUser('Admin');
        $data = $this->getLifeLogData('new');
        $category = $this->createLifeLogCategory();
        $data['category'] = $category->id;

        $response = $this->actingAs($user)->post(route('lifelog.save'), $data);

        $data = $this->translateDataToDatabse($data, 'new');
        $this->assertDatabaseHas('life_logs', $data);
    }

    public function test_admins_can_edit_life_log_entries()
    {
        $user = $this->createUser('Admin');
        $lifeLog = $this->createLifeLog();
        $data = $this->getLifeLogData('update');

        $response = $this->actingAs($user)->post(route('lifelog.update', $lifeLog->id), $data);

        $data = $this->translateDataToDatabse($data, 'update');
        $this->assertDatabaseHas('life_logs', $data);
    }

    public function test_admins_can_see_life_log_management_links_on_dashboard()
    {
        $user = $this->createUser('Admin');

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSee(route('lifelog.index'));
    }

    public function test_guests_cannot_see_life_log_edit_button_on_homepage()
    {
        $lifeLog = $this->createLifeLog();
        
        $response = $this->get(route('home'));

        $response->assertDontSee('Edit Life Log');
    }

    // Helper Functions
    private function createLifeLog()
    {
        $this->createLifeLogCategory();
        return LifeLog::factory()->create();
    }

    private function createLifeLogCategory()
    {
        return LifeLogCategory::factory()->create();
    }

    private function getLifeLogData($type)
    {
        $data = array();

        if ($type == 'update' || $type == 'new') {
            $data = [
                'date' => '3/6/2023',
                'message' => 'This is a test message',
                'category' => 1,
            ];
        }

        return $data;
    }

    private function translateDataToDatabse(array $data, String $type)
    {
        if ($type == 'update' || $type == 'new') {
            $data['date'] = date('Y-m-d', strtotime($data['date']));
            $data['category_id'] = $data['category'];
            unset($data['category']);
        }

        return $data;
    }
}
