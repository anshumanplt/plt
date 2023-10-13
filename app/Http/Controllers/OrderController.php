<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderItem;
use App\Models\Category;



class OrderController extends Controller
{
    public function index()
    {

        $user = Auth::user();
    
        // Fetch the user's orders along with related address information
        $orders = Order::with('address')
                       ->where('user_id', $user->id)
                       ->orderBy('created_at', 'desc')
                       ->paginate(5);

        // echo "<pre>"; print_r($orders); die("check");
        
        $categories = Category::where('parent_id', 	NULL)->orderBy('category_id')->take(5)->get();

        $allMenu = [];
        foreach($categories as $value) {
            $subMenu = Category::where('parent_id', $value->category_id)->get();
            $value['submenu'] = $subMenu;
            $allMenu[] = $value;
        }



        $categories = $allMenu;
    
        return view('orders.index', compact('orders', 'categories'));
    }

    public function getallorders() {
   
    
        // Fetch the user's orders along with related address information
        $orders = Order::with('address')
                  
                       ->orderBy('created_at', 'desc')
                       ->paginate(15);

    
        return view('admin.orders.index', compact('orders'));
    }

    public function showadmin(Order $order) {
        $order->load('orderItems','orderItems.product');
        return view('admin.orders.show', compact('order'));
    }

    public function makeshippingorder() {
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL             => "https://pre-alpha.ithinklogistics.com/api/order/add.json",
          CURLOPT_RETURNTRANSFER  => true,
          CURLOPT_ENCODING        => "",
          CURLOPT_MAXREDIRS       => 10,
          CURLOPT_TIMEOUT         => 30,
          CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST   => "POST",
          CURLOPT_POSTFIELDS      => "{\"data\":{\"shipments\":[{\"waybill\":\"\",\"order\":\"GK0034\",\"sub_order\":\"\",\"order_date\":\"31-01-2018\",\"total_amount\":\"999\",\"name\":\"Bharat\",\"company_name\":\"ABC Company\",\"add\":\"104 Shreeji\",\"add2\":\"\",\"add3\":\"\",\"pin\":\"400067\",\"city\":\"Mumbai\",\"state\":\"Maharashtra\",\"country\":\"India\",\"phone\":\"9876543210\",\"alt_phone\":\"9876542210\",\"email\":\"abc@gmail.com\",\"is_billing_same_as_shipping\":\"no\",\"billing_name\":\"Bharat\",\"billing_company_name\":\"ABC Company\",\"billing_add\":\"104, Shreeji Sharan\",\"billing_add2\":\"\",\"billing_add3\":\"\",\"billing_pin\":\"400067\",\"billing_city\":\"Mumbai\",\"billing_state\":\"Maharashtra\",\"billing_country\":\"India\",\"billing_phone\":\"9876543210\",\"billing_alt_phone\":\"9876543211\",\"billing_email\":\"abc@gmail.com\",\"products\":[{\"product_name\":\"Green color tshirt\",\"product_sku\":\"GC001-1\",\"product_quantity\":\"1\",\"product_price\":\"100\",\"product_tax_rate\":\"5\",\"product_hsn_code\":\"91308\",\"product_discount\":\"0\"},{\"product_name\":\"Red color tshirt\",\"product_sku\":\"GC002-2\",\"product_quantity\":\"1\",\"product_price\":\"200\",\"product_tax_rate\":\"5\",\"product_hsn_code\":\"91308\",\"product_discount\":\"0\"}],\"shipment_length\":\"10\",\"shipment_width\":\"10\",\"shipment_height\":\"5\",\"weight\":\"400.00\",\"shipping_charges\":\"0\",\"giftwrap_charges\":\"0\",\"transaction_charges\":\"0\",\"total_discount\":\"0\",\"first_attemp_discount\":\"0\",\"cod_amount\":\"550\",\"payment_mode\":\"COD\",\"reseller_name\":\"\",\"eway_bill_number\":\"\",\"gst_number\":\"\",\"return_address_id\":\"24\"}],\"pickup_address_id\":\"24\",\"access_token\":\"42e4c8c60fc4f6d43f1d36bbda354099\",\"secret_key\":\"b89f61a8b88b43a7fb8ab3b151359978\",\"logistics\":\"fedex\",\"s_type\":\"ground\",\"order_type\":\"\"}}",

        // CURLOPT_POSTFIELDS => json_encode([
        //     "data" => [
        //         "access_token" => "42e4c8c60fc4f6d43f1d36bbda354099",
        //         "secret_key" => "b89f61a8b88b43a7fb8ab3b151359978",
        //         "shipments" => [
        //             "waybill" => "",
        //             "order" => "GK00345",
        //             "order_date" => date("d-m-Y h:m:s"),
        //             "total_amount" => "999",
        //             "name" => "",
        //             "company_name" => "",
        //             "add" => "",
        //             "add2" => "",
        //             "add3" => "",
        //             "pin" => 400067,
        //             "city" => "Mumbai",
        //             "state" => "Maharashtra",
        //             "country" => "India",
        //             "phone" => 9876543210,
        //             "alt_phone" => 9876542210,
        //             "email" => "abc@gmail.com",
        //             "is_billing_same_as_shipping" => "no",
        //             "billing_name" => "Bharat",
        //             "billing_company_name" => "ABC Company",
        //             "billing_add" => "104, Shreeji Sharan",
        //             "billing_add2" => "",
        //             "billing_add3" => "",
        //             "billing_pin" => "400067",
        //             "billing_city" => "Mumbai",
        //             "billing_state" => "Maharashtra",
        //             "billing_country" => "India",
        //             "billing_phone" => 9876543210,
        //             "billing_alt_phone" => 9876543211,
        //             "billing_email" => "abc@gmail.com",
        //             "products" => [
        //                 [
        //                     "product_name" => "Green color tshirt",
        //                     "product_sku"  => "GC001-1",
        //                     "product_quantity" => 1,
        //                     "product_price" => 100.00,
        //                     "product_tax_rate" => 5.00,
        //                     "product_hsn_code" => "91308",
        //                     "product_discount" => 0
        //                 ]
        //                 ],
        //             "shipment_length" => 10.00,
        //             "shipment_width" => 10.00,
        //             "shipment_height" => 5.00,
        //             "weight" => 400.00,
        //             "shipping_charges" => 0.00,
        //             "giftwrap_charges" => 0.00,
        //             "transaction_charges" => 0.00,
        //             "total_discount" => 0.00,
        //             "first_attemp_discount" => 0.00,
        //             "cod_amount" => 550.00,
        //             "payment_mode" => "COD",
        //             "reseller_name" => "",
        //             "eway_bill_number" => "",
        //             "gst_number" => "",
        //             "return_address_id" => 24   
        //             ],
        //         "pickup_address_id" => 24
        //     ]
        // ]),
        //   CURLOPT_POSTFIELDS =>    json_encode(   [
        //     "data"=>     [ 
        //                         "shipments"   => [ 
        //                                                                 [
        //                                                                 "waybill" => "", 
        //                                                                 "order" => "GK0033", 
        //                                                                 "sub_order" => "A", 
        //                                                                 "order_date" => "31-01-2018", 
        //                                                                 "total_amount" => "999", 
        //                                                                 "name" => "Bharat", 
        //                                                                 "add" => "104, Shreeji Sharan", 
        //                                                                 "pin" => "400067", 
        //                                                                 "city" => "Mumbai", 
        //                                                                 "state" => "Maharashtra", 
        //                                                                 "country" => "India", 
        //                                                                 "phone" => "9876543210", 
        //                                                                 "email" => "abc@gmail.com", 
        //                                                                 "products" => "T-Shirt", 
        //                                                                 "products_desc" => "Clothing", 
        //                                                                 "quantity" => "1", 
        //                                                                 "shipment_length" => "10", 
        //                                                                 "shipment_width" => "10", 
        //                                                                 "shipment_height" => "5", 
        //                                                                 "weight" => "400.00", 
        //                                                                 "cod_amount" => "999", 
        //                                                                 "payment_mode" => "COD", 
        //                                                                 "seller_tin" => "", 
        //                                                                 "seller_cst" => "", 
        //                                                                 "return_address_id" => "24", 
        //                                                                 "product_sku" => "S01", 
        //                                                                 "extra_parameters" =>  
        //                                                                                                               [ 
        //                                                                                                               "return_reason" => "", 
        //                                                                                                               "encryptedShipmentID" => "" 
        //                                                                                                               ] 
        //                         ] 
        //                                                         ], 
        //                         "pickup_address_id" => "24",
        //                         "access_token" => "42e4c8c60fc4f6d43f1d36bbda354099", #You will get this from iThink Logistics Team 
        //                         "secret_key" => "b89f61a8b88b43a7fb8ab3b151359978"  #You will get this from iThink Logistics Team 
        //   ]
        //                     ]),  
          CURLOPT_HTTPHEADER      => array(
              "cache-control: no-cache",
              "content-type: application/json"
          )
        ));
    
        $response = curl_exec($curl);
        $err      = curl_error($curl);
        curl_close($curl);
        if ($err) 
        {
          echo "cURL Error #:" . $err;
        }
        else
        {
          echo $response;
        }
    }

    
    public function show(Order $order)
    {   

        // Load the order details along with related order items and products
        $order->load('orderItems','orderItems.product');

        $categories = Category::where('parent_id', 	NULL)->orderBy('category_id')->take(5)->get();

        $allMenu = [];
        foreach($categories as $value) {
            $subMenu = Category::where('parent_id', $value->category_id)->get();
            $value['submenu'] = $subMenu;
            $allMenu[] = $value;
        }



        $categories = $allMenu;

        return view('orders.show', compact('order', 'categories'));
    }

    public function cancel(Order $order)
    {
        if ($order->order_state === 'pending') {
            $order->update(['order_state' => 'cancel']);
            return redirect()->route('orders.show', $order->id)->with('success', 'Order has been canceled.');
        }

        return redirect()->route('orders.show', $order->id)->with('error', 'Order cannot be canceled.');
    }

    public function updatestatus(Order $order, Request $request) {

        // echo "<pre>"; print_r($request->all()); die("check");

        $order->update(['order_state' => $request->input('orderstatus')]);
        return redirect()->route('admin.orders.show', $order->id)->with('success', 'Order has been '.$request->input('orderstatus'));

    }

    public function myaccount() {
        
        $categories = Category::where('parent_id', 	NULL)->orderBy('category_id')->take(5)->get();

        $allMenu = [];
        foreach($categories as $value) {
            $subMenu = Category::where('parent_id', $value->category_id)->get();
            $value['submenu'] = $subMenu;
            $allMenu[] = $value;
        }



        $categories = $allMenu;

        return view('orders.myaccount', compact('categories'));
    }

    public function placeOrder(Request $request)
    {
       
        $user = auth()->user();
        $cartItems = Cart::where('user_id', $user->id)->get();
        $defaultAddress = Address::where('user_id',$user->id)->first();
    
        // Begin a database transaction
        DB::beginTransaction();
    
        try {

            // echo "<pre>"; print_r($cartItems); die("check");


            if($request->input('payment_method') == "COD") {
                $orderStatus = 'pending';
            }else{
                $orderStatus = 'payment_pending';
            }

            $insertData = [
                'user_id' => $user->id,
                'address_id' => $defaultAddress->id,
                'payment_method' => $request->input('payment_method'),
                'order_state' => $orderStatus, // Set the initial state
                'total_amount' => 0, // Placeholder, will be updated later
            ];

          
            // Create the order
            $order = new Order($insertData);
    
            $order->save();
            
      
            
            $totalAmount = 0;


            foreach ($cartItems as $cartItem) {
                $product = Product::findOrFail($cartItem->product_id);
                $getPrice = \App\Models\ProductAttribute::where('sku', $cartItem->sku)->first();
                // Calculate subtotal
                // $subtotal = $product->sale_price * $cartItem->quantity;
                $subtotal = $getPrice->price * $cartItem->quantity;

               
             
                // Create and store the order item
                $orderItem = new OrderItem([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $cartItem->quantity,
                    'unit_price' => $getPrice->price,
                    'subtotal' => $subtotal,
                ]);

                $orderItem->save();

                
    
                // Update product quantity
                // $product->decrement('quantity', $cartItem->quantity);
    
                // Calculate total amount
                $totalAmount += $subtotal;
    
                // Remove the cart item
                $cartItem->delete();
            }
            
            if($totalAmount < 799) {
                $totalAmount = $totalAmount + 80;
            }

            // Update the calculated total amount in the order
            $order->update(['total_amount' => $totalAmount]);
           
            // Commit the transaction
            DB::commit();
            
            if($request->input('payment_method') == "COD") {
                 return redirect()->route('orders.index')->with('success', 'Order placed successfully.');
            }else{
                return redirect()->route('payment.process', $order->id);
            }
           

            

            // return redirect('/')->with('success', 'Order placed successfully.');

        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollback();
    
            return redirect()->back()->with('error', 'Failed to place the order. Please try again.');
        }
    }
    
}
