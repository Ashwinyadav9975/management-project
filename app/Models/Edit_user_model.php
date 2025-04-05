<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Crypt;

class Edit_user_model extends Model
{
    use HasFactory;

    protected $table = 'user';  // Ensure this matches your table name
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'gender',
        'user_type'
    ];

    public $timestamps = false; // Disable Laravel's default timestamps

    // Method to get the user by ID
    public static function getUserById($id)
    {
        // Fetch the user by ID using Eloquent
        $user = self::findOrFail($id);

        // Decrypt the email and mobile fields
        $user->email = Crypt::decrypt($user->email); 
        $user->mobile = Crypt::decrypt($user->mobile);
        return $user;
    }

    // Method to update the user
    public static function update_user($id, $data)
    {
        $user = self::findOrFail($id); // Use static reference for the model

        if ($user) {
            // Encrypt sensitive fields before saving
            $user->name = $data['name'];
            $user->mobile = Crypt::encrypt($data['mobile']);
            $user->gender = $data['gender'];

            // Store epoch time (Unix timestamp) in updated_on
            $user->updated_on = time(); 

            // Save the updated user data
            return $user->save();
        }
    }
}
