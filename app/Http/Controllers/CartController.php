<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Coupon;

class CartController extends Controller
{

    public function add(Request $request, $productId = '', $sku = '')
    {
        if($productId) {
            $productId = $productId;
        }else{
            $productId = $request->input('product_id');
        }

        $product = Product::findOrFail($productId);

        $quantity = $request->input('quantity', 1);

        // If user is logged in, add to user's cart
        if (Auth::check()) {
            $user = Auth::user();
            // echo "SKU".$sku; die("check");

            // $checkCart = Cart::where([ 'product_id' => $productId ])->first();

            // $cartAdd = Cart::create([
            //     'product_id' => $productId,
            //     'quantity' => $quantity,
            //     'sku' => $sku
            // ]);

            $cart = Cart::updateOrCreate([
                'user_id' => $user->id
            ],[
                'product_id' => $productId,
                'quantity' => $quantity,
                'sku' => $sku
            ]);

            // $user->carts()->updateOrCreate(
            //     ['product_id' => $productId],
            //     ['quantity' => $quantity],
            //     ['sku' => $sku]
            // );
        } else {
            $guestCart = session('guest_cart', []);
            if (isset($guestCart[$sku])) {
                $guestCart[$sku]['quantity'] += $request->input('quantity', 1);
            }else{
                $guestCart[$sku] = [
                    'productId' => $productId,
                    'quantity' => $quantity,
                    'sku' => $sku
                ];
            }
            session(['guest_cart' => $guestCart]);

            // If guest, add to session cart
            // Commenting old code 
            /*
            $guestCart = session('guest_cart', []);
            if (isset($guestCart[$productId])) {
                $guestCart[$productId]['quantity'] += $request->input('quantity', 1);
            } else {
                $guestCart[$productId] = [
                    'productId' => $productId,
                    'quantity' => $quantity,
                    'sku' => $sku
                ];
            }
            session(['guest_cart' => $guestCart]);
            */



        }

        return redirect()->back()->with('success', 'Product added to cart.');
    }

    public function update(Request $request, $productId, $sku)
    {
        $product = Product::findOrFail($productId);

        // If user is logged in, update user's cart item
        $quantity = $request->input('quantity', 1);
        if (Auth::check()) {
            $user = Auth::user();
            $user->carts()->updateOrCreate(
                ['product_id' => $productId],
                ['quantity' => $quantity],
                ['sku' => $sku]
            );
        } else {
            // If guest, update session cart item
            $guestCart = session('guest_cart', []);
            if (isset($guestCart[$sku])) {
                $guestCart[$sku]['quantity'] = $quantity;
                $guestCart[$sku]['sku'] = $sku;
                // echo "<pre>"; print_r($guestCart); die("check");
                session(['guest_cart' => $guestCart]);
            }
            // Commenting old code 
            /*
            $guestCart = session('guest_cart', []);
            if (isset($guestCart[$productId])) {
                $guestCart[$productId]['quantity'] = $quantity;
                $guestCart[$productId]['sku'] = $sku;
                session(['guest_cart' => $guestCart]);
            }
            */
        }



        return redirect()->route('cart.index')->with('success', 'Cart updated.');
    }

    public function remove($sku)
    {
        // If user is logged in, remove from user's cart
        if (Auth::check()) {
            $user = Auth::user();
            $user->carts()->where('sku', $sku)->delete();
        
            
            // Old commented code
            // $user->carts()->where('product_id', $productId)->delete();
        } else {
     
            // If guest, remove from session cart
            $guestCart = session('guest_cart', []);
            if (isset($guestCart[$sku])) {
                unset($guestCart[$sku]);
                session(['guest_cart' => $guestCart]);
            }
        }

        return redirect()->route('cart.index')->with('success', 'Product removed from cart.');
    }

    public function index()
    {
        session_start();
        $discount_code = '';
        $discount = '';

        if(isset($_SESSION['discount_code'])) {
            $discount_code = $_SESSION['discount_code'];
            $discount = Coupon::where('code', $discount_code)->first();
        }

        $cartItems = [];


        if (Auth::check()) {
            $user = Auth::user();
            $cartData = Cart::where('user_id', $user->id)->get();

            // echo "<pre>"; print_r($cartData); echo "</pre>";

            foreach ($cartData as $key => $value) {
                $product = Product::where('id', $value->product_id)->with('images')->first();
                $product->quantity = $value->quantity;
                $product->sku = $value->sku;
                $cartItems[] = $product;
            }
            // ->with('product.images')
        } else {
            // Fetch guest cart items using session data
            $guestCart = session('guest_cart', []);

            // unset($guestCart[4]);

           
            foreach($guestCart as $value) {
                
                $product = Product::where('id', $value['productId'])->with('images')->first();
                
                $product->quantity = $value['quantity'];
                $product->sku = $value['sku'];
                $cartItems[] = $product;
                // echo "<pre>"; print_r($cartItems); die("check");
            }

            // echo "<pre>"; print_r($guestCart); die("check");

            // Fetch the product details for the cart items
            // $productIds = array_keys($guestCart);
            // $products = Product::whereIn('id', $productIds)->with('images')->get();

            // // Associate quantities with product images
            // foreach ($products as $product) {
            //     $product->quantity = $guestCart[$product->id]['quantity'];
            //     $cartItems[] = $product;
            // }
        }

        // echo "<pre>"; print_r($cartItems); die("check");

        // 1. Retrieve the top 5 categories
        $categories = Category::where('parent_id', 	NULL)->orderBy('category_id')->take(5)->get();

        $allMenu = [];
        foreach($categories as $value) {
            $subMenu = Category::where('parent_id', $value->category_id)->get();
            $value['submenu'] = $subMenu;
            $allMenu[] = $value;
        }



        $categories= $allMenu;



        return view('cart.index', compact('cartItems', 'categories', 'discount', 'discount_code'));
    }

   

}
