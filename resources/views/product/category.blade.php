@extends('layout')

@section('main')

    <div id="products" class="flex flex-wrap text-">
        @if (count($products) > 0)
            @foreach($products as $product)
            <div class="w-full p-3 md:w-1/2 lg:w-1/3">
                <div class="border border-gray-300 rounded product">
                    <img class="object-cover w-full h-64" src="{{url('/')}}/images/{{$product->image}}" alt="">
                    <div class="flex justify-between p-2 text-lg">
                        <div>{{$product->name}}</div>
                        <div class="font-bold">{{ \App\Libs\Common::withVAT($product->price,$product->vat) }}€</div>
                    </div>
                    <a class="inline-block w-full px-4 py-1 text-lg text-center text-white bg-blue-700 rounded-sm" href="{{url('/')}}/detail/{{$product->id}}">Voir</a>
                </div>
            </div>
            @endforeach
        @else
            <div class="w-full p-3 md:w-1/1 lg:w-1/1 text-center">
                <h3>Aucun produit dans cette catégorie</h3>
            </div>
        @endif


    </div>

@endsection
