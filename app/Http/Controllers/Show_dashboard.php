<?php

namespace App\Http\Controllers;

use App\Models\Dashboard_model;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class Show_dashboard extends Controller
{
    public function Dashboard()
    {
        return view('show_dashboard');
    }

    // Handle the AJAX request for DataTables
    public function home_user(Request $request)
    {
        if ($request->ajax()) {
            try {
                // Fetch user data using Eloquent ORM
                $users = Dashboard_model::select('id', 'name', 'email', 'mobile', 'gender', 'user_type')->get();
    
                // Decrypt sensitive fields
                $users->transform(function ($user) {
                    try {
                        $user->email = Crypt::decrypt($user->email);
                        $user->mobile = Crypt::decrypt($user->mobile);
                    } catch (DecryptException $e) {
                        $user->email = 'Decryption error';
                        $user->mobile = 'Decryption error';
                    }
                    return $user;
                });
    
                return DataTables::of($users)
                    ->addColumn('action', function ($row) {
                        return '<button class="btn btn-info edit" data-id="' . $row->id . '">Edit</button>';
                    })
                    ->rawColumns(['action'])
                    ->toJson(); // Ensure JSON output
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
    
        return abort(403, 'Unauthorized action.');
    }
    
}
