<!-- resources/views/attribute_values/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
    <div class="container">
        <h1>Create New Attribute Value</h1>

        <form action="{{ route('attribute_values.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="attribute_id">Attribute</label>
                <select name="attribute_id" id="attribute_id" class="form-control" required>
                    @foreach ($attributes as $attribute)
                        <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="value">Value</label>
                <input type="text" name="value" id="value" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
    </div></div>
@endsection
