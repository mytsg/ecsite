<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            商品詳細
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <section class="text-gray-600 body-font overflow-hidden">
                        <div class="container px-5 py-24 mx-auto">
                            <div class="lg:w-4/5 mx-auto flex flex-wrap">
                                <img class="lg:w-1/2 w-full lg:h-auto h-64 object-cover object-center rounded" src="{{ asset('storage/products/'.$product->filename) }}">
                                <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
                                    <h1 class="text-gray-900 text-3xl title-font font-medium border-b-2 border-gray-100 pb-3 mb-1">商品名：{{ $product->name }}</h1>
                                    <p class="leading-relaxed border-b-2 font-small text-2xl border-gray-100 pb-3 mb-1">商品情報：{{ $product->information }}</p>
                                    <div class="flex  border-b-2 border-gray-100 pb-3 mb-1">
                                        <span class="font-small text-2xl text-gray-900">価格：{{ number_format($product->price) }}円</span>
                                    </div>
                                    <div class=" border-b-2 border-gray-100 pb-3 mb-1">
                                        <h2 class="font-small text-2xl text-gray-900">出品者：{{ $user->name }}</h2>
                                    </div>
                                    <div class="flex my-4">
                                        <button type="button" onclick="location.href='{{ route('user.products.index') }}'" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">商品一覧へ戻る</button>
                                        @if($product->user_id != Auth::id())
                                        <button onclick="location.href='{{ route('user.products.checkout',['id'=> $product->id ]) }}'" type="button" class="flex ml-auto text-white bg-indigo-400 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-500 rounded">商品を購入する</button>
                                        @endif
                                        <form method="post" action="{{ route('user.like.add') }}" >
                                            @csrf
                                            <button class="rounded-full w-10 h-10 bg-gray-200 p-0 border-0 inline-flex items-center justify-center text-gray-500 ml-4">
                                                <svg fill="red" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                                                    <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"></path>
                                                </svg>
                                            </button>
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        </form>
                                        <!-- これでボタンを押すとuser.like.addに$product->id が渡ってくる -->
                                        
                                    </div>
                                    @if($product->user_id == Auth::id())
                                    <form id="delete_{{$product->id}}" method="post" action="{{ route('user.products.destroy',['product' => $product->id]) }}">
                                        @csrf
                                        @method('delete')
                                        <div class="py-2 w-full flex ml-auto">
                                            <a href="#" data-id="{{ $product->id }}" onclick="deletePost(this)" class="text-white bg-red-400 border-0 py-2 px-4 focus:outline-none hover:bg-red-500 rounded">出品を取り消す</a>
                                        </div>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
<script>
    function deletePost(e) {
        'use strict';
        if (confirm('本当に削除してもいいですか?')) {
        document.getElementById('delete_' + e.dataset.id).submit();
        }
    }
</script>
</x-app-layout>