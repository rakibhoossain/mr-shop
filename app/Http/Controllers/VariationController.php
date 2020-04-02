<?php

namespace App\Http\Controllers;

use App\Variation;
use Illuminate\Http\Request;

class VariationController extends Controller
{
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
            'name' => 'required'
        ]);

        $variation = Variation::create(['name' => $request->name]);

        if($variation){
            foreach ($request->names as $key => $name) {

                $data = [];

                $type = $request->types[$key];
                $color = $request->datas[$key];

                if($name) $data['name'] = $name;

                if( $name && $color && $type && ($type == 'color') ){ 
                    $data['type'] = 'color';
                    $data['data'] =  $color;
                }
                if(!empty($data)) $variation->values()->create($data);
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
        //
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
