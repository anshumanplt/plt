<!-- resources/views/attribute_values/show.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Attribute Value Details</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $attributeValue->value }}</h5>

                <div class="mb-3">
                    <label class="fw-bold">ID:</label>
                    <span>{{ $attributeValue->id }}</span>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Attribute:</label>
                    <span>{{ $attributeValue->attribute->name }}</span>
                </div>

                <a href="{{ route('attribute_values.edit', $attributeValue->id) }}" class="btn btn-primary">Edit</a>
                <a href="{{ route('attribute_values.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
@endsection
