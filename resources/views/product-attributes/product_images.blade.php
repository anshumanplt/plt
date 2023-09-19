@extends('layouts.app') <!-- Use your own layout if available -->

@section('content')



<div class="card">
    <div class="card-body">
    <div class="container">
        <h1>Product Attributes Images</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        {{-- <a href="{{ route('product-attributes.create', $productId) }}"  class="btn btn-primary" >Add variant to product</a> --}}
        <a href="{{ route('products.index') }}"  class="btn btn-primary" >Back to product listing</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Images</th>
                    <th>Action</th>
                    
                    <!-- Add more table headers for other attributes -->
                </tr>
            </thead>
            <tbody>
                @foreach($getProductAttributeImages as $value)
                    <tr>
                        <td><img src="{{ asset('../storage/app/public/'.$value->image_path) }}" class="img-responsive" height="100" width="100"></td>
                        <td> 

                          
                            <a href="{{ route('product-attributes.deleteProductImages', $value->id) }}"class="btn-delete">Delete</a>
                       
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    </div></div>
@endsection
