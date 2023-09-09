@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Product Images</h1>

        <div class="image-list">
            @forelse ($images as $image)
                <div class="image-item">
                    <img src="{{ asset('../storage/app/public/'.$image->image_path) }}" class="img-responsive" height="100" width="300" alt="Product Image">


                    <div class="image-details">
                        <p>Status: {{ $image->status ? 'Active' : 'Inactive' }}</p>
                        <p>Featured: {{ $image->featured ? 'Yes' : 'No' }}</p>
                    </div>
                    <div class="image-actions">
                        {{-- <a href="{{ route('products.images.edit', [$product->id, $image->id]) }}">Edit</a> --}}
                        <a href="{{ url('products/images/feature', [$product->id, $image->id]) }}">is Featured Image </a>
                        <form action="{{ route('products.images.destroy', [$product->id, $image->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this image?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <p>No product images available.</p>
            @endforelse
        </div>
        <a href="{{ route('products.images.create', $product->id) }}" class="btn btn-primary">Add Image</a>
    </div>
@endsection
