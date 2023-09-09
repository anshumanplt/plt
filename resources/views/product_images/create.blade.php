@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add Product Image</h1>

        <form action="{{ route('products.images.store', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="images[]" multiple id="image" class="form-control">
            </div>

            <div class="form-group">
                <label for="featured">Featured</label>
                <input type="checkbox" name="featured" id="featured" value="1" class="form-check-input">
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <input type="checkbox" name="status" id="status" value="1" class="form-check-input" checked>
            </div>

            <button type="submit" class="btn btn-primary">Add Image</button>
        </form>
    </div>
@endsection
