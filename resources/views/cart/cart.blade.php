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
                            <td class="qty-cart">{{ $detail['qty'] }}</td>
                            <td>
                                <button type="button" class="update-cart px-2 py-1 border rounded"
                                    data-id="{{ $c }}" data-action="increment">
                                    +
                                </button>
                                <button type="button" class="update-cart px-2 py-1 border rounded"
                                    data-id="{{ $c }}" data-action="decrement">
                                    -
                                </button>

                                <button type="button" class="remove-cart text-red-600" data-id="{{ $c }}">
                                    Remove
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        //update cart toast
        document.addEventListener('click', async (e) => {
            const btn = e.target.closest('.update-cart');

            if (!btn) return
            e.preventDefault();

            const id = btn.dataset.id
            const actionvalue = btn.dataset.action
            const qty = btn.closest('tr').querySelector('.qty-cart');
            try {
                const response = await fetch(`/cart/${id}`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        action: actionvalue
                    }),
                });
                if (!response.ok) {
                    throw new Error('Request failed');
                }
                const data = await response.json();

                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: data.status === 'success' ? 'success' : 'error',
                    title: data.message,
                    showConfirmButton: false,
                    timer: 2500,
                })
                if (data.removed === true) {
                    btn.closest('tr').remove();
                }
                if (data.qty !== undefined) {
                    qty.textContent = data.qty;
                }
            } catch (err) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Something went wrong',
                    showConfirmButton: false,
                    timer: 2000,
                });
            }

        })
        //remove item
        document.addEventListener('click', async (e) => {
            const btn = e.target.closest('.remove-cart');
            if (!btn) return;

            e.preventDefault();

            const id = btn.dataset.id;

            const response = await fetch(`/cart/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            });

            const data = await response.json();

            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: data.status === 'success' ? 'success' : 'error',
                title: data.message,
                showConfirmButton: false,
                timer: 2500,
            });

            if (data.status === 'success') {
                btn.closest('tr').remove(); // remove row from table
            }
        });
    </script>
</x-public-layout>
