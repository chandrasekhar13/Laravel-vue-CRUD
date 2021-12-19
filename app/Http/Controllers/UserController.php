<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    // Get all the existing users
    public function index()
    {
        $users = User::all()->toArray();
        return array_reverse($users);
    }

    //Store the user with validation
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'mobile' => 'required|unique:users',
            'country' => 'required',
            'author' => 'required',

        ]);
        $users = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'mobile' => $request->input('mobile'),
            'country' => $request->input('country'),
            'author' => $request->input('author'),
            'status' => $request->input('status'),

        ]);
        $users->save();

        return response()->json('User created!');
    }

    //show a specific user while editing the form
    public function show($id)
    {
        $users = User::find($id);
        return response()->json($users);
    }

    //update the existing user
    public function update($id, Request $request)
    {
        $users = User::find($id);
        $users->update($request->all());
       
        return response()->json('User updated!');
    }

    //delete the existing user
    public function destroy($id)
    {
        $users = User::find($id);
        $users->delete();

        return response()->json('User deleted!');
    }
}