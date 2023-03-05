<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $users = User::all();

        return view('user.index', [
            'users' => $users,
        ]);
    }

    public function edit($id)
    {
        $user = User::find($id);
        $this->authorize('update', $user);

        $roles = Role::all();

        return view('user.edit', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $role = Role::find($request->role);

        $this->authorize('update', $user);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($role) {
            $user->role_id = $role->id;
        } else {
            $user->role_id = null;
        }

        $user->save();

        return redirect()->route('user.index');
    }
}
