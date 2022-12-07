<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth:users');
    }

    public function profile($userId){
        $products = Product::select('id','name','price','filename','user_id','information','is_selling')
                    ->where('user_id',$userId)
                    ->where('is_selling','1')
                    ->orderBy('created_at','desc')
                    ->paginate(10);

        $user = User::findOrFail($userId);
        
        return view('user.profile',compact('products','user'));
    }
}
