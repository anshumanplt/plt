<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Category;
use App\Models\Cart;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/';


    public function showLoginForm()
    {
        $categories = Category::where('parent_id', 	NULL)->orderBy('category_id')->take(5)->get();

        $allMenu = [];
        foreach($categories as $value) {
            $subMenu = Category::where('parent_id', $value->category_id)->get();
            $value['submenu'] = $subMenu;
            $allMenu[] = $value;
        }



        $categories = $allMenu;
        return view('auth.login',compact('categories'));
    }


    protected function authenticated(Request $request, $user)
    {
    
        // Get guest cart items from session
        $guestCart = session('guest_cart', []);

        // echo "<pre>"; print_r($guestCart); die("check");

        // Loop through guest cart items and sync with user's cart
        foreach ($guestCart as $productId => $item) {
            $user->carts()->updateOrCreate(
                ['product_id' => $productId],
                ['sku' => $item['sku']],
                ['quantity' => $item['quantity']]
            );

        }

        // Clear guest cart from session
        session()->forget('guest_cart');

        return redirect()->intended($this->redirectPath());
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
