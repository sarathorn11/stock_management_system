<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table = 'suppliers';  // Specify the table name
    protected $fillable = [
        'name',
        'address',
        'cperson',
        'contact',
        'status',
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
