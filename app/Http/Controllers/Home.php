<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Home_model;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Routing\Controller;

class Home extends Controller
{
    

    // A method to get decrypted users excluding the logged-in user
    public function Home_data()
    {
        return view('Home', ['users' => Home_model::Get_decrypted_users()]);
    }
    



public function fetch_users(Request $request)
{
    if ($request->ajax()) {
        $users = Home_model::Get_decrypted_users($request->start_date, $request->end_date);
        $auth_user = Auth::user();

        return DataTables::of($users)
            ->editColumn('created_on', function($row) {
                return date('Y-m-d', strtotime($row->created_on)); // Format date as 'Y-m-d'
            })
            ->addColumn('action', function ($row) use ($auth_user) {
                if ($auth_user->user_type == 'admin') {
                    return '
                        <button class="btn btn-primary edit-btn" data-id="' . $row->id . '">Edit</button>
                        <button class="btn btn-danger delete-btn" data-id="' . $row->id . '">Delete</button>
                    ';
                }
                return '';
            })
            ->rawColumns(['action'])
            ->make(true); // Make it in JSON format
    }

    return view('Home');
}



    public function Delete_user($id)
    {
        // Find the user by ID
        $user = Home_model::find($id);

        // Check if user exists
        if ($user) {
            // Delete the user from the database
            $user->delete();

            // Return a success response (JSON or redirect, depending on the context)
            return response()->json(['success' => 'User deleted successfully.']);
        }

        // If user not found, return an error message
        return response()->json(['error' => 'User not found.'], 404);
    }
}
