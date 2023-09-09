<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Attribute;

class FrontController extends Controller
{
    public function index()
    {
        $data = [];

        // 1. Retrieve the top 5 categories
        $categories = Category::where('parent_id', 	NULL)->orderBy('category_id')->take(5)->get();

        $allMenu = [];
        foreach($categories as $value) {
            $subMenu = Category::where('parent_id', $value->category_id)->get();
            $value['submenu'] = $subMenu;
            $allMenu[] = $value;
        }



        $data['categories'] = $allMenu;

        // 2. Retrieve 5 categories with images
        $categoriesWithImages = Category::take(5)->get();
        $data['categoriesWithImages'] = $categoriesWithImages;

        // 3. Retrieve top five products with 8 products
        $topFiveProducts = Product::has('images')->with('images')->with('productImages')->orderBy('id')->take(5)->get();
        $data['topFiveProducts'] = $topFiveProducts;

        // 4. Retrieve hot trends, bestseller, and featured products with 5 products each
        $hotTrendsProducts = Product::where('hot_trend', 1)->has('images')->with('images')->with('productImages')->orderBy('id')->take(5)->get();
        $data['hotTrendsProducts'] = $hotTrendsProducts;
        // echo "<pre>"; print_r($hotTrendsProducts); die("Check");

        $bestsellerProducts = Product::where('best_seller', 1)->has('images')->with('images')->with('productImages')->orderBy('id')->take(5)->get();
        $data['bestsellerProducts'] = $bestsellerProducts;

        $featureProducts = Product::where('feature', 1)->has('images')->with('images')->with('productImages')->orderBy('id')->take(5)->get();
        $data['featureProducts'] = $featureProducts;

        $products = Product::has('images')->with('images')->with('productImages')->orderBy('id', 'DESC')->paginate(16);
        $data['products'] = $products;

        // echo "<pre>"; print_r($data); die("check");

        return view('frontendhome', $data);
    }

    public function category($category)
    {
        // Retrieve the category based on slug or ID
        $category = Category::where('category_id', $category)->firstOrFail();

        // Retrieve the products for the category
        // $products = $category->products;

        $products = Product::where('category_id', $category->category_id)->orWhere('subcategory_id', $category->category_id)->with('productImages')->orderBy('category_id', 'DESC')->paginate(20);
        

        $categories = Category::where('parent_id', 	NULL)->orderBy('category_id')->take(5)->get();

        $allMenu = [];
        foreach($categories as $value) {
            $subMenu = Category::where('parent_id', $value->category_id)->get();
            $value['submenu'] = $subMenu;
            $allMenu[] = $value;
        }



        $categories = $allMenu;

        return view('category', compact('category', 'products', 'categories'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::where('name', 'like', "%$query%")->get();

        return view('partials.search_results', compact('products'));
    }

    public function product($product, Request $request) {
        $categories = Category::where('parent_id', 	NULL)->orderBy('category_id')->take(5)->get();

        $allMenu = [];
        foreach($categories as $value) {
            $subMenu = Category::where('parent_id', $value->category_id)->get();
            $value['submenu'] = $subMenu;
            $allMenu[] = $value;
        }



        $categories = $allMenu;

        $product = Product::where('id', $product)->with('productImages')->first();

        $relatedProduct = Product::where('category_id', $product->category_id)->with('productImages')->orderBy('id', 'DESC')->limit(4)->get();

        $allAttribute = Attribute::with('attributeValues')->get();
        
        return view('product_detail', compact('product', 'categories', 'relatedProduct', 'allAttribute'));
    }

}
