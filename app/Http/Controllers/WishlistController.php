<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $categories = Category::where('parent_id', 	NULL)->orderBy('category_id')->take(5)->get();

        $allMenu = [];
        foreach($categories as $value) {
            $subMenu = Category::where('parent_id', $value->category_id)->get();
            $value['submenu'] = $subMenu;
            $allMenu[] = $value;
        }



        $categories = $allMenu;
        // $wishlistedProducts = $user->wishlistedProducts;
        $wishlistedProducts = Wishlist::with('product', 'product.productImages')->orderBy('id', 'DESC')->get();

        // echo "<pre>"; print_r($wishlistedProducts); echo "</pre>"; die("check");

        return view('wishlist.index', compact('wishlistedProducts', 'categories'));
    }


    public function mywishlist() {
        $user = Auth::user();
        $categories = Category::where('parent_id', 	NULL)->orderBy('category_id')->take(5)->get();

        $allMenu = [];
        foreach($categories as $value) {
            $subMenu = Category::where('parent_id', $value->category_id)->get();
            $value['submenu'] = $subMenu;
            $allMenu[] = $value;
        }



        $categories = $allMenu;
        // $wishlistedProducts = $user->wishlistedProducts;
        $wishlistedProducts = Wishlist::with('product', 'product.productImages')->orderBy('id', 'DESC')->get();


        return view('my_account.wishlist', compact('wishlistedProducts', 'categories'));
    }

    public function addToWishlist(Request $request, $productId)
    {
        // Assuming the user is authenticated
        $user = auth()->user();

        // Check if the product is already in the user's wishlist
        if (!$user->wishlist->contains('product_id', $productId)) {
            $wishlistItem = new Wishlist([
                'user_id' => $user->id,
                'product_id' => $productId,
            ]);
            $wishlistItem->save();
            
            return redirect()->back()->with('success', 'Product added to wishlist.');
        }

        return redirect()->back()->with('error', 'Product is already in your wishlist.');
    }

    public function removeFromWishlist(Request $request, $wishlistId)
    {
        // Assuming the user is authenticated
        $user = auth()->user();

        $wishlistItem = Wishlist::find($wishlistId);

        // echo "<pre>"; print_r($wishlistItem); die("check");
      

        if ($wishlistItem && $wishlistItem->user_id === $user->id) {
            $wishlistItem->delete();
            return redirect()->back()->with('success', 'Product removed from wishlist.');
        }
      
        return redirect()->back()->with('error', 'Could not remove product from wishlist.');
    }
}
