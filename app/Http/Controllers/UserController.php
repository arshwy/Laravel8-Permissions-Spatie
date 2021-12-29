<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{

    public function login(){
      return view('auth.login');
    }

    public function register(){
      return view('auth.register');
    }

    public function create(Request $request) {
      $request->validate([
        'name' => 'required|min:4|max:50',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|max:12|min:6|confirmed',
        'password_confirmation' => 'required'
      ]);
      User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password)
      ]);
      return redirect()->back()->with('success', 'Regisered successfully!');
    }


    public function check(Request $request) {
      $request->validate([
        'email' => 'required|email|exists:users,email',
        'password' => 'required|max:50|min:6'
      ],[
        'email.exists' => 'This email does not exist.'
      ]);
      if (Auth::attempt($request->only(['email', 'password']))) {
        return redirect()->route('posts.home');
      }
      return redirect()->back()->with('fail', 'Invalid password');
    }


    public function logout(){
      Auth::logout();
      return redirect()->route('user.login');
    }





    // Admin API's
    public function createRole(Request $request){
      if ($request->name) {
        $role = Role::where('name', $request->name)->first();
        if ($role) {
          echo "Role: ".$request->name." already exists!";
        }
        else {
          Role::create(['name' => $request->name]);
          echo "Role: ".$request->name." has been created successfully!";
        }
      }
      else {
        echo "Role name not found!";
      }
    }

    public function createPermission(Request $request){
      if ($request->name) {
        $permission = Permission::where('name', $request->name)->first();
        if ($permission) {
          echo "Permission: ".$request->name." already exists!";
        }
        else {
          Permission::create(['name' => $request->name]);
          echo "Permission: ".$request->name." has been created successfully!";
        }
      }
      else {
        echo "Permission name not found!";
      }
    }

    public function givePermissionTo($role_name, $permission_name){
      $error = '';
      $role = Role::where('name', $role_name)->first();
      if (!$role) {
        $error = "Role (name) not found!, ";
      }
      $permission = Permission::where('name', $permission_name)->first();
      if (!$permission) {
        $error .= "Permission (name) not found!";
      }
      if (!$error) {
        $role->givePermissionTo($permission);
        echo "Permission: '".$permission_name."' has been given to Role: '".$role_name."' successfully!";
      }
      else {
        echo $error;
      }
    }

    public function makeWriter(Request $request){
      if ($request->user_id) {
        $user = User::find($request->user_id);
        $user->assignRole('writer');
        echo $user->name." became Writer.";
      }
      else {
        echo "user_id not found";
      }
    }

    public function makeEditor(Request $request){
      if ($request->user_id) {
        $user = User::find($request->user_id);
        $user->assignRole('editor');
        echo $user->name." became Editor.";
      }
      else {
        echo "user_id not found";
      }
    }

    public function makePublisher(Request $request){
      if ($request->user_id) {
        $user = User::find($request->user_id);
        $user->assignRole('publisher');
        echo $user->name." became Publisher.";
      }
      else {
        echo "user_id not found";
      }
    }



    // this function runs once
    public function createAdmin(Request $request){
      $role = Role::where('name', 'admin');
      if ($role) {
        echo "Admin already created once!";
      }
      else {
        $user = User::where('email', $request->email)->first();
        if ($user) {
          // This code only happen once
          // creating required roles
          $writer    = Role::create(['name' => 'writer']);
          $editor    = Role::create(['name' => 'editor']);
          $publisher = Role::create(['name' => 'publisher']);
          $admin     = Role::create(['name' => 'admin']);
          // creating required permission
          $writePost    = Permission::create(['name'=>'write post']);
          $editPost     = Permission::create(['name'=>'edit post']);
          $publishPost  = Permission::create(['name'=>'publish post']);
          // assign the roles with the required permissions
          $writer->givePermissionTo($writePost);
          $editor->givePermissionTo($editPost);
          $publisher->givePermissionTo($publishPost);
          // multi permissions
          $admin->syncPermissions([$writePost, $editPost, $publishPost]);
          // asssing admin role the the given email
          $user->assignRole('admin');
          echo "User: ".$user->name." became the Admin!";
        }
        else {
          echo "Email is not found!";
        }

      }
    }




} // class end
