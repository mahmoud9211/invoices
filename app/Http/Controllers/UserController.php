<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use Spatie\Permission\Models\Role;
use DB;
use Hash;

class UserController extends Controller
{

    public function index(Request $request)
{
$data = User::where('roles_name','user')->paginate(5);
return view('users.show_users',compact('data'))
->with('i', ($request->input('page', 1) - 1) * 5);
}
/**
* Show the form for creating a new resource.
*
* @return \Illuminate\Http\Response
*/
public function create()
{
//$roles = Role::pluck('name','name')->all();
$roles = Role::get();
return view('users.create',compact('roles'));
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
'email' => 'required|email|unique:users,email',
'password' => 'required|same:confirm-password',
'roles_name' => 'required'
]);
$input = $request->all();
$input['password'] = Hash::make($input['password']);
$user = User::create($input);
$user->assignRole($request->input('roles_name'));

$msg = ([

    'message' => 'تم اضافة المستخدم بنجاح',
    'alert-type' => 'success'

]);
return redirect()->route('users.index')
->with($msg);
}
/**
* Display the specified resource.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function show($id)
{
$user = User::find($id);
return view('users.show',compact('user'));
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
$roles = Role::all();
$userRole = $user->roles->pluck('name','name')->all();
return view('users.edit',compact('user','roles','userRole'));
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
$this->validate($request, [
'name' => 'required',
'email' => 'required|email|unique:users,email,'.$id,
'roles_name' => 'required'
]);
$input = $request->all();

$user = User::find($id);
$user->update($input);
DB::table('model_has_roles')->where('model_id',$id)->delete();
User::find($id)->assignRole($request->input('roles'));



$msg = ([
    'message' => 'تم تعديل بيانات المستخدم',
    'alert-type' => 'info'
]);

return redirect()->to('/users')
->with($msg);
}



/**
* Remove the specified resource from storage.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function del(Request $request)
{
 $id = $request->id;
User::find($id)->delete();

$msg = ([
    'message' => 'تم حذف المستخدم',
    'alert-type' => 'info'
]);

return redirect()->to('/users')
->with($msg);
}


}
