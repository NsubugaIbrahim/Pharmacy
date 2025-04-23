<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('roles.index',compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        Role::create($request->all());

        return redirect()->route('roles.index')->with('success','Role created successfully.');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        $roles = Role::findOrFail($id);
        $roles->update($request->all());

        return redirect()->route('roles.index')->with('success', 'Supplier updated successfully.');
    }

    public function destroy($id)
    {
        $roles = Role::findOrFail($id);
        $roles->delete();

        return redirect()->route('roles.index')->with('success', 'Supplier deleted successfully.');
    }
}
