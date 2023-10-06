<style>
    <!-- Breadcrumb Begin -->
    .sidebar {
      margin: 0;
      padding: 0;
      width: 100%;
      background-color: #f1f1f1;
      position: fixed;
      height: 100%;
      overflow: auto;
    }
    
    .sidebar a {
      display: block;
      color: black;
      padding: 16px;
      text-decoration: none;
    }
     
    .sidebar a.active {
      background-color: #373c3a;
      color: white;
    }
    
    .sidebar a:hover:not(.active) {
      background-color: #555;
      color: white;
    }
    
    div.content {
      /* margin-left: 200px; */
      padding: 1px 16px;
      height: 100%;
    }
    
    @media screen and (max-width: 700px) {
      .sidebar {
        width: 100%;
        height: auto;
        position: relative;
      }
      .sidebar a {float: left;}
      div.content {margin-left: 0;}
    }
    
    @media screen and (max-width: 400px) {
      .sidebar a {
        text-align: center;
        float: none;
      }
    }
</style>

<a class="{{ Route::is('my-account') ? 'active' : '' }}" href="{{ url('/my-account') }}">Dashboard</a>
<a class="{{ Route::is('my-account') ? 'active' : '' }}" href="{{ url('/my-account') }}">My Addresses</a>
<a class="{{ Route::is('orders.index') ? 'active' : '' }} {{ Route::is('orders.show') ? 'active' : '' }}" href="{{ route('orders.index') }}">My orders</a>
{{-- <a href="#contact">Contact</a>
<a href="#about">About</a> --}}
{{-- <nav class="myaccount-nav" style="padding-top: 10%; border: none;">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/my-account') }}">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Route::is('orders.index') ? 'active' : '' }}" href="{{ route('orders.index') }}">Orders</a>
        </li>
        <!-- Add more links as needed -->
    </ul>
</nav> --}}