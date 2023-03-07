<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Blog;

class BlogControllerTest extends TestCase
{
    use RefreshDatabase;

    // Create dashboard panel with blog manager links
    public function test_new_blog_link_shows_on_dashboard()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSee(route('blog.create'));
    }

    // Create a blog creation page
    public function test_blog_create_page_loads()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->get(route('blog.create'));

        $response->assertStatus(200);
        $response->assertViewIs('blog.create');
    }

    public function test_blog_create_page_has_form_to_blog_save()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->get(route('blog.create'));

        $todaysDate = 'value="' . date('m/d/Y') . '"';
        $response->assertSee(route('blog.store'));
        $response->assertSee('name="title"', false);
        $response->assertSee('name="slug"', false);
        $response->assertSee('name="date"', false);
        $response->assertSee('name="status"', false);
        $response->assertSee($todaysDate, false);
        $response->assertSee('name="text"', false);
        $response->assertSee('type="submit"', false);
    }

    public function test_blog_save_adds_data_to_database()
    {
        $user = $this->createUser();
        $data = $this->getBlogPostData('create');

        $response = $this->actingAs($user)->post(route('blog.store'), $data);
   
        $data = $this->translateDataForDB($data);
        $this->assertDatabaseHas('blogs', $data);
    }

    public function test_blog_save_redirects_to_blog_list_after_save()
    {
        $user = $this->createUser();
        $data = $this->getBlogPostData('create');

        $response = $this->actingAs($user)->post(route('blog.store'), $data);
   
        $response->assertRedirect(route('blog.index'));
    }

    // List all blogs on blog view page
    public function test_blog_index_page_loads()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->get(route('blog.index'));

        $response->assertStatus(200);
        $response->assertViewIs('blog.index');
    }

    public function test_blog_entries_show_up_on_blog_index_page()
    {
        $user = $this->createUser();
        $blog = Blog::factory()->create();

        $response = $this->actingAs($user)->get(route('blog.index'));
        
        $response->assertSee($blog->title);
        $response->assertSee($blog->date);
        $response->assertSee(ucfirst($blog->status));
    }

    // Edit blog entries
    public function test_blog_index_has_link_to_edit_posts()
    {
        $user = $this->createUser();
        $blog = Blog::factory()->create();

        $response = $this->actingAs($user)->get(route('blog.index'));

        $response->assertSee(route('blog.edit', $blog->id));
    }

    public function test_blog_edit_page_loads()
    {
        $user = $this->createUser();
        $blog = Blog::factory()->create();

        $response = $this->actingAs($user)->get(route('blog.edit', $blog->id));

        $response->assertStatus(200);
        $response->assertViewIs('blog.edit');
    }

    public function test_blog_edit_page_loads_blog_entry()
    {
        $user = $this->createUser();
        $blog = Blog::factory()->create();

        $response = $this->actingAs($user)->get(route('blog.edit', $blog->id));

        $response->assertSee($blog->text);
        $response->assertSee("value=\"{$blog->date}\"", false);
        $response->assertSee("value=\"{$blog->title}\"", false);
        $response->assertSee("value=\"{$blog->slug}\"", false);
    }

    public function test_blog_update_saves_data_to_database()
    {
        $user = $this->createUser();
        $blog = Blog::factory()->create();
        $data = $this->getBlogPostData('update');

        $response = $this->actingAs($user)->post(route('blog.update', $blog->id), $data);

        $data = $this->translateDataForDB($data);
        $this->assertDatabaseHas('blogs', $data);
    }

    // Create a public blog list page
    public function test_public_blog_page_loads()
    {
        $response = $this->get(route('blogs'));

        $response->assertStatus(200);
        $response->assertViewIs('blog.viewAll');
    }

    public function test_public_blog_page_lists_all_entries()
    {
        $blog = Blog::factory()->create();

        $response = $this->get(route('blogs'));

        $response->assertSee($blog->title);
    }

    public function test_public_blog_page_has_link_to_view_single_blog()
    {
        $blog = Blog::factory()->create();

        $response = $this->get(route('blogs'));

        $response->assertSee(route('blogs.view', $blog->slug));
    }

    // Create a public blog view page
    public function test_blog_view_page_loads()
    {
        $blog = Blog::factory()->create();

        $response = $this->get(route('blogs.view', $blog->slug));

        $response->assertStatus(200);
        $response->assertViewIs('blog.view');
    }

    public function test_blog_view_page_loads_blog_post()
    {
        $blog = Blog::factory()->create();

        $response = $this->get(route('blogs.view', $blog->slug));

        $response->assertSee($blog->title);
    }

    // Get markdown editor working

    // Dispaly blog entries on home page???? Mixed with recent lif log events

    // Add security to the blog dashboard pages

    // Add validation to the blog inputs

    private function getBlogPostData($type)
    {
        $data = array();

        if ($type == 'create' || $type = 'update') {
            $data['title'] = 'This is a blog article';
            $data['slug'] = 'test-blog-article';
            $data['date'] = date('d/m/Y');
            $data['status'] = 'draft';
            $data['text'] = "This is a bunch of text.\n=================\n[My Website](https://jlzenor.com)";
        }

        return $data;
    }

    private function translateDataForDB($data)
    {
        $data['date'] = date('Y-m-d', strtotime($data['date']));

        return $data;
    }
}
