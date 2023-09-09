<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
    public function index()
    {
        return view('payment.payment');
    }

    public function processPayment(Request $request)
    {

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $order = $api->order->create([
            'receipt' => 'order_id_' . time(),
            'amount' => $request->input('amount'), // Amount in paise (e.g., 1000 for ₹10)
            'currency' => 'INR',
        ]);



        echo "<pre>"; print_r($orderId); die("check");

        return view('payment.payment', compact('orderId'));
    }

    public function paymentSuccess(Request $request)
    {
        // Handle successful payment
        return view('payment.success');
    }

    public function paymentFail(Request $request)
    {
        // Handle failed payment
        return view('payment.fail');
    }
}
