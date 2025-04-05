<?php

namespace App\Http\Controllers;

use App\Models\Edit_profile_model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class Edit_profile extends Controller
{
    // Restrict access only to Admin users
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // Check if user is logged in
            if (!Auth::check()) {
                return redirect()->route('home')->with('error', 'Please log in to access this page.');
            }

         
            return $next($request);
        });
    }

    // Show the edit user form
    public function Edit_profile($id)
    {
        $user = Edit_profile_model::getUserById($id);
        return view('edit_profile', compact('user'));
    }



    public function update(Request $request, $id)
    {
        // Log::info('Received AJAX request', $request->all());
        Log::channel('database')->info('Received AJAX registration request', ['data' => $request->all()]);

        if (!$request->ajax()) return redirect()->route('Edit_profile');

        // Validate the input data
        $validated_data = $request->validate([
            'name'   => 'required|string|min:6|max:50',
            'mobile' => 'required|numeric|digits:10',
            'gender' => 'required|string',
            'image'  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        // Prepare data for update
        $data = [
            'name'   => $validated_data['name'],
            'mobile' => $validated_data['mobile'],
            'gender' =>$validated_data['gender']
        ];
    
        // If an image is uploaded
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $data['image'] = $imageName;
        }
    
        // Update user data
        $result = Edit_profile_model::update_user($id, $data);
    
        // Return success or error response
        if ($result) {
            return response()->json([
                'status' => 'success',
                'message' => 'Profile updated successfully',
                'redirect' => route('home')
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update profile'
            ]);
        }
    }
    

}
