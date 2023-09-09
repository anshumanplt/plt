<!-- resources/views/attribute_values/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
    <div class="container">
        <h1>Edit Attribute Value</h1>

        <form action="{{ route('attribute_values.update', $attributeValue->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="attribute_id">Attribute</label>
                <select name="attribute_id" id="attribute_id" class="form-control" required>
                    @foreach ($attributes as $attribute)
                        <option value="{{ $attribute->id }}" {{ $attributeValue->attribute_id == $attribute->id ? 'selected' : '' }}>{{ $attribute->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="value">Value</label>
                <input type="text" name="value" id="value" class="form-control" value="{{ $attributeValue->value }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
    </div></div>
@endsection
