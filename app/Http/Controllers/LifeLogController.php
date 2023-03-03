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
        $lifeLogs = LifeLog::all();

        return view('lifelog.index', [
            'lifeLogs' => $lifeLogs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lifelog.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $lifeLog = new LifeLog();
        $lifeLog->date = Carbon::createFromFormat('n/j/Y', $request->date)->format('Y-m-d');
        $lifeLog->message = $request->message;
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
    public function edit(string $id)
    {
        $editLog = LifeLog::find($id);
        $lifeLogs = LifeLog::all();

        return view('lifelog.index', [
            'lifeLogs' => $lifeLogs,
            'editLifeLog' => $editLog,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $lifeLog = LifeLog::find($id);
        $lifeLog->date = Carbon::createFromFormat('n/j/Y', $request->date)->format('Y-m-d');
        $lifeLog->message = $request->message;
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
