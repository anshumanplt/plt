<!-- resources/views/products/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
    <div class="container">
        <h1>Create New Product</h1>
        <h4><a href="{{ url('/') }}/frontend/Product_import_plt.csv" target="_blank">Download Dummy File</a></h4>
        @if($errors->any())
        {{ implode('', $errors->all('<div>:message</div>')) }}
    @endif
        <form action="{{ route('products.import.upload.csv') }}" enctype="multipart/form-data" method="POST">
            @csrf

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
                <label for="">Select csv file</label>
                <input type="file" name="csv_file" class="form-control" id="">
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
        </form>


        <h3>CSV Upload Report</h3>
        <table class="table">
            <tr>
                <td>Total Upload Product</td>
                <td>{{ $report['totalProductInserted'] }}</td>
            </tr>
            <tr>
                <td>Total Duplicate Product</td>
                <td>{{ count($report['duplicateProduct']) }}</td>
            </tr>

        </table>
    </div>
    </div>
</div>



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
