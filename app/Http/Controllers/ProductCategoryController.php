<?php

namespace App\Http\Controllers;

use App\ProductCategory;
use Illuminate\Http\Request;
use Image;
use Storage;
use Str;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:product-category');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = ProductCategory::whereNull('product_category_id')->latest()->get();
        return view('dashboard.product.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json([
            'success' => true,
            'html' => view('dashboard.product.category.create_modal')->render()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'          =>  'required|max:150|unique:product_categories,name',
            'image'         =>  'required|max:1024|mimes:jpeg,png',
            'description'   =>  'nullable',
        ]);

        $input = $request->only(['name', 'description']);
        if($request->hasFile('image')) $input['image'] = $this->saveCategoryImage($request->file('image'));

        $category = ProductCategory::create($input);
        if($category){
            if($request->sub_categories){
                $sub_categories = ProductCategory::whereIn('id', (array) $request->sub_categories)->get();
                if($sub_categories){
                    foreach ($sub_categories as $cat) {
                        $cat->update(['product_category_id' => $category->id]);
                    }
                }
            }
            return redirect()->back()->with('success', 'Product category create successfully!');
        }
        return back()->with('error', 'Product category create failed!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductCategory $productCategory)
    {
        $categories = ProductCategory::doesntHave('children')->whereNull('product_category_id')->get();
        return response()->json([
            'success' => true,
            'html' => view('dashboard.product.category.edit_modal', compact('productCategory', 'categories'))->render()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        $request->validate([
            'name'          =>  'required|max:150|unique:product_categories,name,'.$productCategory->id,
            'image'         =>  'nullable|max:1024|mimes:jpeg,png',
            'description'   =>  'nullable',
        ]);

        $input = $request->only(['name', 'description']);
        if($request->hasFile('image')){
            $this->deletCategoryImage($productCategory);
            $input['image'] = $this->saveCategoryImage($request->file('image'));  
        } 
        if($productCategory->update($input)){
            if($request->sub_categories){
                if($productCategory->children) $productCategory->children()->update(['product_category_id' => null]); //Remove old categories
                $sub_categories = ProductCategory::whereIn('id', (array) $request->sub_categories)->get();
                if($sub_categories){
                    foreach ($sub_categories as $cat) {
                        $cat->update(['product_category_id' => $productCategory->id]);
                    }
                }
            }
            return redirect()->back()->with('success', 'Product category update successfully!');
        }
        return back()->with('error', 'Product category update failed!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCategory $productCategory)
    {
        $this->deletCategoryImage($productCategory);
        if($productCategory->children) $productCategory->children()->update(['product_category_id' => null]);

        if($productCategory->delete()){
            return response()->json([
                'success' => true,
                'message' => 'Category moved to trash!'
            ]);
        }else{
            return response()->json([
                'success' => true,
                'message' => 'Something went wrong!'
            ]);
        }
    }

    private function deletCategoryImage($productCategory){
        if( $productCategory->image ){
            $image = Str::replaceFirst('storage/', '', $productCategory->image);
            Storage::disk('public')->delete($image);
        }
    }
    private function saveCategoryImage($image){
        $location = 'category/'.md5( $image->getClientOriginalName(). microtime() ).'.'.$image->getClientOriginalExtension();
        Storage::disk('public')->put($location, Image::make($image)->fit(250)->stream() );
        return 'storage/'.$location;
    }
}
