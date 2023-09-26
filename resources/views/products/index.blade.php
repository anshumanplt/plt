<!-- resources/views/products/index.blade.php -->
@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-body">
    <div class="container">
        <h1>Products</h1>

        <a href="{{ route('products.create') }}" class="btn btn-primary">Create New Product</a>
        <a href="{{ route('products.import') }}" class="btn btn-primary">Upload Product</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>SKU</th>
                    <th style="width: 50px;">Name</th>
                    {{-- <th>Brand</th> --}}
                    <th>Category</th>
                    <th>Subcategory</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->sku }}</td>
                        <td style="width: 50px;">{{ $product->name }}</td>
                        {{-- <td>{{ $product->brand->name }}</td> --}}
                        <td>{{ $product->category->name }}</td>
                        <td>{{ $product->subcategory->name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->status ? 'Active' : 'Inactive' }}</td>
                        <td>
                            <a href="{{ route('products.show', $product->id) }}"><span class="mdi mdi-eye-circle"></span></a>
                            <a href="{{ route('products.edit', $product->id) }}"><span class="mdi mdi-pencil-box"></span></a>
                            <a href="{{ route('products.images.index', $product->id) }}" ><span class="mdi mdi-image-multiple"></span></a><br>
                            {{-- <a href="{{ route('product-attributes.index', $product->id) }}"><span class="mdi mdi-ticket"></span></a> --}}
                            {{-- <a href="{{ route('product-attributes.createAllvariation',  $product->id) }}" ><span class="mdi mdi-ticket"></span></a> --}}
                            <a href="{{ route('product-attributes.selectattributeforproduct',  $product->id) }}"><span class="mdi mdi-ticket"></span></a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this product?')"><span class="mdi mdi-delete"></span></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $products->links('pagination::bootstrap-4') }}
    </div>
    </div></div>
@endsection
