<?php
namespace App\Http\Controllers;

use App\Models\Login_model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\FailedLoginAttempt;  // Import the email class

class Login extends Controller
{
    private $login;

    public function __construct(Login_model $login)
    {
        $this->login = $login;
    }

    // Show the login page
    public function Show_login_form()
    {
        if (Auth::check()) {
            return redirect()->route('home'); // Redirect to register if already logged in
        }
        return view('login');
    }

    // Handle user login
    public function login_user(Request $request)
    {
        // Log::info('Received AJAX request', $request->all());
        Log::channel('database')->info('Received AJAX registration request', ['data' => $request->all()]);

        // Ensure it's an AJAX request
        if (!$request->ajax()) return redirect()->route('login');
    
        // Validate the input data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
    
        $key = 'password_attempts_' . Str::lower($request->email) . '|' . $request->ip();
    
        // Check if the rate limiter is exceeded
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            $attempts = RateLimiter::attempts($key);
    
            // Send alert email after 3 failed attempts
            Mail::to($request->email)->send(new FailedLoginAttempt($request->email));
    
            return response()->json([
                'status' => 'error',
                'message' => "Too many incorrect password attempts ($attempts/3). Try again in $seconds seconds."
            ]);
        }
    
        // Find user by email (decrypt the stored email)
        $user = $this->login::all()->first(function ($user) use ($request) {
            try {
                return Crypt::decrypt($user->email) === $request->email;
            } catch (DecryptException $e) {
                return false;
            }
        });
    
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'No account found!'
            ]);
        }
    
        // Verify password
        if (!Hash::check($request->password, $user->password)) {
            RateLimiter::hit($key, 60);  // Increment the failed attempts count
            $attempts = RateLimiter::attempts($key);
            return response()->json([
                'status' => 'error',
                'message' => "Incorrect password! ($attempts/3 attempts)"
            ]);
        }
    
        // Reset failed attempts after successful login
        RateLimiter::clear($key);
    
        // Authenticate the user
        Auth::login($user);
    
        // Send a response with only the redirect URL (no success message)
        return response()->json([
            'status' => 'success',
            'redirect' => route('home') // Only send the redirect URL
        ]);
    }
    
    // Logout function
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }
}
