<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Welcome_controller extends Controller
{
    public function index()
    {
        return view('welcome_message');
    }
}
