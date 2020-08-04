<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UserRequest;
use App\User;
use App\Role;
use Session;
use Validator;
use Auth;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $roles = Role::all();
        // dd(Auth::user()->role->name);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->id == $id) {
            $user = User::find($id);
            return view('users.myaccount', compact('user'));
        } else {
            return redirect('/');
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('users.edit', compact('user'));
    }

    public function update_account(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:8',
            'email' => 'required:unique:users',
            'address' => 'required',
            'phone_no' => 'required|numeric',
            'postal_code' => 'required|numeric'
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->phone_no = $request->phone_no;
        $user->postal_code = $request->postal_code;
        $user->save();

        if($user->save()) {
            return back()->with('message', 'User updated successfully!');
        }
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
        $info_validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required:unique:users',
            'address' => 'required',
            'phone_no' => 'required|numeric',
            'postal_code' => 'required|numeric',
        ]);


        $user = User::find($id);
        $role = Role::where('user_id', $request->$id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->phone_no = $request->phone_no;
        $user->postal_code = $request->postal_code;
        $user->save();
        if($user->save()) {
            return redirect('users/'.$id.'/edit')->with('message', 'User updated successfully!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id)->delete();
        return redirect('/users')->with('message', 'User deleted successfully!');
    }

    public function change_password($id) {
        $user = User::find($id);
        return view('users.change-password', compact('user'));
    }

    public function update_password(Request $request, $id) {

        $request->validate([
            'current_password' => 'required|min:8',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password|min:8',
        ]);

        $user = User::find($id);
        if(Hash::check($request->current_password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();
            return back()->with('message', 'Password updated successfully!');
        } else {
            return back()->with('message', 'Password update failed!');
        }
    }
}
