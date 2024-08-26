<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;
use Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;


class RoleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $isSuperAdmin = $user->hasRole('superAdmin');

        if($isSuperAdmin){
            $roles= Role::get();
            return view('role.index', compact('roles'));
        }
        else {
            return redirect('home');
        }
    }

    public function addRole()
    {
        return view('role.create');
    }

    public function storeRole(Request $request)
    {
        {
            $validatedData = $request->validate([
                'name' => 'required|max:255',
            ]);
            $data = $request->all();
            $role = Role::create($data);
        }
        return redirect('/roles')->with('success', 'Role is successfully created');
    }

    public function editRole($id)
    {
        $role=Role::findOrFail($id);
        return view('role.edit', compact('role'));
    }

    public function updateRole(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',

        ]);
        $role=Role::find($id);
        $data = $request->all();
        $role->update($data);
        return redirect('/roles')->with('success', 'Role is successfully updated');
    }

    public function deleteRole($id)
    {
        $role=Role::findOrFail($id);
        $role->delete();
        return redirect('/roles')->with('success', 'Role is was deleted');

    }
}
