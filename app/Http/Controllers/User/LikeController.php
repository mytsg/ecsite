<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function add(Request $request){
        $likedProduct = Like::where('product_id',$request->product_id)
                        ->where('user_id',Auth::id())->first();

        if(!$likedProduct) {
            Like::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
            ]);
        }

        return redirect()->route('user.products.show',['product' => $request->product_id]);
    }

    public function index(){
        $user = User::findOrFail(Auth::id());
        $products = $user->products;

        // dd($products);

        return view('user.like.index',compact('products'));
    }

    // 引数のidに紐づくitemにlikeする
    public function likes($id){
        Like::create([
            'product_id' => $id,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back();
    }

    public function unlikes($id){
        $like = Like::where('product_id',$id)->where('user_id',Auth::id())->first();
        $like->delete();

        return redirect()->back();
    }

    public function delete($id){
        Like::where('product_id',$id)
            ->where('user_id',Auth::id())
            ->delete();

        return redirect()->route('user.like.index');
    }
}
