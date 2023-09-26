<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Banner;
use Storage;

class SettingController extends Controller
{
    public function homepage() {
        
        $getHomeSetting = Setting::where('setting_type', 'home')->first();

        $categories = Category::where('parent_id', NULL)->get();

        $banners = Banner::where('status' , 1)->get();

        return view('admin.settings.homepage', compact('getHomeSetting', 'categories', 'banners'));
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
}
