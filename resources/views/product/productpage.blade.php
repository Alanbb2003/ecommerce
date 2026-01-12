<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            {{-- Product Images --}}
            <div>
                <div class="aspect-square bg-gray-100 rounded-lg flex items-center justify-center">
                    <span class="text-gray-400">Product Image</span>
                </div>

                {{-- Thumbnail images (optional) --}}
                <div class="mt-4 flex gap-2">
                    <div class="w-16 h-16 bg-gray-100 rounded"></div>
                    <div class="w-16 h-16 bg-gray-100 rounded"></div>
                    <div class="w-16 h-16 bg-gray-100 rounded"></div>
                </div>
            </div>

            {{-- Product Info --}}
            <div>
                {{-- Category --}}
                <p class="text-sm text-gray-500">
                    {{ $product->category->name }}
                </p>

                {{-- Name --}}
                <h1 class="text-2xl font-semibold mt-1">
                    {{ $product->name }}
                </h1>

                {{-- Price (use lowest variant price) --}}
                <p class="text-2xl font-bold text-gray-900 mt-4" id="product-price">
                    Rp {{ number_format($product->variants->min('price')) }}
                </p>

                <form action="{{ route('cart.store') }}" method="POST" class="mt-6" data-ajax>
                    @csrf

                    {{-- Variant selection --}}
                    <p class="text-sm font-medium text-gray-700 mb-2">Size</p>

                    <div class="flex gap-2">
                        @foreach ($product->variants as $variant)
                            <label>
                                <input type="radio" name="variant_id" value="{{ $variant->id }}" data-price="{{ $variant->price }}" 
                                class="hidden peer"
                                    required>

                                <span
                                    class="px-4 py-2 border rounded-md text-sm cursor-pointer
                           peer-checked:border-black peer-checked:bg-black peer-checked:text-white">
                                    {{ $variant->size }}
                                </span>
                            </label>
                        @endforeach
                    </div>

                    {{-- Quantity --}}
                    <div class="mt-4 flex gap-4">
                        <input type="number" name="qty" min="1" value="1"
                            class="w-20 border rounded-md px-2 py-2">

                        <button type="submit" class="flex-1 bg-black text-white py-3 rounded-md hover:bg-gray-800">
                            Add to Cart
                        </button>
                    </div>
                </form>
                
                {{-- Description --}}
                <div class="mt-8">
                    <h2 class="text-lg font-semibold mb-2">Description</h2>
                    <p class="text-gray-700 leading-relaxed">
                        {{ $product->description }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
