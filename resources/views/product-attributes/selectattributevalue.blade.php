@extends('layouts.app') {{-- Assuming you have a layout file --}}

@section('content')

<div class="card">
    <div class="card-body">
        <div class="container">
            
            <h1>Select Attribute Value for product</h1>
            <a href="{{ route('products.index') }}"  class="btn btn-primary" >Back to product listing</a>
            <form action="{{ route('product-attributes.generatefinalvariationonselection', $product) }}" method="get">
                @foreach($allAttribute as $key => $value)
                    <div class="form-group">
                        <label for="">{{ $value->name }}</label>
                        <select name="{{$key}}[]" multiple class="form-control" id="">
                            <option value="">-- Select option --</option>
                            @foreach ($value->attributeValues as $item)
                                <option value="{{ $item->id }}">{{ $item->value }}</option>
                            @endforeach
                        </select>
                    </div>
                @endforeach
                <input type="submit" value="Create Product variation" class="btn btn-info">
            </form>
        </div>
    </div>
</div>

@endsection