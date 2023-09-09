<!-- resources/views/attributes/show.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Attribute Details</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $attribute->name }}</h5>

                <div class="mb-3">
                    <label class="fw-bold">ID:</label>
                    <span>{{ $attribute->id }}</span>
                </div>

                <a href="{{ route('attributes.edit', $attribute->id) }}" class="btn btn-primary">Edit</a>
                <a href="{{ route('attributes.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
@endsection
