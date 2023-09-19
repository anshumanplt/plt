<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
    public function index()
    {
      
        return view('payment.payment');
    }

    public function processPayment(Request $request, $orderid)
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

        $paymentId = $request->input('payment_id');
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        try {
            $payment = $api->payment->fetch($paymentId);
            
            // echo "<pre>"; print_r($payment); die("check");

            // Handle payment success
            if ($payment->status === 'authorized') {
                $updateOrder = Order::where('id', $payment->description)->update([
                    'payment_status' => 'success',
                    'payment_id' => $payment->id
                ]);
                return redirect()->route('orders.index')->with('success', 'Order placed successfully.');
                // Payment was successful
                // Update your database, mark the order as paid, etc.
                // Redirect the user to a thank you page or send a confirmation email.
            } else {
                $updateOrder = Order::where('id', $payment->description)->update([
                    'payment_status' => 'failed',
                    'payment_id' => $payment->id,
                    'order_state' => 'cancel'
                ]);
                return redirect()->route('orders.index')->with('success', 'Order failed.');
                // Payment failed or pending
                // Handle accordingly
            }
        } catch (\Throwable $e) {
            die("error");
            // Handle errors, log them, and inform the user if necessary
        }

        // echo "<pre>"; print_r($request->all()); die("check");
        // // Handle successful payment
        // return view('payment.success');
    }

    public function paymentFail(Request $request)
    {
        // Handle failed payment
        return view('payment.fail');
    }
}
