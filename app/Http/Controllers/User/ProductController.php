<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use InterventionImage;
use Illuminate\Support\Facades\Storage; 
use App\Models\User;


class ProductController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth:users');
    }

    public function index(Request $request)
    {
        $products = Product::select('id','name','user_id','information','filename','price')
                    ->where('is_selling','1')
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

        // dd($product);

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
        //
    }
}
