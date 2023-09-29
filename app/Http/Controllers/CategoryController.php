<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all(); // Fetch all categories for dropdown selection
    
        return view('categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // Validate the input data
        $validatedData = $request->validate([
            'name' => 'required',
            'meta_title' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/categories/'), $imageName);
        } else {
            $imageName = null;
        }

        // Create a new category
        $category = new Category;
        $category->name = $request->input('name');
        $category->slug = $this->checkslug($request->input('name'));
        $category->image = $imageName;
        $category->parent_id = $request->input('parent_id');
        $category->meta_title = $request->input('meta_title');
        $category->meta_description = $request->input('meta_description');
        $category->meta_keywords = $request->input('meta_keywords');
        $category->status = $request->input('status', true);
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function create_slug() {
        $allProduct = Category::get();
        foreach ($allProduct as $key => $value) {
            
            if($this->checkslug($value->name)) {
                $slug = $this->checkslug($value->name);
                Category::where('category_id', $value->category_id )->update(['slug' =>$slug]); 
            }
                       
        }
        
        return "Slug Updated";
    }

    function checkslug ($slug) {
        $strSlug = Str::slug($slug);
        $slugData = Category::where('slug', $strSlug)->first();
        if($slugData) {
            
            return $this->checkslug($strSlug.'-'.$slugData->category_id.'-'.rand());
            
        }else{
            return $strSlug;
        }
    }


    // Add other resource methods like show(), edit(), update(), destroy() based on your requirements.
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::all(); // Fetch all categories for dropdown selection

        return view('categories.edit', compact('category', 'categories'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.show', compact('category'));
    }

/**
 * Update the specified resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function update(Request $request, $id)
{
    // Validate the input data
    $validatedData = $request->validate([
        'name' => 'required',
        'meta_title' => 'required',
        'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the file size and allowed extensions as per your requirements
    ]);

    // Find the category by ID
    $category = Category::findOrFail($id);

    // Handle image upload
    if ($request->hasFile('image')) {
        // Delete the existing image file
        if ($category->image) {
            $imagePath = public_path('images/categories/' . $category->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Upload the new image file
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('images/categories/'), $imageName);

        $category->image = $imageName;
    }

    // Update category details
    $category->name = $request->input('name');
    $category->parent_id = $request->input('parent_id');
    $category->meta_title = $request->input('meta_title');
    $category->meta_description = $request->input('meta_description');
    $category->meta_keywords = $request->input('meta_keywords');
    $category->status = $request->input('status', true);
    $category->save();

    return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }

}
