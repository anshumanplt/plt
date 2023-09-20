<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Address;
use App\Models\City;
use App\Models\State;
use App\Models\Country;

class CheckoutController extends Controller
{
    public function index()
    {

        $user = Auth::user();
        // $cartItems = $user->cartItems;
        $cartItems = Cart::where('user_id', $user->id)
        ->with('product') // Eager load the product relationship
        ->get();
        $addresses = $user->addresses;

        $categories = Category::where('parent_id', 	NULL)->orderBy('category_id')->take(5)->get();

        $allMenu = [];
        foreach($categories as $value) {
            $subMenu = Category::where('parent_id', $value->category_id)->get();
            $value['submenu'] = $subMenu;
            $allMenu[] = $value;
        }


        $categories = $allMenu;

        $countries = Country::get();

        // echo "<pre>"; print_r($cartItems); die("check");

        return view('checkout.index', compact('cartItems', 'addresses', 'categories', 'countries'));
    }

    public function addAddress(Request $request)
    {
        // echo "<pre>"; print_r($request->all()); die("check");
        $user = Auth::user();
        
        $request->validate([
            'address1' => 'required',
            'country' => 'required',
            'pin' => 'required',
            'state' => 'required',
            'city'  => 'required'
        ]);

        // Address::create([
        //     'user_id' => $user->id,
        //     'address' => $request->address,
        //     'city' => $request->city,
        //     'postal_code' => $request->postal_code,
        // ]);
        
        Address::where('user_id', Auth::user()->id)->update(['is_default' => 0 ]);
        $data = [
            "user_id"  => Auth::user()->id, 
            "address1" => $request->input('address1'),
            "address2" => $request->input('address2'),
            "country"  => $request->input('country'),
            "state"    => $request->input('state'),
            "city"     => $request->input('city'),
            "pin"      => $request->input('pin'),
            "mobile"   => $request->input('mobile'),
            "is_default" => 1    
        ];
        $status = Address::create($data);

        
        // echo "<pre>"; print_r($status); die("check");
        return redirect()->route('checkout.index')->with('success', 'Address added successfully.');
    }

    public function setDefaultAddress(Request $request )
    {
        $address = Address::findOrFail($request->input('addressid'));

        // Mark the selected address as default for the user
        Address::where('user_id', auth()->id())->update(['is_default' => false]);
        $address->update(['is_default' => true]);

        return redirect()->back()->with('success', 'Default address updated successfully.');
    }
}
