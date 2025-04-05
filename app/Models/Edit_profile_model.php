<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Crypt;

class Edit_profile_model extends Model
{
    use HasFactory;

    protected $table = 'user';  // Ensure this matches your table name
    public $timestamps = false; // Disable Laravel's default timestamps

    // Method to get the user by ID
    public static function getUserById($id)
    {
        $user = self::findOrFail($id);
        $user->mobile = Crypt::decrypt($user->mobile);
        return $user;
    }

    // Method to update user data
    public static function update_user($id, $data)
    {
        $user = self::find($id);
        if (!$user) {
            return false;
        }

        // Update user data
        $user->name = $data['name'];
        $user->mobile = Crypt::encrypt($data['mobile']); // Encrypt mobile before saving
        $user->gender = $data['gender'];

        // Check if image exists in data
        if (isset($data['image'])) {
            $user->image = $data['image'];
        }
        $user->updated_on = time(); 

        return $user->save();
    }
}
