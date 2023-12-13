<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Image;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Routing\Controller;

use App\Models\Categories;
use App\Helpers\CategoryHelper;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $data['Products'] = Product::orderBy('id','desc')->paginate(5);

    //     return view('Products.index', $data);
    // }
    public function index()
    {
        $Products = Product::with(['images', 'categories'])->orderBy('id', 'desc')->paginate(5);

        return view('Products.index', compact('Products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     return view('Products.create');
    // }

    public function create()
    {
        $categories = Categories::orderBy('id', 'asc')->get();
        $nestedCategories = CategoryHelper::buildNestedCategories($categories);
        $selectedCategories = []; // Define an empty array for selected categories

        return view('Products.create', compact('nestedCategories', 'selectedCategories'));
    }
    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required',
    //         'description' => 'required',
    //         'image' => 'required'
    //     ]);
    //     $Product = new Product;
    //     $Product->name = $request->name;
    //     $Product->description = $request->description;
    //     $Product->save();
    //     return redirect()->route('Products.index')
    //                     ->with('success','Products has been created successfully.');
    // }


        public function store(Request $request)
        {
            // dd($request->all());
            $request->validate([
                'name' => 'required',
                'description' => 'required',
                // 'status' => 'required|in:active,inactive',

            ]);

            $product = new Product;
            $product->name = $request->name;
            $product->description = $request->description;

             $product->status = $request->has('status') ? 1 : 0; // Set status based on switch toggle
            $product->save();

            // Attach selected categories to the product
            if ($request->has('cat')) {
                foreach ($request->cat as $categoryId) {
                    $product->categories()->attach($categoryId);
                }
            }

            // Handle image upload
            if ($request->hasFile('file')) {

                foreach ($request->file('file') as $image) {
                  //  dd($request->file('file'));
                    $filename = $image->getClientOriginalName();
                    $image->move(public_path('images'), $filename);

                    // Save image data to the images table
                    $product->images()->create([
                        'filename' => $filename,
                    ]);
                }

            }

            if ($request->hasFile('images')) {

                 foreach ($request->file('images') as $image) {
                     $filename = $image->getClientOriginalName();
                     $image->move(public_path('images'), $filename);

                     // Save image data to the images table
                     $product->images()->create([
                         'filename' => $filename,
                     ]);
                 }

             }


            return redirect()->route('Products.index')
                ->with('success', 'Product has been created successfully.');
        }




    /**
     * Display the specified resource.
     */
    public function show(Product $Product)
    {
        return view('Products.show',compact('Product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Product $Product)
    // {
    //     return view('Products.edit',compact('Product'));
    // }
    // public function edit($id)
    // {
    //     $Product = Product::findOrFail($id);
    //     $categories = Categories::orderBy('id', 'asc')->get();
    //     $nestedCategories = CategoryHelper::buildNestedCategories($categories);
    //     $selectedCategories = $Product->categories->pluck('id')->toArray();

    //     return view('Products.edit', compact('Product', 'nestedCategories', 'selectedCategories'));
    // }
    public function edit($id)
{
    $Product = Product::findOrFail($id);
    $categories = Categories::orderBy('id', 'asc')->get();
    $nestedCategories = CategoryHelper::buildNestedCategories($categories);
    $selectedCategories = $Product->categories->pluck('id')->toArray();

    return view('Products.edit', compact('Product', 'nestedCategories', 'selectedCategories'));
}


    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        dd($request->all());
        $request->validate([
            'name' => 'required',
           'description' => 'required',
        //    'status' => 'required|in:active,inactive',


        ]);

        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->description = $request->description;

        $product->status = $request->has('status') ? 1 : 0;

        $product->save();

            // Update selected categories for the product
        if ($request->has('cat')) {
            $product->categories()->sync($request->cat);
        } else {
            $product->categories()->detach(); // Detach all categories if none are selected
        }

        // Handle file image update
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = $image->getClientOriginalName();
                $image->move(public_path('images'), $filename);

                // Save image data to the images table
                $product->images()->create([
                    'filename' => $filename,
                ]);
            }
        }

            // Handle dropzone image upload
            if ($request->hasFile('file')) {

                foreach ($request->file('file') as $image) {
                  //  dd($request->file('file'));
                    $filename = $image->getClientOriginalName();
                    $image->move(public_path('images'), $filename);

                    // Save image data to the images table
                    $product->images()->create([
                        'filename' => $filename,
                    ]);
                }

            }


        return redirect()->route('Products.index')
            ->with('success', 'Product has been updated successfully.');
    }

    public function removeProductImage(Request $request)
    {

        $filename = $request->input('filename');

        // Delete the image record from the database
        // Assuming you have an 'images' table and a 'Image' model
        Image::where('filename', $filename)->delete();

        // Delete the physical image file from the storage
        // You may need to adjust the path to match your setup
        $imagePath = public_path('images/' . $filename);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        return response()->json(['message' => 'Image removed successfully']);
    }


    // public function update(Request $request, Product $Product)
    // {
    //     $request->validate([
    //         'name' => 'required',
    //         'description' => 'required',
    //         'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'status' => 'required|in:active,inactive',

    //     ]);


    //     $Product = Product::find($id);
    //     $Product->name = $request->name;
    //     $Product->description = $request->description;
    //     $product->status = $request->status;
    //    // $Products->address = $request->address;

    //     $Product->save();

    //     return redirect()->route('Products.index')
    //                     ->with('success','Products Has Been updated successfully');
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $Product)
    {
        $Product->delete();

        return redirect()->route('Products.index')
                        ->with('success','Product has been deleted successfully');

    }
}
