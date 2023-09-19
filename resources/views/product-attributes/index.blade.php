@extends('layouts.app') <!-- Use your own layout if available -->

@section('content')



<div class="card">
    <div class="card-body">
    <div class="container">
        <h1>Product Attributes</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <a href="{{ route('product-attributes.create', $productId) }}"  class="btn btn-primary" >Add variant to product</a>
        <a href="{{ route('products.index') }}"  class="btn btn-primary" >Back to product listing</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Attribute</th>
                    <th>SKU</th>
                    <th>Attribute Values</th>
                    <th>Price</th>
                    <th>Inventory</th>
                    <th>Images</th>
                    <!-- Add more table headers for other attributes -->
                </tr>
            </thead>
            <tbody>
                @foreach($productAttributes as $attribute)
                    <tr>
                        <td>{{ $attribute->product->name }} {{ $attribute->product->id }}</td>
                        <td>

                            {{ $attribute->attribute->name }}
                        </td>
                        <td>{{ $attribute->sku }}</td>
                        <td>{{ $attribute->attributeValues->value }}</td>
                        <td>{{ $attribute->price }}</td>
                        <td>{{ $attribute->inventory }}</td>
                        <td>
                            <a href="{{ route('product-attributes.showImages', [ 'sku' => $attribute->sku, 'productid' => $attribute->product->id ]) }}" class="btn btn-info btn-lg" >View Images</a>
                        </td>
                        <!-- Add more table cells for other attributes -->
                    </tr>

                @endforeach
            </tbody>
        </table>
    </div>
    </div></div>
@endsection
