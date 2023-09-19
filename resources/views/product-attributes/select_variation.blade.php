@extends('layouts.app') {{-- Assuming you have a layout file --}}

@section('content')

<div class="card">
    <div class="card-body">

        <div class="container">
            <h2>Create Product Variant</h2>

            {{-- <a href="{{ route('product-attributes.index', $productId) }}" class="btn btn-primary">Back to listing</a> --}}
            <a href="{{ route('products.index') }}"  class="btn btn-primary" >Back to product listing</a>
            {{-- <a href="{{ route('product-attributes.createAllvariation',  $productId) }}" class="btn btn-primary" >Create All Variation</a> --}}
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif

            <table class="table">
                <tr>
                    <th>#</th>
                    @foreach($allAttribute as $value)
                        <th>{{ $value->name }}</th>
                    @endforeach
                 
              



                </tr>
                @foreach($allcreatedVariant as $key =>  $value)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    @foreach($value as $item)
                        <td>
                            @php
                            $attributevalue = \App\Models\AttributeValue::where('id', $item)->first();  
                            echo $attributevalue->value;
                            @endphp

                        </td>
                    @endforeach
                        
                            
                        <td >
                            <?php 
                                $getAtt = \App\Models\ProductAttribute::where(['attribute_value_id' => implode(',', $value), 'product_id' => $productId])->first();  
                                // echo "<pre>"; print_r($getAtt); die("check");  
                            ?>
                            @if($getAtt) 
                             <a href="{{ route('product-attributes.showImages', ['sku' => $getAtt->sku, 'productid' => $productId]) }}">Check Images</a>
                            <form method="POST" enctype="multipart/form-data" action="{{ route('product-attributes.update', $getAtt->id) }}">
                                @method('PUT')
                            @else
                            <form method="POST" enctype="multipart/form-data" action="{{ route('product-attributes.store') }}">
                            @endif

                                @csrf

                                <input type="hidden" name="attributes" value="<?php echo implode(',', $value); ?>">
                                <div class="form-group">
                                    <label for="SKU">SKU</label>
                                    <input type="hidden" name="product_id" value="{{ $productId }}">
                                    <input type="text" placeholder="SKU" value="{{ @$getAtt->sku }}"  name="sku" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="Price">Price</label>
                                    <input type="number" placeholder="Price" value="{{ @$getAtt->price }}"  name="price" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="Quantity">Quantity</label>
                                    <input type="number" placeholder="Quantity" value="{{ @$getAtt->inventory }}"  name="inventory" class="form-control">

                                </div>
                                <div class="form-group">
                                    <label for="">Product Images</label>
                                    <input type="file" class="form-control" name="files[]" multiple id="">
                                </div>
                                <div class="form-group">
                                <input type="submit" value="Add" class="btn btn-info">

                                </div>
                                
                                
                            </form>
                          
                            
                               
                 
                    </td>
                        
                    </tr>
                    
                @endforeach
            </table>

        </div>
    </div>
</div>

@endsection