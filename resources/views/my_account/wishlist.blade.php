@extends('layouts.frontlayout')
@section('content')
    <div class="container" style="min-height: 450px;">
        <div class="breadcrumb-option">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcrumb__links">
                            <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                            <a href="javascript:void(0);" class="active">My Wishlist</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        {{-- <div class="row">
            <div class="col-md-3">

                @include('myaccount_sidebar')
            </div>
            <div class="col-md-9">
                <h2>My Accounts</h2>
            
            </div>
        </div> --}}
        <div class="row">
            <div class="sidebar col-md-3">
                @include('myaccount_sidebar')
            </div>
            <div class="content col-md-9">
                <h2>My Wishlist</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($wishlistedProducts as $value)
                            <tr>
                                <td>{{ $value->product->name }}</td>
                                <td>{{ $value->product->description }}</td>
                                <td>
                                    @if ($value->product->productImages->count() > 0)
                                        <img src="{{ asset('storage/'.$value->product->productImages[0]->image_path) }}" alt="Product Image" style="max-width: 100px;">
                                    @else
                                        No Image
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('wishlist.remove', $value->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @if(count($wishlistedProducts) == 0) 
                            <tr>
                                <td colspan="4"><center>No Product in your wishlist</center></td>
                            </tr>
                        @endif
                    </tbody>
                </table>

       
            </div>

        </div>
    </div>

    </div>
    </div>
    </div>
@endsection
