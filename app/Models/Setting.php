<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'setting'; // Ensure this matches the table name in the database
    protected $fillable = ['system_name', 'system_short_name', 'system_logo', 'system_cover'];
}
