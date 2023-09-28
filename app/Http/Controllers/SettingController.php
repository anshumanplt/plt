<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Banner;
use App\Models\Promotionalbanner;
use App\Models\Promotionalslider;
use App\Models\Discountbanner;
use Storage;

class SettingController extends Controller
{
    public function homepage() {
        
        $getHomeSetting = Setting::where('setting_type', 'home')->first();

        $categories = Category::where('parent_id', NULL)->get();

        $banners = Banner::where('status' , 1)->get();

        $promotionalBanner = Promotionalbanner::where('status', 1)->first();

        $promotionalSlider = Promotionalslider::where('status', 1)->orderBy('id', 'DESC')->get();

        $discountbanner = Discountbanner::where('status', 1)->first();

        return view('admin.settings.homepage', compact('getHomeSetting', 'categories', 'banners', 'promotionalBanner', 'promotionalSlider', 'discountbanner'));
    }

    public function homepageupdate(Request $request) {

        $homePageSetting = Setting::updateOrCreate(
            ['setting_type' => 'home'],
            ['category_ids' => implode(',',$request->input('categories'))]
        );

        return redirect()->back()->with('success', "Home page setting updated.");
    }

    public function addhomepagebanner(Request $request)
    {
        // Validate the form data
        $request->validate([
            'banner_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'url' => 'nullable|url',
            'position' => 'required|integer',
            'status' => 'boolean',
        ]);

        // Upload and save the banner image
        $imagePath = $request->file('banner_image')->store('banners', 'public');

        // Create a new banner record
        $banner = new Banner([
            'banner_image' => $imagePath,
            'url' => $request->input('url'),
            'position' => $request->input('position'),
            'status' => $request->input('status', false),
        ]);

        // Save the banner
        $banner->save();

        return redirect()->back()->with('success', 'Banner added successfully.');
    }

    public function bannerdestroy(Banner $banner, $id)
    {
        // echo "Banner Id : ".$id."<br>"; die("check");
        // Delete the banner from storage
        Storage::disk('public')->delete($banner->banner_image);

        // Delete the banner from the database
        // $banner->delete();
        Banner::where('id', $id)->update(['status' => 0]);

        return redirect()->back()->with('success', 'Banner deleted successfully.');
    }


    public function promotionalbanner(Request $request) {

        $request->validate([
            'background_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
          
        ]);

        $check = Promotionalbanner::where('status',1)->update(['status' => 0]);


        $imagePath = $request->file('background_image')->store('promotion_banners', 'public');

        
        // Create a new banner record
        $banner = new Promotionalbanner([
            'background_image' => $imagePath,
         
        ]);

        // Save the banner
        $banner->save();
        return redirect()->back()->with('promotionalsuccess', 'Promotional banner updated.');
    }

    public function promotionalslider(Request $request) {

        $request->validate([
            'title' => 'required',
            'url' => 'url',
            'description' => 'required'
          
        ]);

        $addPromotionalSlider = Promotionalslider::create(['title' => $request->input('title'), 'url' => $request->input('url'), 'description' => $request->input('description')]);
        return redirect()->back()->with('promotionalslidersuccess', 'Promotional Slider added.');
    }

    public function promotionalsliderdelete($id) {
        Promotionalslider::where('id', $id)->update(['status' => 0]);
        return redirect()->back()->with('promotionalslidersuccess', 'Promotional Slider deleted.');

    }

    public function discountbanner(Request $request) {
        // echo "<pre>"; print_r($request->all()); die("check");
        $request->validate([
            'discount_background_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
          
        ]);

        $lastBanner = Discountbanner::where('status', 1)->first();

       

        $check = Discountbanner::where('status',1)->update(['status' => 0]);

        if($request->file('discount_background_image')) {
            $imagePath = $request->file('discount_background_image')->store('discount_background_image', 'public');

        
            // Create a new banner record
            $banner = new Discountbanner([
                'discount_background_image' => $imagePath,
                'url' => $request->url
            ]);
    
            // Save the banner
            $banner->save();
        }else{
            // $imagePath = $request->file('discount_background_image')->store('discount_background_image', 'public');

        
            // Create a new banner record
            $banner = new Discountbanner([
                'discount_background_image' => $lastBanner->discount_background_image,
                'url' => $request->url
            ]);
    
            // Save the banner
            $banner->save();
        }
    
        return redirect()->back()->with('discountsuccess', 'Discount banner updated.');
    }
}
