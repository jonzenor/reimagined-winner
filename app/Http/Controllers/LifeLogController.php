<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LifeLog;
use App\Models\LifeLogCategory;
use Carbon\Carbon;

class LifeLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', LifeLog::class);

        $lifeLogs = LifeLog::orderByDesc('date')->get();
        $categories = LifeLogCategory::all();

        return view('lifelog.index', [
            'lifeLogs' => $lifeLogs,
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', LifeLog::class);

        $lifeLogs = LifeLog::orderByDesc('date')->get();
        $categories = LifeLogCategory::all();

        return view('lifelog.index', [
            'lifeLogs' => $lifeLogs,
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', LifeLog::class);
        
        $category = LifeLogCategory::find($request->category);

        $lifeLog = new LifeLog();
        $lifeLog->date = Carbon::createFromFormat('n/j/Y', $request->date)->format('Y-m-d');
        $lifeLog->message = $request->message;
        $lifeLog->category_id = $category->id;
        $lifeLog->save();

        return redirect()->route('lifelog.index');
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
    public function edit(String $id)
    {
        $lifeLog = LifeLog::find($id);
        $this->authorize('update', $lifeLog);

        $lifeLogs = LifeLog::orderByDesc('date')->get();
        $categories = LifeLogCategory::all();

        return view('lifelog.index', [
            'lifeLogs' => $lifeLogs,
            'editLifeLog' => $lifeLog,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $lifeLog = LifeLog::find($id);

        $this->authorize('update', $lifeLog);

        $lifeLog->date = Carbon::createFromFormat('n/j/Y', $request->date)->format('Y-m-d');
        $lifeLog->message = $request->message;
        $lifeLog->category_id = $request->category;
        $lifeLog->save();

        return redirect()->route('lifelog.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function categoryIndex()
    {
        $categories = LifeLogCategory::all();

        return view('lifelog.categories', [
            'categories' => $categories,
        ]);
    }

    public function categoryStore(Request $request)
    {
        $category = new LifeLogCategory;

        $category->name = $request->name;
        $category->icon = $request->icon;
        $category->color = $request->color;
        $category->save();

        return redirect()->route('lifelogcategory.index');
    }

    public function categoryEdit($id)
    {
        $category = LifeLogCategory::find($id);
        $categories = LifeLogCategory::all();

        return view('lifelog.categories', [
            'editCategory' => $category,
            'categories' => $categories,
        ]);
    }

    public function categoryUpdate(Request $request, $id)
    {
        $category = LifeLogCategory::find($id);

        $category->icon = $request->icon;
        $category->color = $request->color;
        $category->name = $request->name;
        $category->save();

        return redirect()->route('lifelogcategory.index');
    }
}
