<!-- resources/views/brands/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
    <div class="container">
        <h1>Brands</h1>

        <a href="{{ route('brands.create') }}" class="btn btn-primary">Create New Brand</a>

        <table class="table mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Meta Title</th>
                    <th>Meta Description</th>
                    <th>Meta Keywords</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($brands as $brand)
                    <tr>
                        <td>{{ $brand->id }}</td>
                        <td>{{ $brand->name }}</td>
                        <td>
                            @if ($brand->image)
                                <img src="{{ asset('storage/' . $brand->image) }}" alt="Brand Image" width="100">
                            @else
                                No Image
                            @endif
                        </td>
                        <td>{{ $brand->meta_title }}</td>
                        <td>{{ $brand->meta_description }}</td>
                        <td>{{ $brand->meta_keywords }}</td>
                        <td>
                            <a href="{{ route('brands.show', $brand->id) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this brand?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div></div>
@endsection
