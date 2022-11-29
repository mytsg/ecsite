<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $user->name }}さんの出品した商品一覧
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <section class="text-gray-600 body-font">
                        <div class="container px-5 py-12 mx-auto">
                        <div class="flex flex-col text-center w-full mb-20">
                            <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">{{ $user->name }}</h1>
                            <p class="lg:w-2/3 mx-auto leading-relaxed text-base">{{ $user->name }}さんの商品一覧を表示しています。</p>
                        </div>
                            <div class="flex flex-wrap -m-4">
                            @foreach($products as $product)
                                <div class="px-4 md:w-1/3">
                                    <div class="h-full border-2 border-gray-200 border-opacity-60 rounded-lg overflow-hidden">
                                        <img class="w-full object-cover object-center" src="{{ asset('storage/products/'.$product->filename) }}">
                                        <div class="p-6">
                                            <h1 class="title-font text-lg font-medium text-gray-900 mb-1 border-b-2 border-gray-300">{{ $product->name }}</h1>
                                            <h2 class="tracking-widest text-xm title-font font-medium text-gray-800 mb-1 border-b-2 border-gray-300">{{ number_format($product->price) }}円</h2>
                                            <p class="leading-relaxed mb-3">{{ $product->information }}</p>
                                            <div class="flex items-center flex-wrap ">
                                                <a href="{{ route('user.products.show',['product' => $product->id ]) }}" class="rounded text-indigo-500 bg-indigo-200 inline-flex items-center md:mb-2 lg:mb-0 p-4">詳細を見る
                                                    <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M5 12h14"></path>
                                                        <path d="M12 5l7 7-7 7"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                            {{ $products->links() }}
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>