<?php 
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    /**
     * Display a listing of the product images.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        

        // $images = $product->productImages;
        $images = ProductImage::where([ "product_id" => $product->id, "status" => 1 ])->get();

        return view('product_images.index', compact('product', 'images'));
    }

    /**
     * Show the form for creating a new product image.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        return view('product_images.create', compact('product'));
    }

    /**
     * Store a newly created product image in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request, Product $product)
    // {

    //     $validator = $request->validate([
    //         'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'featured' => 'boolean',
    //         'status' => 'boolean',
    //     ]);



    //     if ($request->hasFile('image')) {
    //         $imagePath = $request->file('image')->store('product_images', 'public');
            
    //         $productImage = new ProductImage();
    //         $productImage->image_path = $imagePath;
    //         $productImage->featured = $request->input('featured', false);
    //         $productImage->status = $request->input('status', true);
    //         $product->productImages()->save($productImage);
    //     }


    //     return redirect()->route('products.images.index', $product->id)->with('success', 'Product image created successfully.');
    // }

    public function store(Request $request, Product $product)
    {
        $validator = $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'featured' => 'boolean',
            'status' => 'boolean',
        ]);


        if ($request->hasFile('images')) {
            $images = $request->file('images');

            foreach ($images as $key => $image) {
                $imagePath = $image->store('product_images', 'public');

                $productImage = new ProductImage();
                $productImage->image_path = $imagePath;
                $productImage->featured = $request->input('featured', false);
                $productImage->status = $request->input('status', true);
                $product->productImages()->save($productImage);
            }
        }

        return redirect()->route('products.images.index', $product->id)->with('success', 'Product images created successfully.');
    }


    /**
     * Show the form for editing the specified product image.
     *
     * @param  \App\Models\Product  $product
     * @param  \App\Models\ProductImage  $productImage
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product, ProductImage $productImage)
    {
        return view('product_images.edit', compact('product', 'productImage'));
    }

    /**
     * Update the specified product image in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @param  \App\Models\ProductImage  $productImage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product, ProductImage $productImage)
    {
        $request->validate([
            // 'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'featured' => 'boolean',
            // 'status' => 'boolean',
        ]);

        // if ($request->hasFile('image')) {
        //     $imagePath = $request->file('image')->store('product_images', 'public');

        //     // Delete the previous image file if it exists
        //     Storage::delete($productImage->image_path);
            
        //     $productImage->image_path = $imagePath;
        // }

        $productImage->featured = $request->input('featured', false);
        // $productImage->status = $request->input('status', true);
        $productImage->save();

        return redirect()->route('products.images.index', $product->id)->with('success', 'Product image updated successfully.');
    }

    public function updateFeatureImage(Request $request, $product, $productImage) {
        $imageFeatureUpdate = ProductImage::where(['product_id' => $product])->update([ 'featured' => 0 ]);
        $imageFeatureUpdateStatus = ProductImage::where(['id' => $productImage, 'product_id' => $product])->update([ 'featured' => 1 ]);
        return redirect()->route('products.images.index', $product)->with('success', 'Product image updated successfully.');
    }

    /**
     * Remove the specified product image from storage.
     *
     * @param  \App\Models\Product  $product
     * @param  \App\Models\ProductImage  $productImage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, ProductImage $productImage)
    {
        // Delete the image file from storage
        Storage::delete($productImage->image_path);

        $productImage->delete();

        return redirect()->route('products.images.index', $product->id)->with('success', 'Product image deleted successfully.');
    }
}
