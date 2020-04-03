<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\Request;
use Image;
use Storage;
use Str;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:product-brand');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.product.brand.index');
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
            'html' => view('dashboard.product.brand.create_modal')->render()
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
            'name'          =>  'required|max:150|unique:brands,name',
            'image'         =>  'required',
            'description'   =>  'nullable',
        ]);

        $input = $request->only(['name', 'description']);
        if($request->hasFile('image')) $input['image'] = $this->saveBrandImage($request->file('image'));
        if(Brand::create($input)){
            return redirect()->back()->with('success', 'Brand create success!');
        }
        return back()->with('error', 'Brand create failed!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        return response()->json([
            'success' => true,
            'html' => view('dashboard.product.brand.edit_modal', compact('brand'))->render()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name'          =>  'required|max:150|unique:brands,name,'.$brand->id,
            'image'         =>  'nullable',
            'description'   =>  'nullable',
        ]);

        $input = $request->only(['name', 'description']);
        if($request->hasFile('image')){
            $this->deletBrandImage($brand);
            $input['image'] = $this->saveBrandImage($request->file('image'));
        } 

        if($brand->update($input)){
            return redirect()->back()->with('success', 'Brand update success!');
        }
        return back()->with('error', 'Brand update failed!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        $this->deletBrandImage($brand);

        if($brand->delete()){
            return response()->json([
                'success' => true,
                'message' => 'Brand moved to trash!'
            ]);
        }else{
            return response()->json([
                'success' => true,
                'message' => 'Something went wrong!'
            ]);
        }
    }

    private function deletBrandImage($brand){
        if( $brand->image ){
            $image = Str::replaceFirst('storage/', '', $brand->image);
            Storage::disk('public')->delete($image);
        }
    }
    private function saveBrandImage($image){
        $location = 'brands/'.md5( $image->getClientOriginalName(). microtime() ).'.'.$image->getClientOriginalExtension();
        Storage::disk('public')->put($location, Image::make($image)->fit(250)->stream() );
        return 'storage/'.$location;
    }
}
