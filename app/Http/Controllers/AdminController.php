<?php

namespace App\Http\Controllers;

use App\Admin;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Hash;
use Arr;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $admins = Admin::latest()->paginate(20);
        return view('admin.index',compact('admins'))->with('i', ($request->input('page', 1) - 1) * 20);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('admin.create',compact('roles'));
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
            'name' => 'required',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|same:password_confirmation',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
    
        $admin = Admin::create($input);
        $admin->assignRole($request->input('roles'));
    
        return redirect()->route('admin.index')->with('success','Admin created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        return view('admin.show',compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        $roles = Role::pluck('name','name')->all();
        $userRole = $admin->roles->pluck('name','name')->all();
        return view('admin.edit',compact('admin', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
         $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:admins,email,'.$admin->id,
            'password' => 'nullable|same:password_confirmation',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
    
        $admin->update($input);    
        $admin->syncRoles($request->input('roles'));    
        return redirect()->route('admin.index')->with('success','Admin updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        if($admin->delete()){
            return response()->json([
                'success' => true,
                'message' => 'Admin delete successfully!'
            ]);
        }else{
            return response()->json([
                'success' => true,
                'message' => 'Something went wrong!'
            ]);
        }
    }
}
