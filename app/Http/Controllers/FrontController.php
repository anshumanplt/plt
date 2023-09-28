<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeImage;
use App\Models\Setting;
use App\Models\Banner;
use App\Models\Promotionalbanner;
use App\Models\Promotionalslider;
use App\Models\Discountbanner;

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
        // echo "<pre>"; print_r($categoriesWithImages[0]->category_id); die("check");

        // 3. Retrieve top five products with 8 products
        $topFiveProducts = Product::has('images')->with('images')->with('productImages')->orderBy('id')->take(5)->get();
        $data['topFiveProducts'] = $topFiveProducts;

        // 4. Retrieve hot trends, bestseller, and featured products with 5 products each
        $hotTrendsProducts = Product::where('hot_trend', 1)->has('images')->with('images')->with('productImages')->orderBy('id')->take(3)->get();
        $data['hotTrendsProducts'] = $hotTrendsProducts;
        // echo "<pre>"; print_r($hotTrendsProducts); die("Check");

        $bestsellerProducts = Product::where('best_seller', 1)->has('images')->with('images')->with('productImages')->orderBy('id')->take(3)->get();
        $data['bestsellerProducts'] = $bestsellerProducts;

        $featureProducts = Product::where('feature', 1)->has('images')->with('images')->with('productImages')->orderBy('id')->take(3)->get();
        $data['featureProducts'] = $featureProducts;

        $products = Product::has('images')->with('images')->with('productImages')->orderBy('id', 'DESC')->paginate(8);
        $data['products'] = $products;
        $data['products'] = [];

        $homePageSetting = Setting::where('setting_type', 'home')->first();
        $categoryProduct = [];
        if($homePageSetting) {
            $categoryIds = explode(',',$homePageSetting->category_ids);
            $categoryProduct = Category::whereIn('category_id', $categoryIds)->with('products', 'products.productImages')->get();

            // echo "<pre>"; print_r($categoryProduct); die("check");
        }

        $data['categoryProduct'] = $categoryProduct;

        // echo "<pre>"; print_r($data); die("check");

        $data['banners'] = Banner::where('status', 1)->orderBy('position', 'asc')->get();


        // $data['instagramFeed'] = $response;
       
        $data['promotionalbanner'] = Promotionalbanner::where('status', 1)->first();

        $data['promotionalslider'] = Promotionalslider::where('status', 1)->get();

        $data['discountbanner'] = Discountbanner::where('status', 1)->first();

        return view('frontendhome', $data);
    }

    public function category($category)
    {
        // Retrieve the category based on slug or ID
        $category = Category::where('category_id', $category)->firstOrFail();

        // Retrieve the products for the category
        // $products = $category->products;

        $products = Product::where('category_id', $category->category_id)->orWhere('subcategory_id', $category->category_id)->with('productImages')->orderBy('id', 'DESC')->paginate(20);
        

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

        $allSelectedAttribute = ProductAttribute::where('product_id', $product)->get();

        $categories = $allMenu;
        $productId = $product;

        $product = Product::where('id', $product)->with('productImages')->first();

        $relatedProduct = Product::where('category_id', $product->category_id)->with('productImages')->orderBy('id', 'DESC')->limit(4)->get();

        $allAttribute = Attribute::with('attributeValues')->get();
        


        // echo "<pre>"; print_r($allSelectedAttribute); echo "</pre>"; die("check");

        // New 15-09-2023

        // $productAssignedAttribute = [];
        // $attributeArr = [];
        // foreach($allAttribute as $item) {
        //     $data['name'] = $item->name;
        //     $data['id'] = $item->id;
        //     $data['attributeVal'] = [];
        //     $attributeArr[] = $data;
        // }

        $allSelectedAttributevalue = [];

        foreach($allSelectedAttribute as $item) {
            $attributeValue = explode(',', $item->attribute_value_id);
            foreach($attributeValue as $item) {
                if(!in_array($item,$allSelectedAttributevalue)) {
                    $allSelectedAttributevalue[] = $item;
                }

            }

        }


        // echo "<pre>"; print_r($allSelectedAttributevalue);  die("check");

        // End New 15-09-2023


        $allArray = [];
        foreach($allSelectedAttribute as $value) {
            $atval = [];
            $attributeValue = explode(',', $value->attribute_value_id);
            foreach($attributeValue as $item) {
                $att = AttributeValue::where('id', $item)->first();
                $data = [
                    'attribute_id'  => $att->attribute_id,
                    'id'  => $att->id,
                    'value' => $att->value
                ];
                $atval[] = $data;
            }

            foreach($atval as $d) {
                $allArray[] = $d;
            }
            
        }

        $Size = $request->get('Size');
        $Color= $request->get('Color');
        $Fabric= $request->get('Fabric');
        $variantData = [];
        if($Size && $Color && $Fabric) {
            // echo "<pre>"; print_r(['attribute_value_id' => $Size.','.$Color.','.$Fabric, 'product_id' => $product->id]); echo "</pre>"; die("check");
            $productSku = ProductAttribute::where(['attribute_value_id' => $Size.','.$Color.','.$Fabric, 'product_id' => $product->id])->first();
            if($productSku) {
                $productSKUImages = ProductAttributeImage::where(['sku' => $productSku->sku])->get();
                $variantData = [
                    'productSku' => $productSku,
                    'productSKUImages' => $productSKUImages
                ];
            }

        }else{
            $checkAtt = ProductAttribute::where('product_id', $productId)->first();
            if($checkAtt) {
                $attArr = explode(',', $checkAtt->attribute_value_id);
                return redirect('product-detail/'.$productId.'?Size='.$attArr[0].'&Color='.$attArr[1].'&Fabric='.$attArr[2]);
                
            }
        }

       
        

        return view('product_detail', compact('product', 'categories', 'relatedProduct', 'allAttribute', 'allSelectedAttribute', 'allArray', 'variantData', 'allSelectedAttributevalue'));
    }

    public function aboutus() {
       
        $categories = Category::where('parent_id', 	NULL)->orderBy('category_id')->take(5)->get();

        $allMenu = [];
        foreach($categories as $value) {
            $subMenu = Category::where('parent_id', $value->category_id)->get();
            $value['submenu'] = $subMenu;
            $allMenu[] = $value;
        }


        $categories = $allMenu;
        return view('static.aboutus', compact('categories'));
    }

    public function contactus() {
        $categories = Category::where('parent_id', 	NULL)->orderBy('category_id')->take(5)->get();

        $allMenu = [];
        foreach($categories as $value) {
            $subMenu = Category::where('parent_id', $value->category_id)->get();
            $value['submenu'] = $subMenu;
            $allMenu[] = $value;
        }


        $categories = $allMenu;
        return view('static.contactus', compact('categories'));
    }

    public function privacypolicy() {
        $categories = Category::where('parent_id', 	NULL)->orderBy('category_id')->take(5)->get();

        $allMenu = [];
        foreach($categories as $value) {
            $subMenu = Category::where('parent_id', $value->category_id)->get();
            $value['submenu'] = $subMenu;
            $allMenu[] = $value;
        }


        $categories = $allMenu;
        return view('static.privacypolicy', compact('categories'));
    }
    public function termscondition() {
        $categories = Category::where('parent_id', 	NULL)->orderBy('category_id')->take(5)->get();

        $allMenu = [];
        foreach($categories as $value) {
            $subMenu = Category::where('parent_id', $value->category_id)->get();
            $value['submenu'] = $subMenu;
            $allMenu[] = $value;
        }


        $categories = $allMenu;
        return view('static.termscondition', compact('categories'));
    }
    public function shippingpolicy() {
        $categories = Category::where('parent_id', 	NULL)->orderBy('category_id')->take(5)->get();

        $allMenu = [];
        foreach($categories as $value) {
            $subMenu = Category::where('parent_id', $value->category_id)->get();
            $value['submenu'] = $subMenu;
            $allMenu[] = $value;
        }


        $categories = $allMenu;
        return view('static.shippingpolicy', compact('categories'));
    }
    public function paymentpolicy() {
        $categories = Category::where('parent_id', 	NULL)->orderBy('category_id')->take(5)->get();

        $allMenu = [];
        foreach($categories as $value) {
            $subMenu = Category::where('parent_id', $value->category_id)->get();
            $value['submenu'] = $subMenu;
            $allMenu[] = $value;
        }


        $categories = $allMenu;
        return view('static.contactus', compact('categories'));
    }
    public function disputeresolution() {
        $categories = Category::where('parent_id', 	NULL)->orderBy('category_id')->take(5)->get();

        $allMenu = [];
        foreach($categories as $value) {
            $subMenu = Category::where('parent_id', $value->category_id)->get();
            $value['submenu'] = $subMenu;
            $allMenu[] = $value;
        }


        $categories = $allMenu;
        return view('static.disputeresolution', compact('categories'));
    }
    public function genuinequalityproduct() {
        $categories = Category::where('parent_id', 	NULL)->orderBy('category_id')->take(5)->get();

        $allMenu = [];
        foreach($categories as $value) {
            $subMenu = Category::where('parent_id', $value->category_id)->get();
            $value['submenu'] = $subMenu;
            $allMenu[] = $value;
        }


        $categories = $allMenu;
        return view('static.contactus', compact('categories'));
    }

    public function notifyme(Request $request) {
        return redirect()->back()->with('success', 'We will notify you.');
    }

    public function newsletter(Request $request) {
        return redirect()->back()->with('success', 'Newsletter is subscribed successfully.');
    }
}
