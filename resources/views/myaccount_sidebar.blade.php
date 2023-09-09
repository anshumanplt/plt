<nav class="myaccount-nav" style="padding-top: 10%; border: none;">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/my-account') }}">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Route::is('orders.index') ? 'active' : '' }}" href="{{ route('orders.index') }}">Orders</a>
        </li>
        <!-- Add more links as needed -->
    </ul>
</nav>