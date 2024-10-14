<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    // Define the custom primary key
    protected $primaryKey = 'r_code';

    // If your primary key is not an incrementing integer
    public $incrementing = false;  // Only if your primary key is not auto-incrementing

    // If the primary key is not an integer (e.g., a string UUID)
    protected $keyType = 'string'; //

    protected $guarded = [];
}
