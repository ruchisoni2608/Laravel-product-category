<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use DB;

class CategoriesController extends Controller
{





    public function index()
{
    $categories = Categories::orderBy('id', 'asc')->get();
    $nestedCategories = $this->buildNestedCategories($categories);
    $dropdownOptions = [];

    foreach ($categories as $category) {
        $dropdownOptions[$category->id] = $this->generateDropdownOptions($nestedCategories, $category->parent_category);
    }
        // print_r($categories);
        // echo"<br>";
        //   print_r($nestedCategories);
        // echo"<br>";
        // print_r($dropdownOptions);
        // echo"<br>";
        // foreach ($categories as $category){
        //     echo "<br>";
        //      print_r($category->parent_category );
        //     echo "<br>";
        //     print_r($category->name );
        //     <option value="{{ $category->id }}" {{ $category->id == $category->parent_category ? 'selected' : '' }}>
        //         {{ $category->name }}
        //     </option>
        // }

    return view('Categories.index', [
        'categories' => $categories,
        'NestedCategories' => $nestedCategories,
        'DropdownOptions' => $dropdownOptions,
    ]);
}
public function buildNestedCategories($categories, $parentId = 0, $depth = 0)
    {
        $nestedCategories = [];

        foreach ($categories as $category) {
            if ($category->parent_category == $parentId) {
                $category->depth = $depth;
                $category->children = $this->buildNestedCategories($categories, $category->id, $depth + 1);
                $nestedCategories[] = $category;
            }
        }

        return $nestedCategories;
    }

    public function generateDropdownOptions($categories, $selectedCategory, $indentation = '')
    {
        $options = '';

        foreach ($categories as $category) {
            $options .= '<option value="' . $category->id . '"';

            if ($category->id == $selectedCategory) {
                $options .= ' selected';
            }

            $options .= '>' . $indentation . $category->name . '</option>';

            if ($category->children && count($category->children) > 0) {
                $options .= $this->generateDropdownOptions($category->children, $selectedCategory, '&nbsp;&nbsp;&nbsp;&nbsp;' . $indentation);
            }
        }

        return $options;
    }



// public function index()
// {
//     $categories = Categories::orderBy('id', 'asc')->get();
//     $nestedCategories = $this->buildNestedCategories($categories);
//     $dropdownOptions = [];

//     foreach ($categories as $category) {
//         $dropdownOptions[$category->id] = $this->generateDropdownOptions($nestedCategories, $category->parent_category);
//     }

//     return view('Categories.index', [
//         'categories' => $categories,
//         'NestedCategories' => $nestedCategories,
//         'DropdownOptions' => $dropdownOptions,
//     ]);
// }


    // public function buildNestedCategories($categories, $parentId = 0, $depth = 0)
    // {
    //     $nestedCategories = [];

    //     foreach ($categories as $category) {
    //         if ($category->parent_category == $parentId) {
    //             $category->depth = $depth;
    //             $category->children = $this->buildNestedCategories($categories, $category->id, $depth + 1);
    //             $nestedCategories[] = $category;
    //         }
    //     }

    //     return $nestedCategories;
    // }

    // private static function generateDropdownOptions($categories, $selectedCategory, $indentation = '')
    // {
    //     $options = '';

    //     foreach ($categories as $category) {
    //         $options .= '<option value="' . $category['value'] . '"';
    //         if ($category['value'] == $selectedCategory) {
    //             $options .= ' selected';
    //         }
    //         $options .= '>' . $indentation . $category['text'] . '</option>';

    //         if (isset($category['children']) && count($category['children']) > 0) {
    //             $options .= self::generateDropdownOptions($category['children'], $selectedCategory, '&nbsp;&nbsp;&nbsp;&nbsp;' . $indentation);
    //         }
    //     }

    //     return $options;
    // }


    // public function generateDropdownOptions($categories, $selectedCategory, $indentation = '')
    // {
    //     $options = [];

    //     foreach ($categories as $category) {
    //         $options[$category->id] = $indentation . $category->name;

    //         if ($category->children && count($category->children) > 0) {
    //             $options += $this->generateDropdownOptions($category->children, $selectedCategory, '&nbsp;&nbsp;&nbsp;&nbsp;' . $indentation);
    //         }
    //     }

    //     return $options;
    // }
//     private function generateDropdownOptions($categories, $selectedCategory, $indentation = '')
// {
//     $options = '';

//     foreach ($categories as $category) {
//         $options .= '<option value="' . $category->id . '"';
//         if ($category->id == $selectedCategory) {
//             $options .= ' selected';
//         }
//         $options .= '>' . $indentation . $category->name . '</option>';

//         if ($category->children && count($category->children) > 0) {
//             $options .= $this->generateDropdownOptions($category->children, $selectedCategory, '&nbsp;&nbsp;&nbsp;&nbsp;' . $indentation);
//         }
//     }

//     return $options;
// }




// public function index()
// {
//     $categories = Categories::orderBy('id', 'asc')->get();
//     $nestedCategories = $this->buildNestedCategories($categories);

//     $dropdownOptions = [];

//     foreach ($categories as $category) {
//         $dropdownOptions[$category->id] = $this->generateDropdownOptions($nestedCategories, $category->parent_category);
//     }

//     return view('Categories.index', [
//         'Categories' => $categories,
//         'NestedCategories' => $nestedCategories,
//         'DropdownOptions' => $dropdownOptions,
//     ]);
// }

// public function buildNestedCategories($categories, $parentId = 0, $depth = 0)
// {
//     $nestedCategories = [];

//     foreach ($categories as $category) {
//         if ($category->parent_category == $parentId) {
//             $category->depth = $depth;
//             $category->children = $this->buildNestedCategories($categories, $category->id, $depth + 1);
//             $nestedCategories[] = $category;
//         }
//     }

//     return $nestedCategories;
// }

    // public function generateDropdownOptions($categories, $selectedCategory, $parentCategoryValues, $indentation = '')
    // {
    //     $options = '';

    //     foreach ($categories as $category) {
    //         $options .= '<option value="' . $category->id . '"';
    //         if ($category->id == $selectedCategory) {
    //             $options .= ' selected';
    //         }
    //         $options .= '>' . $indentation . $category->name . '</option>';

    //         if ($category->children && count($category->children) > 0) {
    //             $options .= $this->generateDropdownOptions($category->children, $selectedCategory, $parentCategoryValues, '&nbsp;&nbsp;&nbsp;&nbsp;' . $indentation);
    //         }
    //     }

    //     if (isset($parentCategoryValues[$selectedCategory])) {
    //         $options .= '<option value="' . $selectedCategory . '" selected>' . $indentation . $parentCategoryValues[$selectedCategory] . '</option>';
    //     }

    //     return $options;
    // }





    // public function generateDropdownOptions($selectedCategory, $categories, $indentation = '')
    // {
    //     $options = '';

    //     foreach ($categories as $category) {
    //         $options .= '<option value="' . $category->id . '"';

    //         if ($category->id == $selectedCategory) {
    //             $options .= ' selected';
    //         }

    //         $options .= '>' . $indentation . $category->name . '</option>';

    //         if ($category->children && count($category->children) > 0) {
    //             $options .= $this->generateDropdownOptions($selectedCategory, $category->children, '&nbsp;&nbsp;&nbsp;&nbsp;' . $indentation);
    //         }
    //     }

    //     return $options;
    // }



    // public function index()
    // {
    //     $categories = Categories::orderBy('id', 'asc')->get();
    //     $nestedCategories = $this->buildNestedCategories($categories);

    //         // Generate dropdown options HTML for the nested categories
    //     $dropdownOptions = $this->generateDropdownOptions($nestedCategories);

    //     return view('Categories.index', [
    //         'Categories' => $categories,
    //         'NestedCategories' => $nestedCategories,
    //         'dropdownOptions' => $dropdownOptions,
    //     ]);
    //     //return view('Categories.index', ['Categories' => $categories, 'NestedCategories' => $nestedCategories]);
    // }



    // private function generateDropdownOptions($categories, $indentation = '')
    // {
    //     $options = '';

    //     foreach ($categories as $category) {
    //         $options .= '<option value="' . $category->id . '">' . $indentation . $category->name . '</option>';
    //         if ($category->children) {
    //             $options .= $this->generateDropdownOptions($category->children, $indentation . '&nbsp;&nbsp;&nbsp;&nbsp;');
    //         }
    //     }

    //     return $options;
    // }
    // private function generateDropdownOptions($categories, $selectedCategory)
    // {
    //     $options = '';

    //     foreach ($categories as $category) {
    //         $options .= '<option value="' . $category->id . '"';

    //         if ($category->id == $selectedCategory) {
    //             $options .= ' selected';
    //         }

    //         $options .= '>' . str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $category->depth) . $category->name . '</option>';
    //     }

    //     return $options;
    // }
    // private function generateDropdownOptions($categories, $selectedCategory, $indentation = '')
    // {
    //     $options = '';

    //     foreach ($categories as $category) {
    //         $options .= '<option value="' . $category->id . '"';

    //         if ($category->id == $selectedCategory) {
    //             $options .= ' selected';
    //         }

    //         $options .= '>' . $indentation . $category->name . '</option>';

    //         if ($category->children && count($category->children) > 0) {
    //             $options .= $this->generateDropdownOptions($category->children, $selectedCategory, '&nbsp;&nbsp;&nbsp;&nbsp;' . $indentation);
    //         }
    //     }

    //     return $options;
    // }


    public function store(Request $request)
    {
        $request->validate([
            'name.*' => 'required',
            'parent_category.*' => 'required|integer',
        ]);

        $names = $request->input('name');
        $parentCategories = $request->input('parent_category');

        foreach ($names as $index => $name) {
            // Check if the category already exists
            $existingCategory = Categories::where('name', $name)
                ->where('parent_category', $parentCategories[$index])
                ->first();

            if (!$existingCategory) {
                $parent = $parentCategories[$index];
                while ($parent > 0) {
                    $parentCategory = Categories::find($parent);
                    if (!$parentCategory) {
                        break;
                    }
                    if ($parentCategory->name === $name) {
                        // If the same category name already exists in the hierarchy, don't create
                        break;
                    }
                    $parent = $parentCategory->parent_category;
                }

                if ($parent === 0) {
                    // If we reached the top-level category, then create the new category
                    $category = new Categories;
                    $category->name = $name;
                    $category->parent_category = $parentCategories[$index];
                    $category->save();

                    //dd('Category inserted successfully:', $category);
                }
            }
        }

        return "Categories have been created successfully.";
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required',
            'parent_category' => 'required|integer',
        ]);

        $category = Categories::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->name = $request->input('name');
        $category->parent_category = $request->input('parent_category');

        $category->save();

        return response()->json(['message' => 'Category updated successfully']);
    }


    public function destroy($id)
    {
        $category = Categories::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }


























    //     public function index()
// {
//     $data['Categories'] = Categories::orderBy('id', 'desc')->get();

//     return view('Categories.index', $data);
// }
    // public function index()
    // {
    //     $data['Categories'] = Categories::orderBy('id','desc')->paginate(5);
    //     $data['ParentCategories'] = Categories::pluck('id', 'id'); // Retrieve all 'id' values

    //     return view('Categories.index', $data);
    // }
    // public function index()
    // {
    //     $data['Categories'] = Categories::orderBy('id', 'desc')->get();
    //     $data['ParentCategories'] = Categories::whereNull('parent_category')->pluck('name', 'id'); // Retrieve parent categories

    //     // Retrieve all categories to build a mapping of parent-child relationship
    //     $allCategories = Categories::all()->groupBy('parent_category');

    //     // Prepare sub-categories for each parent
    //     foreach ($data['ParentCategories'] as $parentId => $parentName) {
    //         $data['SubCategories'][$parentId] = $allCategories->get($parentId, []);
    //     }

    //     return view('Categories.index', $data);
    // }

    // public function index()
    // {
    //     $data['Categories'] = Categories::orderBy('id', 'desc')->get();
    //     $data['ParentCategories'] = Categories::whereNull('parent_category')->pluck('name', 'id'); // Retrieve parent categories

    //     // Fetch sub-categories for each parent category
    //     foreach ($data['ParentCategories'] as $parentId => $parentName) {
    //         $data['SubCategories'][$parentId] = Categories::where('parent_category', $parentId)->pluck('name', 'id');
    //     }

    //     return view('Categories.index', $data);
    // }

 // public function index()
    // {

//         $catewithoutparent = Categories::where('parent_category',0)->orderBy('id', 'desc')->get();

//         $catewithparent = Categories::where('parent_category','>', 0)->orderBy('id', 'desc')->get();
//        $category =$catewithoutparent->toArray();

//        $zero=[];
//             foreach($catewithparent  as $z){
//                 print_r($z->parent_category);
//                 echo"<br>";
//                     if (array_key_exists($z->parent_category,$zero))
//                     {
//                         $z->parent_category[]=$zero[];
//                         $r[]=[5];
//                     //echo "Key exists!";
//                     }
//                       else
//                     {
//                     echo "Key does not exist!";
//                     }
//             }
// exit;
//         echo "<pre>";
//       print_r($data['Categories'] );
// exit;
//         return view('Categories.index', $data);
    // }

    // public function index()
    // {
    //     $categories = Categories::orderBy('id', 'asc')->get();
    //     $nestedCategories = $this->buildNestedCategories($categories);

    //     return view('Categories.index', ['Categories' => $nestedCategories]);
    // }





    public function create()
    {
        return view('Categories.create');
    }




    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|array',
    //         'parent_category' => 'required|array',
    //     ]);

    //     $names = $request->input('name');
    //     $parentCategories = $request->input('parent_category');

    //     foreach ($names as $index => $name) {
    //         $category = new Categories;
    //         $category->name = $name;
    //         $category->parent_category = $parentCategories[$index];
    //         $category->save();
    //     }

    //     return "Categories have been created successfully.";
    // }

    // public function test()
    // {
    //     $name= $request->name;
    //     $category=$request->category;

    //     for($i=0; $i <count($name);$i++){
    //         $datasave = [
    //             'id' => 1,
    //             'name' => $name[$i],
    //             'parent_category' => $parent_category[$i]
    //         ];
    //         DB::table('categories')->insert($datasave);
    //     }
    //     Session::put('sucess',"data saved...");
    //     return back();
    // }

    public function show(Categories $Categories)
    {
        return view('Categories.index',compact('Categories'));
    }


    // public function edit(Categories $Categories)
    // {
    //     return view('Categories.edit',compact('Categories'));
    // }


    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'name' => 'required',
    //         'parent_category' => 'required',
    //     ]);

    //     $Categories = Categories::find($id);

    //     $Categories->name = $request->name;
    //     $Categories->parent_category = $request->parent_category;


    //     $Categories->save();

    //     return redirect()->route('Categories.index')
    //                     ->with('success','Categories Has Been updated successfully');
    // }


    // public function destroy(Categories $Categories)
    // {
    //     echo "dd";
    //     exit;
    //     $Categories->delete();

    //     return redirect()->route('Categories.index')
    //                     ->with('success','Categories has been deleted successfully');
    // }



}
