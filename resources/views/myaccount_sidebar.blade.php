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
<div class="card">
  <a class="{{ Route::is('my-account') ? 'active' : '' }}" href="{{ url('/my-account') }}">Dashboard</a>
  <a class="{{ Route::is('account.addresses') ? 'active' : '' }}" href="{{ route('account.addresses') }}">My Addresses</a>
  <a class="{{ Route::is('account.profile') ? 'active' : '' }}" href="{{ route('account.profile') }}">My Profile</a>
  <a class="{{ Route::is('account.wishlist') ? 'active' : '' }}" href="{{ route('account.wishlist') }}">My Wishlist</a>

  <a class="{{ Route::is('orders.index') ? 'active' : '' }} {{ Route::is('orders.show') ? 'active' : '' }}" href="{{ route('orders.index') }}">My orders</a>
</div>