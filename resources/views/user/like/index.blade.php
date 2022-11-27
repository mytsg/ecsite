<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            いいねした商品一覧
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <section class="text-gray-600 body-font">
                        <div class="container px-5 py-24 mx-auto">
                            <div class="md:flex flex-wrap -m-4">
                                @foreach($products as $product)
                                <div class="lg:w-1/4 md:w-1/2 p-3 m-1 w-full bg-green-100 hover:bg-green-200 rounded">
                                    <a href="{{ route('user.products.show',['product' => $product->id ]) }}" class="block relative h-48 rounded overflow-hidden">
                                        <img class="object-cover object-center w-full h-full block" src="{{ asset('storage/products/'.$product->filename) }}">
                                    </a>
                                    <div class="mt-4">
                                        <h2 class="text-gray-900 title-font text-lg font-medium">{{ $product->name }}</h2>
                                        <p class="mt-1">{{ number_format( $product->price ) }}円</p>
                                        <button class="flex ml-auto text-white bg-red-400 border-0 py-2 px-6 focus:outline-none hover:bg-red-500 rounded">いいねを取り消す</button>
                                        
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>