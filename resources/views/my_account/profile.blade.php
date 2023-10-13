@extends('layouts.frontlayout')
@section('content')
    <div class="container" style="min-height: 450px;">
        <div class="breadcrumb-option">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcrumb__links">
                            <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                            <a href="javascript:void(0);" class="active">My Profile</a>
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
                
                <div class="well">
                    <ul class="nav nav-tabs">
                      <li class="active" style="padding: 1%;"><a href="#home" data-toggle="tab">Profile</a></li> &nbsp;
                      <li style="padding: 1%;"><a href="#profile"  data-toggle="tab">Password</a></li>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                      <div class="tab-pane active in" id="home">
                        <h4>My Profile</h4>
                        <br>
                        <form id="tab">
                            
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" readonly value="{{ Auth::user()->name }}" class="form-control">
                            </div>
                           
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" value="{{ Auth::user()->email }}" readonly class="form-control">
                            </div>
                        
                        
                              <div>
                                {{-- <button class="btn btn-primary">Update</button> --}}
                            </div>
                        </form>
                      </div>
                      <div class="tab-pane fade" id="profile">
                        <h4>Change Password</h4><br>
                        <form action="{{ route('change.password.post') }}" method="post" id="tab2">
                            @csrf
                            <div>
                                <span id="message" class="error"></span>
                            </div>
                            <div class="form-group">
                                <label for="">Old Password</label>
                                <input type="password" id="old_password" required name="old_password" placeholder="Old Password" class="form-control" id="">
                            </div>
                            <div class="form-group">
                                <button id="check_password" class="btn btn-primary">Check Password</button>
                            </div>
                            <div id="change_password" style="display: none;">
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input type="password" required placeholder="New Password" id="password" name="password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Confirm New Password</label>
                                    <input type="password" required name="confirmed" id="confirmPassword" placeholder="Confirm New Password" class="form-control">
                                    
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary" >Change Password</button>
                                </div>
                            </div>
                        </form>


                      </div>
                  </div>
       
            </div>

        </div>
    </div>

    </div>
    </div>
    </div>


    <script>
        const passwordField = document.getElementById('password');
        const confirmPasswordField = document.getElementById('confirmPassword');
        const message = document.getElementById('message');

        // Function to check if passwords match
        const checkPasswordMatch = () => {
            if (passwordField.value === confirmPasswordField.value) {
                message.innerHTML = 'Passwords match';
                message.style.color = 'green';
            } else {
                message.innerHTML = 'Passwords do not match';
                message.style.color = 'red';
            }
        };

        // Add an event listener to the confirmPassword field
        confirmPasswordField.addEventListener('keyup', checkPasswordMatch);

    </script>

    
<script>
    document.getElementById('check_password').addEventListener('click', function () {
        const oldPassword = document.getElementById('old_password').value;

        $.ajax({
            url: '{{ route('check.old.password') }}',
            method: 'POST',
            data: {
                old_password: oldPassword,
                "_token": "{{ csrf_token() }}",
            },
            success: function (response) {
                // Password is correct, show the "Update" button
                document.getElementById('message').textContent = response.message;
                document.getElementById('message').style.color = 'green';
                document.getElementById('change_password').style.display = 'block';
            },
            error: function (xhr) {
                // Password is incorrect, display an error message
                const response = JSON.parse(xhr.responseText);
                document.getElementById('message').textContent = response.error;
                document.getElementById('message').style.color = 'red';
                document.getElementById('change_password').style.display = 'none';
            }
        });
    });
</script>
@endsection
