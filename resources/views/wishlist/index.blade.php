
@extends('layouts.frontlayout')

@section('content')
<div class="container" style="padding-top: 5%">
    <h2>Your Wishlist</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Description</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($wishlistedProducts as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>
                        @if ($product->productImages->count() > 0)
                            <img src="{{ asset('storage/'.$product->productImages[0]->image_path) }}" alt="Product Image" style="max-width: 100px;">
                        @else
                            No Image
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('wishlist.remove', $product->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Remove</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
    {{-- @foreach ($wishlistedProducts as $product)
        <div>
            <h3>{{ $product->name }}</h3>
            <p>{{ $product->description }}</p>
            @if ($product->productImages->count() > 0)
                <img src="{{ asset('../storage/app/public/'.$product->productImages[0]->image_path) }}" alt="Product Image">
            @endif
            <form action="{{ route('wishlist.remove', $product->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Remove from Wishlist</button>
            </form>
        </div>
    @endforeach --}}
@endsection