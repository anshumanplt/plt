<!-- resources/views/categories/show.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Category Details</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $category->name }}</h5>

                <div class="mb-3">
                    <label class="fw-bold">Category ID:</label>
                    <span>{{ $category->category_id }}</span>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Image:</label>
                    @if ($category->image)
                        <img src="{{ asset('images/' . $category->image) }}" alt="Category Image" width="200">
                    @else
                        <span>No Image</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Parent Category:</label>
                    <span>{{ $category->parentCategory ? $category->parentCategory->name : 'None' }}</span>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Meta Title:</label>
                    <span>{{ $category->meta_title }}</span>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Meta Description:</label>
                    <span>{{ $category->meta_description }}</span>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Meta Keywords:</label>
                    <span>{{ $category->meta_keywords }}</span>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Status:</label>
                    <span>{{ $category->status ? 'Active' : 'Inactive' }}</span>
                </div>

                <a href="{{ route('categories.edit', $category->category_id) }}" class="btn btn-primary">Edit</a>
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
@endsection
