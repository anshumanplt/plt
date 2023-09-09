<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    public function index()
    {
        // Get the currently authenticated user
        $currentUser = Auth::user();
        $adminUsers = AdminUser::where('id', '!=', $currentUser->id)->paginate(10);
        return view('admin.users.index', compact('adminUsers'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        // Validate user input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admin_users|max:255',
            'password' => 'required|string|min:8',
        ]);

        // Create the admin user record
        $adminUser = new AdminUser([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        $adminUser->save();

        // Redirect with success message
        return redirect()->route('admin-users.index')->with('success', 'Admin user created successfully.');

    }

    public function show($id)
    {
        $adminUser = AdminUser::findOrFail($id);
        return view('admin.users.show', compact('adminUser'));
    }

    public function edit($id)
    {
        $adminUser = AdminUser::findOrFail($id);
        return view('admin.users.edit', compact('adminUser'));
    }

    public function update(Request $request, $id)
    {
        // Validate user input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        // Retrieve the admin user by ID
        $adminUser = AdminUser::findOrFail($id);

        // Update admin user data
        $adminUser->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            // Add more fields as needed
        ]);

        // Redirect with success message
        return redirect()->route('admin-users.index')->with('success', 'Admin user updated successfully.');

    }

    public function destroy($id)
    {
        // Delete logic
    }
}
