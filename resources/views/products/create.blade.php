<!-- resources/views/products/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
    <div class="container">
        <h1>Create New Product</h1>
        @if($errors->any())
        {{ implode('', $errors->all('<div>:message</div>')) }}
    @endif
        <form action="{{ route('products.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="sku">SKU</label>
                <input type="text" name="sku" id="sku" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="meta_title">Meta Title</label>
                <input type="text" name="meta_title" id="meta_title" class="form-control">
            </div>

            <div class="form-group">
                <label for="meta_description">Meta Description</label>
                <textarea name="meta_description" id="meta_description" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="meta_keywords">Meta Keywords</label>
                <input type="text" name="meta_keywords" id="meta_keywords" class="form-control">
            </div>

            <div class="form-group">
                <label for="brand_id">Brand</label>
                <select name="brand_id" id="brand_id" class="form-control" required>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="category_id">Category</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->category_id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="subcategory_id">Subcategory</label>
                <select name="subcategory_id" id="subcategory_id" class="form-control" required>
             
                </select>
            </div>

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" name="price" id="price" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="discount">Discount</label>
                <input type="number" name="discount" id="discount" class="form-control">
            </div>

            <div class="form-group">
                <label for="sale_price">Sale Price</label>
                <input type="number" name="sale_price" id="sale_price" class="form-control">
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>

            <div class="form-group">
                <label for="hot_trend">Hot Trend</label>
                <input type="checkbox" name="hot_trend" id="hot_trend" value="1">
            </div>
        
            <div class="form-group">
                <label for="best_seller">Best Seller</label>
                <input type="checkbox" name="best_seller" id="best_seller" value="1">
            </div>
        
            <div class="form-group">
                <label for="feature">Feature</label>
                <input type="checkbox" name="feature" id="feature" value="1">
            </div>
            <div id="attribute-container">
                <button id="add-attribute">Add Attribute</button>
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
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
    <script>
    // JavaScript to dynamically add attributes and attribute values
    $(document).ready(function () {
        let attributeIndex = 0;

        $('#add-attribute').click(function () {
            const attributeTemplate = `
                <div class="attribute">
                    <input type="text" name="attributes[${attributeIndex}][name]" placeholder="Attribute name">
                    <button class="add-value">Add Value</button>
                    <div class="attribute-values"></div>
                </div>
            `;

            $('#attribute-container').append(attributeTemplate);

            attributeIndex++;

            $('.add-value').click(function () {
                const attributeValuesContainer = $(this).siblings('.attribute-values');
                const attributeValueTemplate = `
                    <input type="text" name="attributes[${attributeIndex - 1}][values][]" placeholder="Value">
                `;

                attributeValuesContainer.append(attributeValueTemplate);
            });
        });
    });
    </script>

@endsection
