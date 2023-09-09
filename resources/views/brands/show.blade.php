<!-- resources/views/brands/show.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Brand Details</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $brand->name }}</h5>

                <div class="mb-3">
                    <label class="fw-bold">ID:</label>
                    <span>{{ $brand->id }}</span>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Meta Title:</label>
                    <span>{{ $brand->meta_title }}</span>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Meta Description:</label>
                    <span>{{ $brand->meta_description }}</span>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Meta Keywords:</label>
                    <span>{{ $brand->meta_keywords }}</span>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Image:</label>
                    @if ($brand->image)
                        <img src="{{ asset('storage/' . $brand->image) }}" alt="Brand Image" width="200">
                    @else
                        <span>No Image</span>
                    @endif
                </div>

                <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-primary">Edit</a>
                <a href="{{ route('brands.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
@endsection
