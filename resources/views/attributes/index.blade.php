<!-- resources/views/attributes/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
    <div class="container">
        <h1>Attributes</h1>

        <a href="{{ route('attributes.create') }}" class="btn btn-primary">Create New Attribute</a>

        <table class="table mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attributes as $attribute)
                    <tr>
                        <td>{{ $attribute->id }}</td>
                        <td>{{ $attribute->name }}</td>
                        <td>
                            <a href="{{ route('attributes.show', $attribute->id) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('attributes.edit', $attribute->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('attributes.destroy', $attribute->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this attribute?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div></div>    
@endsection
