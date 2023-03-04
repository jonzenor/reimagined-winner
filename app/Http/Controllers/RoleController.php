<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();

        return view('role.index', [
            'roles' => $roles,
        ]);
    }

    public function edit($id)
    {
        $role = Role::find($id);

        return view('role.edit', [
            'role' => $role,
        ]);
    }

    public function update(Request $request, $id)
    {
        $role = Role::find($id);

        $role->name = $request->name;
        $role->color = $request->color;
        $role->save();

        return redirect()->route('role.index');
    }
}
