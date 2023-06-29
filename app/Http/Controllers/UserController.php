<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

		$user = new User();
		$user->name = $request->input('name');
		$user->last_name = $request->input('last_name');
		$user->age = $request->input('age');
		$user->gender = $request->input('gender');
		$user->email = $request->input('email');
		$user->password = bcrypt($request->input('password'));
		$user->save();

        return response()->json(['message' => 'User created successfully'], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'required|min:6',
        ]);

        $user = User::findOrFail($id);
		$user->name = $request->input('name');
		$user->last_name = $request->input('last_name');
		$user->age = $request->input('age');
		$user->gender = $request->input('gender');
		$user->email = $request->input('email');
		$user->password = bcrypt($request->input('password'));
        $user->save();

        return response()->json(['message' => 'User updated successfully'], 200);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }

    public function index()
    {
        $users = User::all();

        return response()->json($users, 200);
    }
}

