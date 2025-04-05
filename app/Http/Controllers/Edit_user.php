<?php

namespace App\Http\Controllers;

use App\Models\Edit_user_model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;


class Edit_user extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Show the edit user form
    public function edit($id)
    {
        $user = Edit_user_model::getUserById($id);

        if (Auth::user()->id != $user->id && Auth::user()->user_type !== 'admin') {
            return redirect()->route('home')->with('error', 'You are not authorized to edit this user');
        }

        return view('Edit_user', compact('user'));
    }

    // Update the user data
    public function update_user(Request $request, $id)
    {
        // Log::info('Received AJAX request', $request->all());
                Log::channel('database')->info('Received AJAX registration request', ['data' => $request->all()]);

        if (!$request->ajax()) return redirect()->route('Edit_user');

        // Validate the input data
        $validated = $request->validate([
            'name'   => 'required|string|min:6|max:50',
            'mobile' => 'required|digits:10',
            'gender' => 'required|in:male,female',
        ], [
            'name.required'  => 'Name is required!',
            'name.min'       => 'Name must be at least 6 characters long!',
            'mobile.required'=> 'Mobile number is required!',
            'mobile.digits'  => 'Mobile number must be exactly 10 digits!',
            'gender.required'=> 'Please select a gender!',
        ]);

        // Attempt to update user data
        $result = Edit_user_model::update_user($id, $validated);

        return $result 
            ? response()->json(['status' => 'success', 'message' => 'User updated successfully', 'redirect' => route('home')])
            : response()->json(['status' => 'error', 'message' => 'Failed to update user.']);
    }
}
