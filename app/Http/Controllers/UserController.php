<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class UserController extends Controller
{
    public function profile() {
        $categories = Category::where('parent_id', 	NULL)->orderBy('category_id')->take(5)->get();

        $allMenu = [];
        foreach($categories as $value) {
            $subMenu = Category::where('parent_id', $value->category_id)->get();
            $value['submenu'] = $subMenu;
            $allMenu[] = $value;
        }


        $categories = $allMenu;


        return view('my_account.profile', compact('categories'));
    }

    public function checkOldPassword(Request $request)
    {
        $user = auth()->user();
    
        if (Hash::check($request->old_password, $user->password)) {
            return response()->json(['message' => 'Old password is correct']);
        }
    
        return response()->json(['error' => 'Old password is incorrect'], 422);
    }
    public function changePassword(Request $request)
    {

        // Validate the request data
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:8',
        ]);



        $user = auth()->user();

        // Check if the old password matches the user's current password
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->with('error', 'The old password is incorrect.');
        }

        // Update the user's password
        $user->password = Hash::make($request->password);
        $user->save();

        Auth::logout();

        return redirect('/login');
        // return redirect()->back()->with('success', 'Password changed successfully.');
    }
}
