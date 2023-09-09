@extends('layouts.app') {{-- Assuming you have a layout file --}}

@section('content')
<div class="card">
    <div class="card-body">

        <div class="container">
            <h2>Create Product Attribute</h2>

            <a href="{{ route('product-attributes.index', $productId) }}" class="btn btn-primary">Back to listing</a>
            <a href="{{ route('products.index') }}"  class="btn btn-primary" >Back to product listing</a>
            <br>
            <br>
            <br>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        
            <form method="POST" enctype="multipart/form-data" action="{{ route('product-attributes.store') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $productId }}">
                @foreach($allAttribute as $value)
                    <div class="form-group">
                        <label for="">{{ $value->name }}</label>
                        <select name="attributes[]" class="form-control" id="">
                            <option value="">-- Select option --</option>
                            @foreach ($value->attributeValues as $item)
                                <option value="{{ $value->id }}:{{ $item->id }}">{{ $item->value }}</option>
                            @endforeach
                        </select>
                    </div>
                @endforeach
                <div class="form-group">
                    <label for="">Product Images</label>
                    <input type="file" class="form-control" name="files[]" multiple id="">
                </div>
                {{-- <div class="form-group">
                    <label for="">Attribute:</label>
                    <select name="attribute_id" class="form-control" id="attribute_id">
                        <option value="">--Select Attribute--</option>
                        @foreach($allAttribute as $value)
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="attribute-values-container" class="form-group">
                    <select name="attribute_value_id" class="form-control" id="attribute-values">
                        <option value="">Select an Attribute Value</option>
                    </select>
                </div> --}}
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="number" name="price" id="price" placeholder="Price" class="form-control">
                </div>

                <div class="form-group">
                    <label for="inventory">Inventory:</label>
                    <input type="number" name="inventory" placeholder="Inventory" id="inventory" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="">SKU:</label>
                    <input type="text" name="sku" class="form-control" placeholder="SKU" id="">
                </div>
                
                <button type="submit" class="btn btn-primary">Create Product Attribute</button>
            </form>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<script>
$(document).ready(function () {
    $('#attribute_id').on('change', function () {
        var selectedAttribute = $(this).val();
        var attributeValuesDropdown = $('#attribute-values');

        if (selectedAttribute) {
            $.ajax({
                url: "{{ route('get-attribute-values') }}",
                type: "GET",
                data: { attribute_id: selectedAttribute },
                success: function (response) {

                    var attributeValues = response.attribute_values;

                    console.log("Check AttributeValue : ");
                    console.log(attributeValues);

                    // Clear previous options
                    attributeValuesDropdown.empty();
                    attributeValuesDropdown.append('<option value="">Select an Attribute Value</option>');

                    // Add new options
                    attributeValues.forEach(function (value) {
                        attributeValuesDropdown.append('<option value="' + value.id + '">' + value.value + '</option>');
                    });
                },
                error: function (error) {
                    console.error(error);
                }
            });
        } else {
            // Clear the attribute values dropdown if no attribute is selected
            attributeValuesDropdown.empty();
            attributeValuesDropdown.append('<option value="">Select an Attribute</option>');
        }
    });
});

</script>
@endsection
