<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
    ];
}