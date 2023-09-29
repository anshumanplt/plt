<?php

namespace App\Http\Controllers;

use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $products = Product::with('brand', 'category', 'subcategory')->paginate(20);
    
        return view('products.index', compact('products'));
    }

    public function importProduct() {

        $brands = Brand::all();
        $categories = Category::all();
        $csvData = [];
        $report = [
            'totalProductInserted' => 0,
            'duplicateProduct' => []
        ];

        return view('products.import', compact('brands', 'categories', 'csvData', 'report'));
    }

    public function getcsvfile(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt',
        ]);

        // Get the uploaded file
        $file = $request->file('csv_file');

        // Process the CSV data
        $csvData = file_get_contents($file);
        $rows = array_map('str_getcsv', explode("\n", $csvData));

        // Perform your data import logic here
        // You can loop through $rows and insert data into your database

        // Example: Insert data into a table
        
        // Remove empty rows
        $rows = array_filter($rows, function ($row) {
            return !empty(array_filter($row));
        });



        $finalData = [];
        $totalProductInserted = 0;
        $duplicateProduct = [];
        foreach ($rows as $key => $row) {
            if($key != 0) {
                // echo "<pre>"; print_r($row); die("check");
                $checkProduct = Product::where('sku', $row[0])->first();
                
                $data = [
                    'sku' => $row[0],
                    'meta_title' => $row[15],
                    'meta_description' => $row[16],
                    'subcategory_id' => $request->input('subcategory_id'),
                    'category_id' => $request->input('category_id'),
                    'brand_id' => $request->input('brand_id'),
                    'name' => $row[15],
                    'description' => $row[16],
                    'price' => $row[2],
                    'sale_price' => $row[3],
                    'status' => 0
                    
                ];
                if($checkProduct) { 
                    $duplicateProduct[] = $data;
                    continue;
                }

                $addProduct = Product::create($data);

                if($addProduct) {
                    $productFeaturedata = [
                        'product_id' => $addProduct->id,
                        'image_path' => 'product_images/'.$row[9],
                        'featured' => 1

                    ];

                    ProductImage::create($productFeaturedata);

                    if($row[10]) {
                        $productImageOne = [
                            'product_id' => $addProduct->id,
                            'image_path' => 'product_images/'.$row[10],
                            'featured' => 0
    
                        ];
    
                        ProductImage::create($productImageOne);
                    }

                    if($row[11]) {
                        $productImageTwo = [
                            'product_id' => $addProduct->id,
                            'image_path' => 'product_images/'.$row[11],
                            'featured' => 0
    
                        ];
    
                        ProductImage::create($productImageTwo);
                    }

                    if($row[12]) {
                        $productImageThree = [
                            'product_id' => $addProduct->id,
                            'image_path' => 'product_images/'.$row[12],
                            'featured' => 0
    
                        ];
    
                        ProductImage::create($productImageThree);
                    }

                    if($row[13]) {
                        $productImageFour = [
                            'product_id' => $addProduct->id,
                            'image_path' => 'product_images/'.$row[13],
                            'featured' => 0
    
                        ];
    
                        ProductImage::create($productImageFour);
                    }

                    if($row[14]) {
                        $productImageFour = [
                            'product_id' => $addProduct->id,
                            'image_path' => 'product_images/'.$row[14],
                            'featured' => 0
    
                        ];
    
                        ProductImage::create($productImageFour);
                    }

                    $sizeAttribute = AttributeValue::where('value', $row[6])->first();
                    $colorAtytribute = AttributeValue::where('value', $row[7])->first();
                    $fabricAtytribute = AttributeValue::where('value', $row[8])->first();


                    $attributeData = [
                        'product_id' => $addProduct->id,
                        'sku' => $row[0],
                        'price' => $row[3],
                        'attribute_value_id' => $sizeAttribute->id.','.$colorAtytribute->id.','.$fabricAtytribute->id
                    ];

                    ProductAttribute::create($attributeData);
                    Product::where('id', $addProduct->id)->update(['status' => 1]);
                    ++$totalProductInserted;

                }

                // $data['sku'] = $row[0];
                // $data['status'] = $row[1];
                // $data['price'] = $row[2];
                // $data['selling_price'] = $row[3];
                // $data['stock'] = $row[4];
                // $data['length'] = $row[5];
                // $data['breadth'] = $row[6];
                // $data['height'] = $row[7];
                // $data['weight'] = $row[8];
                // $data['brand'] = $row[9];
                // $data['size'] = $row[10];
                // $data['color'] = $row[11];
                // $data['fabric'] = $row[12];
                // $data['main_image'] = $row[13];

                // $data['image1'] = $row[14];
                // $data['image2'] = $row[15];
                // $data['image3'] = $row[16];
    
                // $data['image4'] = $row[17];
                // $data['image5'] = $row[18];
    
                
                // $finalData[] = $data;
            }

        }

        // echo "<pre>"; print_r($finalData);
        // die("check");
        // Redirect back with a success message
        // return redirect()->back()->with('success', 'CSV file imported successfully');
        $brands = Brand::all();
        $categories = Category::all();
        $csvData = $finalData;

        $report = [
            'totalProductInserted' => $totalProductInserted,
            'duplicateProduct' => $duplicateProduct
        ];
        return view('products.importview', compact('brands', 'categories', 'report'));
    }

    function downloadImageFromUrl($imageUrl)
    {

        $imgExt = explode('.', $imageUrl);
        $totalSizeArr = count($imageUrl);
        $date = new DateTime();
        $date->format('Y-m-d H:i:sP') . '.'.$imgExt[$totalSizeArr - 1];

        $savePath = storage_path('app/product_images/'); // Specify your desired save path
        $response = Http::get($imageUrl);
        if ($response->successful()) {
            // Save the image to the specified path
            file_put_contents($savePath, $imageUrl);
        }
    }


    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::all();
        $categories = Category::all();

        return view('products.create', compact('brands', 'categories'));
    }

    public function create_slug() {
        $allProduct = Product::get();
        foreach ($allProduct as $key => $value) {
            
            if($this->checkslug($value->name)) {
                $slug = $this->checkslug($value->name);
                Product::where('id', $value->id)->update(['slug' =>$slug]); 
            }
                       
        }
        
        return "Slug Updated";
    }

    function checkslug ($slug) {
        $strSlug = Str::slug($slug);
        $slugData = Product::where('slug', $strSlug)->first();
        if($slugData) {
            
            return $this->checkslug($strSlug.'-'.$slugData->id.'-'.rand());
            
        }else{
            return $strSlug;
        }
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'sku' => 'required|unique:products',
            'meta_title' => 'nullable',
            'meta_description' => 'nullable',
            'meta_keywords' => 'nullable',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,category_id',
            'subcategory_id' => 'required|exists:categories,category_id',
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'sale_price' => 'nullable|numeric',
            'status' => 'required|boolean',
        ]);

        // if($validator->fails()) {
        //     return Redirect::back()->withErrors($validator);
        // }
        $productData = $request->all();
        $$productData['slug'] = $this->checkslug($request->input('name'));


        Product::create($productData);

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $brands = Brand::all();
        $categories = Category::all();
        $subcategories = Category::where('parent_id', $product->category_id)->get();

        return view('products.edit', compact('product', 'brands', 'categories', 'subcategories'));
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'sku' => 'required|unique:products,sku,' . $product->id,
            'meta_title' => 'nullable',
            'meta_description' => 'nullable',
            'meta_keywords' => 'nullable',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,category_id',
            'subcategory_id' => 'exists:categories,category_id',
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'sale_price' => 'nullable|numeric',
            'status' => 'required|boolean',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function getSubcategories(Request $request)
    {
        $categoryID = $request->input('category_id');

        $subcategories = Category::where('parent_id', $categoryID)->get();

        return response()->json($subcategories);
    }
}
