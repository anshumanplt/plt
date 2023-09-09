<!-- resources/views/categories/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
    <div class="container">
        <h1>Categories</h1>

        @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif

        <a href="{{ route('categories.create') }}" class="btn btn-primary">Create New Category</a>

        <table class="table">
            <thead>
                <tr>
                    <th>Category ID</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Parent ID</th>
                    {{-- <th>Meta Title</th>
                    <th>Meta Description</th>
                    <th>Meta Keywords</th> --}}
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)

                    <tr>
                        <td>{{ $category->category_id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>@if($category->image)<img src="{{ asset('images/categories/' . $category->image) }}" alt="Category Image" width="100">  @else NA @endif</td>
                        <td>@if($category->parent){{ $category->parent->name }} @else NA  @endif</td>
                        {{-- <td>{{ $category->meta_title }}</td>
                        <td>{{ $category->meta_description }}</td>
                        <td>{{ $category->meta_keywords }}</td> --}}
                        <td>{{ $category->status ? 'Active' : 'Inactive' }}</td>
                        <td>
                            <a href="{{ route('categories.show', $category->category_id) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('categories.edit', $category->category_id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('categories.destroy', $category->category_id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div></div>
@endsection
