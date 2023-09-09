<!-- resources/views/products/show.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Product Details</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $product->name }}</h5>

                <div class="mb-3">
                    <label class="fw-bold">ID:</label>
                    <span>{{ $product->id }}</span>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">SKU:</label>
                    <span>{{ $product->sku }}</span>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Meta Title:</label>
                    <span>{{ $product->meta_title }}</span>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Meta Description:</label>
                    <span>{{ $product->meta_description }}</span>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Meta Keywords:</label>
Here's the continuation of the `show.blade.php` file for the Product view:

```html
                    <span>{{ $product->meta_keywords }}</span>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Brand:</label>
                    <span>{{ $product->brand->name }}</span>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Category:</label>
                    <span>{{ $product->category->name }}</span>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Subcategory:</label>
                    <span>{{ $product->subcategory->name }}</span>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Description:</label>
                    <p>{{ $product->description }}</p>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Price:</label>
                    <span>{{ $product->price }}</span>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Discount:</label>
                    <span>{{ $product->discount }}</span>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Sale Price:</label>
                    <span>{{ $product->sale_price }}</span>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Status:</label>
                    <span>{{ $product->status ? 'Active' : 'Inactive' }}</span>
                </div>

                <a href="{{ route('products.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
@endsection
