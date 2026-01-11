<x-public-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @auth
            <p>Welcome back,{{ auth()->user()->name }}, go check out</p>
        @else
            <p>Your Cart</p>
        @endauth
        <div>
         this is space for cart item
        </div>
    </div>
</x-public-layout>