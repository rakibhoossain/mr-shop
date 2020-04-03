<?php

namespace App\Http\Controllers;

use App\ProductTag;
use Illuminate\Http\Request;

class ProductTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:product-tags');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.product.tags.index');
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
            'html' => view('dashboard.product.tags.create_modal')->render()
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
            'name'          =>  'required|max:150|unique:product_tags,name',
        ]);

        if(ProductTag::create($request->only(['name']))){
            return redirect()->back()->with('success', 'Product Tag create success!');
        }
        return back()->with('error', 'Product Tag create failed!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductTag  $productTag
     * @return \Illuminate\Http\Response
     */
    public function show(ProductTag $productTag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductTag  $productTag
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductTag $productTag)
    {
        return response()->json([
            'success' => true,
            'html' => view('dashboard.product.tags.edit_modal', compact('productTag'))->render()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductTag  $productTag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductTag $productTag)
    {
        $request->validate([
            'name'   =>  'required|max:150|unique:product_tags,name,'.$productTag->id,
        ]);

        if($productTag->update($request->only(['name']))){
            return redirect()->back()->with('success', 'Product Tag update success!');
        }
        return back()->with('error', 'Product Tag update failed!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductTag  $productTag
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductTag $productTag)
    {
        if($productTag->delete()){
            return response()->json([
                'success' => true,
                'message' => 'Product Tag moved to trash!'
            ]);
        }else{
            return response()->json([
                'success' => true,
                'message' => 'Something went wrong!'
            ]);
        }
    }
}
