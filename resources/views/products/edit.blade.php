<!-- resources/views/products/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
    <div class="container">
        <h1>Edit Product</h1>

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="sku">SKU</label>
                <input type="text" name="sku" id="sku" class="form-control" value="{{ $product->sku }}" required>
            </div>

            <div class="form-group">
                <label for="meta_title">Meta Title</label>
                <input type="text" name="meta_title" id="meta_title" class="form-control" value="{{ $product->meta_title }}">
            </div>

            <div class="form-group">
                <label for="meta_description">Meta Description</label>
                <textarea name="meta_description" id="meta_description" class="form-control">{{ $product->meta_description }}</textarea>
            </div>

            <div class="form-group">
                <label for="meta_keywords">Meta Keywords</label>
                <input type="text" name="meta_keywords" id="meta_keywords" class="form-control" value="{{ $product->meta_keywords }}">
            </div>

            <div class="form-group">
                <label for="brand_id">Brand</label>
                <select name="brand_id" id="brand_id" class="form-control" required>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" {{ $brand->id == $product->brand_id ? 'selected' : '' }}>{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="category_id">Category</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->category_id }}" {{ $category->category_id == $product->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="subcategory_id">Subcategory</label>
                <select name="subcategory_id" id="subcategory_id" class="form-control" required>
                    @foreach ($subcategories as $subcategory)
                        <option value="{{ $subcategory->category_id }}" {{ $subcategory->category_id == $product->subcategory_id ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" required>{{ $product->description }}</textarea>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" name="price" id="price" class="form-control" value="{{ $product->price }}" required>
            </div>

            <div class="form-group">
                <label for="discount">Discount</label>
                <input type="number" name="discount" id="discount" class="form-control" value="{{ $product->discount }}">
            </div>

            <div class="form-group">
                <label for="sale_price">Sale Price</label>
                <input type="number" name="sale_price" id="sale_price" class="form-control" value="{{ $product->sale_price }}">
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="1" {{ $product->status ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !$product->status ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="form-group">
                <label for="hot_trend">Hot Trend</label>
                <input type="checkbox" name="hot_trend" id="hot_trend" value="1" {{ $product->hot_trend ? 'checked' : '' }}>
            </div>
        
            <div class="form-group">
                <label for="best_seller">Best Seller</label>
                <input type="checkbox" name="best_seller" id="best_seller" value="1" {{ $product->best_seller ? 'checked' : '' }}>
            </div>
        
            <div class="form-group">
                <label for="feature">Feature</label>
                <input type="checkbox" name="feature" id="feature" value="1" value="1" {{ $product->feature ? 'checked' : '' }}>
            </div>
          

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    </div></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // When the category selection changes
            $('#category_id').on('change', function() {
                var categoryID = $(this).val();
              
                // Send an Ajax request to get the subcategories
                $.ajax({
                    url: "{{ route('products.getSubcategories') }}",
                    type: "POST",
                    data: {
                        category_id: categoryID,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        // Clear previous subcategory options
                        $('#subcategory_id').empty();

                        // Add the retrieved subcategories as options
                        $.each(data, function(key, value) {
                            $('#subcategory_id').append('<option value="' + value.category_id + '">' + value.name + '</option>');
                        });
                    }
                });
            });
        });
    </script>

@endsection
