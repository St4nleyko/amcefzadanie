<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexUser()
    {
        $users = User::get();
        return view('user.index', compact('users'));
    }


    public function createUser(){
        return view('user.add');
    }

    public function editUser($id)
    {
        $user=User::findOrFail($id);
        $roles=Role::get()->pluck('name')->toArray();
        return view('user.edit', compact('user','roles'));

    }


    public function updateUser(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',

        ]);
        $data = $request->all();

        $user = User::find($id);
        $roles=[];
        if(isset($data['roles'])){
            $roles=$data['roles'];
        }
        if(!isset($data['password'])){
            unset($data['password']);
        }
        else {
            $data['password']=Hash::make($data['password']);
        }
        $user->syncRoles($roles);
        $user->update($data);
        return redirect('/users')->with('success', 'User is successfully edited');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect('/users')->with('success', 'User is successfully deleted');
    }



    protected function storeUser(Request $request)
    {
        $data = $request->all();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $roles=[];
        if(isset($data['roles'])){
            $roles=$data['roles'];
        }
        $user->syncRoles($roles);
        return redirect('/users')->with('success', 'User is successfully created');

    }

    public function myProfile()
    {
        $user=User::findOrFail(Auth::id());
        return view('user.profile', compact('user'));
    }

    public function updateMyProfile(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);
        $user = User::find($id);
        $data = $request->all();

        if(isset($data['password'])) {
            $this->validate($request, [
                'old_password' => 'required',
                'password' => 'different:old_password',
            ]);
            if (Hash::check($data['old_password'], $user->password)) {
                $data['password']=Hash::make($data['password']);

                $user->update($data);
                return redirect('/myprofile')->with('success', 'Your profile is successfully updated');
            }
            else {
                return redirect('/myprofile')->with('error', 'Invalid old password');
            }
        }

        else{
            unset($data['password']);
            unset($data['old_password']);
            $user->update($data);
            return redirect('/myprofile')->with('success', 'Your profile is successfully updated');
        }
    }
}
