<x-public-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @auth
            <p>Welcome back,{{ auth()->user()->name }}</p>
        @else
            <p>Welcome to our store</p>
        @endauth
        <div>
            @foreach ($products as $product)
                <div class="flex">
                    <h3>{{ $product->name }}</h3>
                    <p> - {{ $product->category->name }}</p>
                    <a>link</a>
                </div>
            @endforeach

            {{ $products->links() }}
        </div>
    </div>
</x-public-layout>
