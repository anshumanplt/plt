<!-- resources/views/admin/users/index.blade.php -->

@extends('layouts.app') {{-- Use your admin layout --}}

@section('content')
<div class="card">
    <div class="card-body">

        <div class="container">
            <h1>Home Page Settings</h1>

            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            {{-- <a href="{{ route('admin-users.create') }}" class="btn btn-primary mb-3">Create Admin User</a> --}}

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        
            <form action="{{ route('admin.settings.homepage.update') }}" method="post">
                @csrf
                <div class="form-group">
                    <input type="hidden" name="setting_type" value="home">
                    <label for="">Select category to show on home page : </label>
                    <select name="categories[]" id="" multiple class="form-control">
                        <option value="">--Select Categories--</option>
                        @php 
                            $categoryIds = []; 
                            if($getHomeSetting) {
                                $categoryIds = explode(',',$getHomeSetting->category_ids); 
                            }

                        @endphp
                        @foreach($categories as $category)
                            <option value="{{ $category->category_id }}" @if(in_array($category->category_id, $categoryIds)) selected @endif>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Update Home Page Setting">
                </div>
            </form>

            <h3>Add Banners</h3>

            <form method="POST" action="{{ route('admin.settings.homepage.addbanner') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="banner_image">Banner Image:</label>
                    <input type="file" name="banner_image" id="banner_image" class="form-control">
                </div>
                <div class="form-group">
                    <label for="url">URL:</label>
                    <input type="text" name="url" id="url" class="form-control">
                </div>
                <div class="form-group">
                    <label for="position">Position:</label>
                    <input type="number" name="position" id="position" class="form-control">
                </div>
                <div class="form-group">
                    <label for="status">Status:</label>
                    <select name="status" id="status" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Add Banner</button>
            </form>


            <table class="table">
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Position</th>
                    <th>URL</th>
                    <th>Action</th>

                </tr>
                @foreach($banners as $key =>  $banner)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td><img src="{{ asset('storage/'.$banner->banner_image) }}" class="img-responsive" height="100" width="100" alt=""></td>
                        <td>{{ $banner->position }}</td>
                        <td><a href="{{ $banner->url }}">Click Here</a></td>
                        <td>
                            <form method="POST" action="{{ route('admin.settings.homepage.removebanner', $banner->id) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection
