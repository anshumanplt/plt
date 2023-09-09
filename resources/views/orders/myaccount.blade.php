@extends('layouts.frontlayout')
@section('content')
      <!-- Breadcrumb Begin -->
      <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                      
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container" style="min-height: 450px;">
    
        <div class="row">
            <div class="col-md-3">
                @include('myaccount_sidebar')
            </div>
            <div class="col-md-9">
                <h2>My Accounts</h2>
            
            </div>
        </div>
    </div>

@endsection