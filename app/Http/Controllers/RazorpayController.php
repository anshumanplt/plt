<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Support\Facades\App;

class RazorpayController extends Controller
{
    public function createOrder($orderIdData)
    {

        $orderData = Order::where('id', $orderIdData)->first();
        // echo "<pre>"; print_r($orderData); die("check");
        // echo "RAZORPAY_KEY : ".env('RAZORPAY_KEY')."<br>";
        // echo "RAZORPAY_SECRET : ".env('RAZORPAY_SECRET')."<br>";


        $categories = Category::where('parent_id', 	NULL)->orderBy('category_id')->take(5)->get();

        $allMenu = [];
        foreach($categories as $value) {
            $subMenu = Category::where('parent_id', $value->category_id)->get();
            $value['submenu'] = $subMenu;
            $allMenu[] = $value;
        }



        $categories = $allMenu;
        if(App::environment() == 'local') {
               $RAZORPAY_KEY = 'rzp_test_MieaCsbx9Y9ns7';
               $RAZORPAY_SECRET = '1zHBvyQSh59yEcMKnpMY86DF';
        }else{
            $RAZORPAY_KEY = 'rzp_live_U7Ohduc1Dvz9aS';
            $RAZORPAY_SECRET = '5NndwWm8GgOXdC3N3fITJJT6';
        }

  
        // die("check");
        $api = new Api($RAZORPAY_KEY, $RAZORPAY_SECRET);

        $order = $api->order->create([
            'amount' => $orderData->total_amount * 100, // Order amount in paise
            'currency' => 'INR',
            'payment_capture' => 1 // Auto-capture payment
        ]);

        $orderId = $order->id;

        $orderAmount = $orderData->total_amount * 100;

        return view('razorpay.payment', compact('orderId', 'orderAmount', 'orderIdData','categories', 'RAZORPAY_KEY'));
    }
}
