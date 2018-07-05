@extends('layouts.app')

@section('title', $product->name)

@section('body')
    <div class="bg-white max-w-sm mx-auto rounded overflow-hidden shadow mt-12">
        <div class="px-6 py-4">
            <h1 class="font-medium mb-2">{{ $product->name }}</h1>
            <p class="font-medium leading-normal text-lg text-grey-darker">{{ $product->description }}</p>
        </div>
        <div class="px-6 py-4 flex">
            <div class="mr-6">
                <label class="text-grey-dark">Price</label>
                <span class="text-2xl block mt-1">${{ number_format($product->price / 100, 2) }}</span>
            </div>
            <div class="flex-grow">
                <purchase-button
                    :id={{ $product->id }}
                    name="{{ $product->name }}"
                    :price={{ $product->price }}
                ></purchase-button>
            </div>
        </div>
    </div>
    <div class="text-center text-grey-dark mt-8">
        <p>Powered by Purchase</p>
    </div>

@endsection

@push('scripts')
    <script src="https://checkout.stripe.com/checkout.js"></script>
@endpush
