<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Models\ProductAttribute;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductAttributeImage;

class ProductAttributeController extends Controller
{
    public function index($productId)
    {
        // Display a list of product attributes
        $productAttributes = ProductAttribute::with('product', 'attribute', 'attributeValues')->where('product_id', $productId)->get();
        
        // $productAttributes = Product::with('attributes')->where('id', $productId)->first();
        // echo "<pre>"; print_r(json_encode($productAttributes)); die("check");

        // $products = [];
        // $sku = '';
        // foreach($productAttributes as $key => $value) {
        //     $sku = $value->sku;
        //     $matchdata['sku'] = $sku;
        //     if($sku != $value->sku) {

        //         $matchdata['variation'][] = $value; 
        //     }
        //     $products[] = $matchdata;
        //     // echo "<pre>"; echo "Key : ".$value->sku; print_r($value->product); die("check");
        // }

        // echo "<pre>"; print_r($products); die("check");

        return view('product-attributes.index', compact('productAttributes', 'productId'));
    }

    public function create($productId)
    {

        $allAttribute = Attribute::with('attributeValues')->get();
        // echo "<pre>"; print_r($allAttribute); die("check");
        // Show the form to create a new product attribute
        return view('product-attributes.create', compact('allAttribute', 'productId'));
    }

    public function store(Request $request)
    {

        // echo "<pre>"; print_r($request->all()); print_r($request->file('files')); die("check");

        // Validation rules
        $rules = [
            // 'attribute_id' => 'required',
            // 'attribute_value_id' => 'required',
            'attributes' => 'required',
            'price' => 'required|numeric',
            'inventory' => 'required|integer',
            'sku' => 'required'

        ];

        // Validate the request data
          // Custom validation messages (optional)
        $messages = [
            // 'name.required' => 'The name field is required.',
            // Add custom messages for other fields as needed
        ];


        $validatedData = $request->validate($rules, $messages);

        $checkSku = ProductAttribute::where('sku', $request->input('sku'))->first();

        if($checkSku) {
            return redirect()->back()->withErrors(['msg' => 'Already sku exists']);
        }

        // foreach($request->input('attributes') as $value){
            // $attData = explode(':', $value);
            // Create a new product attribute
            $productAttribute = new ProductAttribute();
            $productAttribute->product_id = $request->input('product_id');
            // $productAttribute->attribute_id = $attData[0];
            $productAttribute->attribute_value_id = $request->input('attributes');
            $productAttribute->sku = $validatedData['sku'];
            $productAttribute->inventory = $validatedData['inventory'];
            $productAttribute->price = $validatedData['price'];

            // Add more attributes as needed

            // Save the product attribute
            $productAttribute->save();
        // }


        
        if ($request->hasFile('files')) {
         
            $images = $request->file('files');
            // echo "<pre>"; print_r($images); die("check");
            foreach ($images as $key => $image) {
                $imagePath = $image->store('product_images', 'public');

                $image = new ProductAttributeImage();
                // $image->product_attribute_id = $productAttribute->id;
                $image->sku = $request->input('sku');
                $image->image_path = $imagePath;
                $image->save();
                // echo "<pre>"; print_r($image); die("check");
            }
        }

                // echo "<pre>"; print_r($request->all()); die("check");

        // Redirect to a success page or back to the form with a success message
        // return redirect()->route('product-attributes.index', $request->input('product_id'))->with('success', 'Product Attribute created successfully.');
        return redirect()->back()->with('success', 'Product Attribute created successfully.');

    }

    // createAllvariation

 
    public function createAllvariation(Request $request, $productId) {
        // echo "ProductId : ".$productId;
        // echo "<pre>"; print_r($request->all()); die("check");

        $allAttribute = Attribute::with('attributeValues')->get();

        $allAttr = [];
        foreach ($allAttribute as $key => $value) {
            $attributeId = $value->id;
            $attrVal = [];            
            foreach($value->attributeValues as $item) {
                $attrVal[] = $item->id;
            }
            $allAttr[] = $attrVal;
        }

        // echo "<pre>"; print_r($allAttr); die("check data");

        $result = [[]];
        foreach ($allAttr as $property => $property_values) {
            $tmp = [];
            foreach ($result as $result_item) {
                foreach ($property_values as $property_value) {
                    $tmp[] = array_merge($result_item, [$property => $property_value]);
                }
            }
            $result = $tmp;
        }

        $allcreatedVariant = $result;

        

        return view('product-attributes.select_variation', compact('allcreatedVariant', 'productId', 'allAttribute'));
    }

    public function selectattributeforproduct($product) {
        $allAttribute = Attribute::with('attributeValues')->get();
        return view('product-attributes.selectattributevalue', compact('allAttribute', 'product'));
    }

    public function generatefinalvariationonselection(Request $request, $productId) {
        // echo "product : ".$product."<br>";
        // echo "<pre>"; print_r($request->all()); die("check");
        $allAttribute = Attribute::with('attributeValues')->get();
        $result = [[]];
        foreach ($request->all() as $property => $property_values) {
            $tmp = [];
            foreach ($result as $result_item) {
                foreach ($property_values as $property_value) {
                    $tmp[] = array_merge($result_item, [$property => $property_value]);
                }
            }
            $result = $tmp;
        }

        $allcreatedVariant = $result;

        

        return view('product-attributes.select_variation', compact('allcreatedVariant', 'productId', 'allAttribute'));
    }

    public function generatevariation(Request $request) {
        $variation = [];
        $attributeArr = [];
        foreach($request->input('attributes') as $key => $value) {
           $attValue = [];
            $data = explode(':', $value);
            $attribute = $data[0];

            
            if(!in_array($attribute, $attributeArr)){
                $attributeArr['attribute'] = $attribute;

                foreach($request->input('attributes') as $key => $item) {
                    $attributeData = explode(':', $item);
                    if($attribute == $attributeData[0]) {
                        $attValue[] = $attributeData[1];
                    }

                }

                $attributeArr['attributeValue'] = $attValue;
                $variation[] = $attributeArr;                
            }



        }
        echo "<pre>"; print_r($variation); print_r($request->all('attributes')); die("check");
    }



    public function show(ProductAttribute $productAttribute)
    {
        // Display a specific product attribute
        return view('product-attributes.show', compact('productAttribute'));
    }

    public function edit(ProductAttribute $productAttribute)
    {
        // Show the form to edit a product attribute
        return view('product-attributes.edit', compact('productAttribute'));
    }

    public function update(Request $request, ProductAttribute $productAttribute)
    {

        ProductAttribute::where('sku', $request->input('sku'))
       ->update([
           'price' => $request->input('price'),
           'inventory' => $request->input('inventory')

        ]);

        if ($request->hasFile('files')) {
         
            $images = $request->file('files');
            // echo "<pre>"; print_r($images); die("check");
            foreach ($images as $key => $image) {
                $imagePath = $image->store('product_images', 'public');

                $image = new ProductAttributeImage();
                // $image->product_attribute_id = $productAttribute->id;
                $image->sku = $request->input('sku');
                $image->image_path = $imagePath;
                $image->save();
                // echo "<pre>"; print_r($image); die("check");
            }
        }

        // return redirect()->route('product-attributes.index', $request->input('product_id'))->with('success', 'Product Attribute updated successfully.');
        return redirect()->back()->with('success', 'Product Attribute updated successfully.');


    }

    public function destroy(ProductAttribute $productAttribute)
    {
        // Delete a product attribute
        // Redirect to the index view with a success message
    }

    public function getAttributeValues(Request $request)
    {
        $attributeId = $request->input('attribute_id');

        $attribute = Attribute::find($attributeId);

        if (!$attribute) {
            return response()->json(['error' => 'Attribute not found'], 404);
        }

        // $attributeValues = $attribute->values;
        $attributeValues = AttributeValue::where('attribute_id', $attributeId)->get();

        return response()->json(['attribute_values' => $attributeValues]);
    }

    public function showProductImages($sku, $productId) {
        $getProductAttributeImages = ProductAttributeImage::where('sku', $sku)->get();
        return view('product-attributes.product_images', compact('getProductAttributeImages', 'productId'));
    }

    public function deleteProductImages(Request $request, $id) {

        $deleteImage = ProductAttributeImage::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Product Attribute images deleted successfully.');

    }

}
