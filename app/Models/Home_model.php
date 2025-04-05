<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class Home_model extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'user';

    protected $fillable = ['id', 'name', 'email', 'mobile', 'gender', 'user_type', 'created_on'];


  
    public static function Get_decrypted_users($startDate = null, $endDate = null)
{
    $currentUserId = Auth::id();

    $query = self::select('id', 'name', 'email', 'mobile', 'gender', 'user_type', 'created_on')
        ->where('id', '!=', $currentUserId);

    if ($startDate && $endDate) {
        // Convert date range to epoch timestamps
        $startDate = Carbon::parse($startDate)->startOfDay()->timestamp;
        $endDate = Carbon::parse($endDate)->endOfDay()->timestamp;

        $query->whereBetween('created_on', [$startDate, $endDate]);
    }

    $users = $query->get();

    // Convert epoch timestamps to readable date format if needed
    foreach ($users as $user) {
        if ($user->created_on) {
            $user->created_on = Carbon::parse($user->created_on)->format('Y-m-d');  // Ensure it's in 'Y-m-d' format
        }

        try {
            $user->email = Crypt::decrypt($user->email);
            $user->mobile = Crypt::decrypt($user->mobile);
        } catch (DecryptException $e) {
            $user->email = 'Decryption error';
            $user->mobile = 'Decryption error';
        }
    }

    return $users;
}

}
