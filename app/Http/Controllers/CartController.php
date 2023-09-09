<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function add(Request $request, $productId = '')
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
            $user->carts()->updateOrCreate(
                ['product_id' => $productId],
                ['quantity' => $quantity]
            );
        } else {
            // If guest, add to session cart
            $guestCart = session('guest_cart', []);
            if (isset($guestCart[$productId])) {
                $guestCart[$productId]['quantity'] += $request->input('quantity', 1);
            } else {
                $guestCart[$productId] = [
                    // 'quantity' => $request->input('quantity', 1),
                    'quantity' => $quantity,

                ];
            }
            session(['guest_cart' => $guestCart]);
        }

        return redirect()->back()->with('success', 'Product added to cart.');
    }

    public function update(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        // If user is logged in, update user's cart item
        $quantity = $request->input('quantity', 1);
        if (Auth::check()) {
            $user = Auth::user();
            $user->carts()->updateOrCreate(
                ['product_id' => $productId],
                ['quantity' => $quantity]
            );
        } else {
            // If guest, update session cart item
            $guestCart = session('guest_cart', []);
            if (isset($guestCart[$productId])) {
                $guestCart[$productId]['quantity'] = $quantity;
                session(['guest_cart' => $guestCart]);
            }
        }



        return redirect()->route('cart.index')->with('success', 'Cart updated.');
    }

    public function remove($productId)
    {
        // If user is logged in, remove from user's cart
        if (Auth::check()) {
            $user = Auth::user();
            $user->carts()->where('product_id', $productId)->delete();
        } else {
            // If guest, remove from session cart
            $guestCart = session('guest_cart', []);
            if (isset($guestCart[$productId])) {
                unset($guestCart[$productId]);
                session(['guest_cart' => $guestCart]);
            }
        }

        return redirect()->route('cart.index')->with('success', 'Product removed from cart.');
    }

    public function index()
    {
        $cartItems = [];

        if (Auth::check()) {
            $user = Auth::user();
            $cartData = Cart::where('user_id', $user->id)->get();
            foreach ($cartData as $key => $value) {
                $product = Product::where('id', $value->product_id)->with('images')->first();
                $product->quantity = $value->quantity;
                $cartItems[] = $product;
            }
            // ->with('product.images')
        } else {
            // Fetch guest cart items using session data
            $guestCart = session('guest_cart', []);

            // Fetch the product details for the cart items
            $productIds = array_keys($guestCart);
            $products = Product::whereIn('id', $productIds)->with('images')->get();

            // Associate quantities with product images
            foreach ($products as $product) {
                $product->quantity = $guestCart[$product->id]['quantity'];
                $cartItems[] = $product;
            }
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

        return view('cart.index', compact('cartItems', 'categories'));
    }

    // public function add(Request $request, $productId)
    // {
    //     $product = Product::findOrFail($productId);

    //     // Check if the item already exists in the cart
    //     $existingCartItem = Cart::where('user_id', auth()->id())
    //         ->where('product_id', $productId)
    //         ->first();

    //     if ($existingCartItem) {
    //         $existingCartItem->quantity += 1;
    //         $existingCartItem->save();
    //     } else {
    //         Cart::create([
    //             'user_id' => auth()->id(),
    //             'product_id' => $productId,
    //             'quantity' => 1,
    //         ]);
    //     }

        
    //     // Recalculate and update the cart count in the session
    //     $cartCount = Cart::where('user_id', auth()->id())->sum('quantity');
    //     session(['cart.count' => $cartCount]);

    //     return redirect()->back()->with('success', 'Product added to cart.');
    // }

    // // public function update(Request $request, $productId)
    // // {
    // //     $product = Product::findOrFail($productId);

    // //     $cartItem = Cart::where('user_id', auth()->id())
    // //         ->where('product_id', $productId)
    // //         ->firstOrFail();

    // //     $cartItem->quantity = $request->input('quantity');
    // //     $cartItem->save();

    // //     return redirect()->route('cart.index')->with('success', 'Cart updated.');
    // // }

    // public function update(Request $request, $productId)
    // {
    //     $product = Product::findOrFail($productId);

    //     $cartItem = Cart::where('user_id', auth()->id())
    //         ->where('product_id', $productId)
    //         ->firstOrFail();

    //     $newQuantity = $request->input('quantity');

    //     if ($newQuantity <= 0) {
    //         // Remove cart item if the new quantity is less than or equal to 0
    //         $cartItem->delete();
    //         return redirect()->route('cart.index')->with('success', 'Product removed from cart.');
    //     }

    //     $cartItem->quantity = $newQuantity;
    //     $cartItem->save();

    //     // Recalculate and update the cart count in the session
    //     $cartCount = Cart::where('user_id', auth()->id())->sum('quantity');
    //     session(['cart.count' => $cartCount]);

    //     return redirect()->route('cart.index')->with('success', 'Cart updated.');
    // }

    // public function remove($productId)
    // {
    //     Cart::where('user_id', auth()->id())
    //         ->where('product_id', $productId)
    //         ->delete();

        
    //     // Recalculate and update the cart count in the session
    //     $cartCount = Cart::where('user_id', auth()->id())->sum('quantity');
    //     session(['cart.count' => $cartCount]);

    //     return redirect()->route('cart.index')->with('success', 'Product removed from cart.');
    // }

    // public function index()
    // {
    //     // $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();
    //     $cartItems = Cart::where('user_id', auth()->id())->with('product.images')->get();

        
    //     // 1. Retrieve the top 5 categories
    //     $categories = Category::where('parent_id', 	NULL)->orderBy('category_id')->take(5)->get();

    //     $allMenu = [];
    //     foreach($categories as $value) {
    //         $subMenu = Category::where('parent_id', $value->category_id)->get();
    //         $value['submenu'] = $subMenu;
    //         $allMenu[] = $value;
    //     }



    //     $categories= $allMenu;

    //     return view('cart.index', compact('cartItems','categories'));
    // }

}
