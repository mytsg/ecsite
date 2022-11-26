<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Like;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'information',
        'filename',
        'price',
        'is_selling',
    ];

    public function users(){
        return $this->belongsToMany(User::class,'likes')
        ->withPivot(['id']);
    }

}