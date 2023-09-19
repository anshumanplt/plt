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
                       ->get();

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
            $insertData = [
                'user_id' => $user->id,
                'address_id' => $defaultAddress->id,
                'payment_method' => $request->input('payment_method'),
                'order_state' => 'pending', // Set the initial state
                'total_amount' => 0, // Placeholder, will be updated later
            ];

          
            // Create the order
            $order = new Order($insertData);
    
            $order->save();
            
      
            
            $totalAmount = 0;


            foreach ($cartItems as $cartItem) {
                $product = Product::findOrFail($cartItem->product_id);
    
                // Calculate subtotal
                $subtotal = $product->sale_price * $cartItem->quantity;
               
             
                // Create and store the order item
                $orderItem = new OrderItem([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $cartItem->quantity,
                    'unit_price' => $product->sale_price,
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
