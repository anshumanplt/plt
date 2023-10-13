@extends('layouts.frontlayout')
@section('content')
    <div class="container" style="min-height: 450px;">
        <div class="breadcrumb-option">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcrumb__links">
                            <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                            <a href="javascript:void(0);" class="active">My Addressess</a>
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
                <h2>My Address</h2>

                <div style="padding-top: 2%; padding-bottom: 2%;">

                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal">Add
                        Address</button>
                </div>

                @foreach ($addresses as $value)
                    <div class="card">

                        <div class="card-body">
                            @php 
                                $cityData = App\Models\City::where('id', $value->city)->first();
                                $stateData = App\Models\State::where('id', $value->state)->first();
                                $countryData = App\Models\Country::where('id',$value->country)->first();

                                // echo $cityData->name;
                            @endphp
                            <p><b>{{ Auth::user()->name }} &nbsp; {{ $value->mobile }}</b><br>

                                {{ $value->address1 }}, {{ $value->address2 }}, {{ $cityData->name }},
                                <br>{{ $stateData->name }} - {{ $value->pin }}
                            </p>
                            <p><b>Default Address :</b>
                                @if ($value->is_default)
                                    Yes
                                @else
                                    No
                                @endif
                            </p>
                            <a href="{{ route('account.addresses.delete', $value->id) }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </div>

                    </div>
                @endforeach


                <!-- Modal -->
                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog modal-lg">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                {{-- <button type="button" class="close" data-dismiss="modal">&times;</button> --}}
                                <h4 class="modal-title">Add Address</h4>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('checkout.addAddress') }}" method="POST" class="checkout__form">
                                    @csrf
                            
                                   
                                      
                                            <div class="row">

                                                <div class="col-sm-12">

                                                    <div class="checkout__form__input">
                                                        <p>Address <span>*</span></p>
                                                        <input type="text" name="address1" required
                                                            placeholder="Address 1">
                                                        <input type="text" name="address2"
                                                            placeholder="Address 2 ( optinal )">
                                                    </div>
                                                    <div class="checkout__form__input">
                                                        <p>Country <span>*</span></p>
                                                        {{-- <input type="text">
                                                     --}}
                                                        <select name="country" id="country_id" required class="form-control"
                                                            id="">
                                                            <option value="">--Select Country--</option>
                                                            @foreach ($countries as $country)
                                                                <option value="{{ $country->id }}">{{ $country->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="checkout__form__input">
                                                        <p>State <span>*</span></p>
                                                        {{-- <input type="text"> --}}
                                                        <select id="state_id" required class="form-control" name="state">
                                                            <!-- Options for states... -->
                                                        </select>
                                                    </div>
                                                    <div class="checkout__form__input">
                                                        <p>Town/City <span>*</span></p>
                                                        {{-- <input type="text">
                                                     --}}
                                                        <select id="city_id" required class="form-control" name="city">
                                                            <!-- Options for cities... -->
                                                        </select>
                                                    </div>

                                                    <div class="checkout__form__input">
                                                        <p>Postcode/Zip <span>*</span></p>
                                                        <input name="pin" required type="text">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="checkout__form__input">
                                                        <p>Phone <span>*</span></p>
                                                        <input name="mobile" type="text">
                                                    </div>
                                                </div>
                                         
                                                <div class="col-sm-12">
                                                    <input type="submit" class="btn btn-danger" value="Add Address">
                                                </div>
                                            </div>
                                      
                               
                                </form>
                          

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    </div>
    </div>
    </div>
@endsection
