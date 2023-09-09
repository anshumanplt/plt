<!-- resources/views/admin/users/index.blade.php -->

@extends('layouts.app') {{-- Use your admin layout --}}

@section('content')
<div class="card">
    <div class="card-body">

        <div class="container">
            <h1>Admin Users</h1>


            <a href="{{ route('admin-users.create') }}" class="btn btn-primary mb-3">Create Admin User</a>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($adminUsers as $adminUser)
                        <tr>
                            <td>{{ $adminUser->name }}</td>
                            <td>{{ $adminUser->email }}</td>
                            <td>
                                <a href="{{ route('admin-users.show', $adminUser->id) }}" class="btn btn-info">View</a>
                                <a href="{{ route('admin-users.edit', $adminUser->id) }}" class="btn btn-warning">Edit</a>
                           
                                  <!-- Delete form -->

                                    <form action="{{ route('admin-users.destroy', $adminUser->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                    </form>
                         
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $adminUsers->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
