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
            <table>
                <thead>
                    <td>ID</td>
                    <td>name</td>
                    <td>size</td>
                    <td>price</td>
                    <td>qty</td>
                    <td>action</td>
                </thead>
                <tbody>
                    @foreach ($cart as $c => $detail)
                        <tr>
                            <td>{{ $detail['product_id'] }}</td>
                            <td>{{ $detail['name'] }}</td>
                            <td>{{ $detail['size'] }}</td>
                            <td>{{ $detail['price'] }}</td>
                            <td>{{ $detail['qty'] }}</td>
                            <td>
                                <a href="{{route('cart.addOne',$c)}}">+</a>
                                <a href="{{route('cart.removeOne',$c)}}">-</a>
                                <a href="{{ route('cart.remove', $c) }}" class="remove-cart text-red-600"
                                    data-id="{{ $c }}">Remove</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-public-layout>
