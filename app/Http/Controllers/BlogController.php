<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
// use GrahamCampbell\Markdown\Facades\Markdown;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::all();

        return view('blog.index', [
            'blogs' => $blogs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $blog = new Blog();
        $blog->fill($request->all());
        $blog->date = $this->translateDateForStorage($request->date);
        $blog->save();

        return redirect()->route('blog.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = Blog::find($id);

        return view('blog.edit', [
            'blog' => $blog,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $blog = Blog::find($id);

        $blog->fill($request->all());
        $blog->date = $this->translateDateForStorage($request->date);
        $blog->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function translateDateForStorage($date)
    {
        return date('Y-m-d', strtotime($date));
    }
}
