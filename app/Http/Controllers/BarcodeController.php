<?php

namespace App\Http\Controllers;

use App\Barcode;
use Illuminate\Http\Request;

class BarcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:barcode');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.product.barcode.index');
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
            'html' => view('dashboard.product.barcode.create_modal')->render()
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
            'name'                  =>  'required|max:150|unique:barcodes,name',
            'description'           =>  'nullable',
            'width'                 =>  'required|numeric',
            'height'                =>  'required|numeric',
            'paper_width'           =>  'required|numeric',
            'paper_height'          =>  'nullable|numeric',
            'top_margin'            =>  'nullable|numeric',
            'left_margin'           =>  'nullable|numeric',
            'row_distance'          =>  'nullable|numeric',
            'col_distance'          =>  'nullable|numeric',
            'stickers_in_one_row'   =>  'required|numeric',
            'stickers_in_one_sheet' =>  'nullable|required_without:is_continuous|numeric',
            'is_continuous'         =>  'nullable|boolean',
            'is_default'            =>  'nullable|boolean'
        ]);

        $barcode = Barcode::create($request->except(['is_default']));
        if($barcode){
            if($request->is_default){
                Barcode::where('is_default' , true)->update(['is_default' => false]);
                $barcode->update(['is_default' => true]);
            }
            return redirect()->back()->with('success', 'Barcode create success!');
        }
        return back()->with('error', 'Barcode create failed!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Barcode  $barcode
     * @return \Illuminate\Http\Response
     */
    public function show(Barcode $barcode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Barcode  $barcode
     * @return \Illuminate\Http\Response
     */
    public function edit(Barcode $barcode)
    {
        return response()->json([
            'success' => true,
            'html' => view('dashboard.product.barcode.edit_modal', compact('barcode'))->render()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Barcode  $barcode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Barcode $barcode)
    {
        $request->validate([
            'name'                  =>  'required|max:150|unique:barcodes,name,'.$barcode->id,
            'description'           =>  'nullable',
            'width'                 =>  'required|numeric',
            'height'                =>  'required|numeric',
            'paper_width'           =>  'required|numeric',
            'paper_height'          =>  'nullable|numeric',
            'top_margin'            =>  'nullable|numeric',
            'left_margin'           =>  'nullable|numeric',
            'row_distance'          =>  'nullable|numeric',
            'col_distance'          =>  'nullable|numeric',
            'stickers_in_one_row'   =>  'required|numeric',
            'stickers_in_one_sheet' =>  'nullable|required_without:is_continuous|numeric',
            'is_continuous'         =>  'nullable|boolean',
            'is_default'            =>  'nullable|boolean'
        ]);

        if($barcode->update($request->except(['is_default']))){
            if($request->is_default){
                Barcode::where('is_default' , true)->update(['is_default' => false]);
                $barcode->update(['is_default' => true]);
            }
            return redirect()->back()->with('success', 'Barcode update success!');
        }
        return back()->with('error', 'Barcode update failed!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Barcode  $barcode
     * @return \Illuminate\Http\Response
     */
    public function destroy(Barcode $barcode)
    {
        if($barcode->delete()){
            return response()->json([
                'success' => true,
                'message' => 'Barcode moved to trash!'
            ]);
        }else{
            return response()->json([
                'success' => true,
                'message' => 'Something went wrong!'
            ]);
        }
    }
}
