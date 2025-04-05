<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Dashboard_model extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'user'; // Ensure this matches your actual database table name

    protected $fillable = ['id', 'name', 'email', 'mobile', 'gender', 'user_type']; // Define mass-assignable fields
}
