<?php

namespace App\Http\Controllers;

use App\Variation;
use App\VariationValue;
use Illuminate\Http\Request;

class VariationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:product-varient');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.product.variation.index');
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
            'html' => view('dashboard.product.variation.create_modal')->render()
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
        $this->validate($request, [
            'name' => 'required|min:4|unique:variations,name'
        ]);

        $variation = Variation::create(['name' => $request->name]);

        if($variation){
            if($request->names){
                foreach ($request->names as $key => $name) {
                    $data = [];
                    $type = ($request->types)? $request->types[$key] : null;
                    if($name) $data['name'] = $name;
                    if($request->datas){
                        $color = (isset($request->datas[$key]))? $request->datas[$key] : null;
                        if( $name && $color && $type && ($type == 'color') ){ 
                            $data['type'] = 'color';
                            $data['data'] =  $color;
                        }                    
                    }
                    if(!empty($data)) $variation->values()->create($data);
                } 
            }
            return redirect()->back()->with('success', 'Variation create success!');
        }
        return back()->with('error', 'Variation create failed!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Variation  $variation
     * @return \Illuminate\Http\Response
     */
    public function show(Variation $variation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Variation  $variation
     * @return \Illuminate\Http\Response
     */
    public function edit(Variation $variation)
    {
        return response()->json([
            'success' => true,
            'html' => view('dashboard.product.variation.edit_modal', compact('variation'))->render()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Variation  $variation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Variation $variation)
    {
        $this->validate($request, [
            'name' => 'required|min:4|unique:variations,name,'.$variation->id
        ]);

        if($variation->update(['name' => $request->name])){

            if($request->names){
                foreach ($request->names as $key => $name) {
                    $data = [];
                    $type = ($request->types)? $request->types[$key] : null;
                    if($name) $data['name'] = $name;
                    if($request->datas){
                        $color = (isset($request->datas[$key]))? $request->datas[$key] : null;
                        if( $name && $color && $type && ($type == 'color') ){ 
                            $data['type'] = 'color';
                            $data['data'] =  $color;
                        }                    
                    }
                    if(!empty($data)) $variation->values()->create($data);
                } 
            }

            if($request->v_dels){
                try{
                  VariationValue::destroy($request->v_dels);  
                }catch(\Exception $e){

                }              
            }

            if($request->old_names){
                foreach ($request->old_names as $id => $name) {
                    $variation_update = VariationValue::find($id);
                    if($variation_update){

                        $data = [];
                        $type = ($request->old_types)? $request->old_types[$id] : null;
                        if($name) $data['name'] = $name;
                        if($request->old_datas){
                            $color = (isset($request->old_datas[$id]))? $request->old_datas[$id] : null;
                            if( $name && $color && $type && ($type == 'color') ){ 
                                $data['type'] = 'color';
                                $data['data'] =  $color;
                            }                    
                        }

                        if(!empty($data)) $variation_update->update($data);
                    }                    
                } 
            }

            return redirect()->back()->with('success', 'Variation update success!');
        }
        return back()->with('error', 'Variation update failed!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Variation  $variation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Variation $variation)
    {
        if($variation->values()->delete() && $variation->delete()){
            return response()->json([
                'success' => true,
                'message' => 'Variation moved to trash!'
            ]);
        }else{
            return response()->json([
                'success' => true,
                'message' => 'Something went wrong!'
            ]);
        }
    }
}
