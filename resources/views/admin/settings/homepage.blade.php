<!-- resources/views/admin/users/index.blade.php -->

@extends('layouts.app') {{-- Use your admin layout --}}

@section('content')
<h3 class="page-title">Home Page Settings</h3>

<div class="row">
    <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Home Page Banners</h4>
                <br>
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
            </div>
        </div>
    </div>
    <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
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

</div>
<div class="row">
    <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="container">
                    <h4 class="card-title">Home Page categories</h4>
                    <br>

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


                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Add Banner of promotional section</h4>
                <form action="{{ route('admin.settings.promotional.banner') }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">Select Background Image:</label>
                        <input type="file" name="background_image" class="form-control" id="">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Update background Image" class="btn btn-primary">
                    </div>
                </form>
                <hr>
                <h6>Promotional Image</h6>
                @if($promotionalBanner)
                    <img src="{{ asset('storage/'.$promotionalBanner->background_image) }}" height="250" width="100%">
                @endif
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">promotional section text slider</h4>
                <form action="{{ route('admin.settings.promotional.slider') }}" enctype="multipart/form-data" method="post">
                    @csrf
                   <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" name="title" required class="form-control" id="">
                   </div>
                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea name="description" id="" required cols="30" rows="10" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">URL</label>
                        <input type="text" name="url" required class="form-control" id="">
                   </div>
                    <div class="form-group">
                        <input type="submit" value="Update background Image" class="btn btn-primary">
                    </div>
                </form>
              
            </div>
        </div>
    </div>
    <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>URL</th>
                        <th>Action</th>
                    </tr>
                    @foreach($promotionalSlider as $key => $value)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $value->title }}</td>
                            <td>{{ $value->description }}</td>
                            <td><a href="{{ $value->url }}" target="_blank">Click Here</a></td>
                            <td><a href="{{ route('admin.settings.promotional.slider.delete', $value->id) }}">Delete</a></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Discount Section Update</h4>
                <form action="{{ route('admin.settings.discount.banner') }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">Select Discount Background Image:</label>
                        <input type="file" name="discount_background_image" class="form-control" id="">
                    </div>
                    <div class="form-group">
                        <label for="">URL:</label>
                        <input type="text" name="url" class="form-control" value="" id="">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Update discount background Image" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                @if($discountbanner)
                    <img src="{{ asset('storage/'.$discountbanner->discount_background_image) }}" width="100%" alt="">
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
