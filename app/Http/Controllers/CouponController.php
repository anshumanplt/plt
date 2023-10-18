<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Order;
use Carbon\Carbon;

class CouponController extends Controller
{
    public function validateCoupon(Request $request)
    {
        $couponCode = $request->input('couponCode');
    
        // Perform coupon validation logic (e.g., check against the database)

        $coupon = Coupon::where('code', $couponCode)
        ->where('status', 1)
        ->where('expiration_date', '>=', Carbon::now())
        ->first();

        // if ($coupon) {
        //     return $coupon->discount_amount;
        // }

        // return 0; // Coupon is not valid
    
        if ($coupon) {
            
            session_start();
            $_SESSION['discount_code'] = $couponCode;

            


            return response()->json(['valid' => true, 'coupon'=>$coupon]);
        } else {
            return response()->json(['valid' => false]);
        }
    }


    public function index()
    {
        $coupons = Coupon::all();
        return view('coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('coupons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:coupons',
            'type' => 'required|in:flat,percentage',
            'discount' => 'required|numeric',
            'expiration_date' => 'required|date',
        ]);

        Coupon::create($request->all());

        return redirect()->route('coupons.index')->with('success', 'Coupon created successfully.');
    }

    public function edit(Coupon $coupon)
    {
        return view('coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'code' => 'required|unique:coupons,code,' . $coupon->id,
            'type' => 'required|in:flat,percentage',
            'discount' => 'required|numeric',
            'expiration_date' => 'required|date',
        ]);

        $coupon->update($request->all());

        return redirect()->route('coupons.index')->with('success', 'Coupon updated successfully.');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('coupons.index')->with('success', 'Coupon deleted successfully.');
    }
}
