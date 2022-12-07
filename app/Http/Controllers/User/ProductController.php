<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use InterventionImage;
use Illuminate\Support\Facades\Storage; 
use App\Models\User;
use App\Models\Like;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    
    // public function __construct(){
    //     $this->middleware('auth:users');
    // }

    public function index(Request $request)
    {
        $products = Product::select('id','name','user_id','information','filename','price')
                    ->where('is_selling','1')
                    ->searchKeyWord($request->keyword)
                    ->orderBy('created_at','desc')
                    ->paginate(10);

                    // 後に->searchKeyword($request->keyword)を実装

        // dd($products);

        return view('user.products.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // dd('create画面です');
        return view('user.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);

        $request->validate([
            'information' => 'required|string|max:200', 
        ]);

        $imageFile = $request->image;
        $fileName = uniqid(rand().'_');
        $extension = $imageFile->extension();
        $fileNameToStore = $fileName.'.'.$extension;
        $resizedImage = InterventionImage::make($imageFile)->resize(1280,1280)->encode();

        Storage::put('public/products/'.$fileNameToStore, $resizedImage);
        
        Product::create([
            'name' => $request->name,
            'information' => $request->information,
            'price' => $request->price,
            'user_id' => Auth::id(),
            'filename' => $fileNameToStore,
            'is_selling' => true,
        ]);

        // dd('保存完了');

        return redirect()->route('user.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $user = User::findOrFail($product->user_id);
        // $like = Like::select('user_id', 'product_id')
        //     ->where('product_id',$id)
        //     ->first();

        return view('user.products.show',compact('product','user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();

        return redirect()->route('user.profile',['userId' => Auth::id()]);
    }

    public function checkout($id){
        $product = Product::findOrFail($id);

        $lineItems = [];
        $lineItem = [
            'price_data' => [
            'unit_amount' => $product->price,
            'currency' => 'JPY',

            'product_data' => [
                'name' => $product->name,
                'description' => $product->information,
            ],
        ],
        'quantity' => 1
    ];
    array_push($lineItems,$lineItem);

    // dd($lineItems);

    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [$lineItems],
        'mode' => 'payment',
        'success_url' => route('user.products.success',['id' => $id]),
        'cancel_url' => route('user.products.show',['product' => $id])
    ]);

    $publicKey = env('STRIPE_PUBLIC_KEY');

    return view('user.checkout',compact('session','publicKey','product'));
    }

    public function success($id){
        Product::Where('id',$id)->delete();

        return redirect()->route('user.products.index');
    }
}
