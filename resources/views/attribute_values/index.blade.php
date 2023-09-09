<!-- resources/views/attribute_values/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
    <div class="container">
        <h1>Attribute Values</h1>

        <a href="{{ route('attribute_values.create') }}" class="btn btn-primary">Create New Attribute Value</a>

        <table class="table mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Attribute</th>
                    <th>Value</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attributeValues as $attributeValue)
                    <tr>
                        <td>{{ $attributeValue->id }}</td>
                        <td>{{ $attributeValue->attribute->name }}</td>
                        <td>{{ $attributeValue->value }}</td>
                        <td>
                            <a href="{{ route('attribute_values.show', $attributeValue->id) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('attribute_values.edit', $attributeValue->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('attribute_values.destroy', $attributeValue->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this attribute value?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div></div>
@endsection
