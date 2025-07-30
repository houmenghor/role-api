<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50,unique:roles,name'
        ]);

        $role = new Role();
        $role->name = $request->input('name');
        $role->save();
        return response()->json([
            "result" => true,
            "message" => "Role created successfully!",
            "data" => $role
        ], 201);
    }

    public function index()
    {
        $role = new Role();
        $role = $role->orderBy('id', 'asc')->get();
        return response()->json([
            "result" => true,
            "message" => "Successfully!",
            "data" => $role
        ], 200, [], JSON_PRETTY_PRINT);
    }

    public function destroy(Request $request ,$id)
    {
        $request->merge(['id' => $id]);

        $request->validate([
            'id' => 'required|integer|min:1|exists:roles,id'
        ]);

        $role = new Role();

        $role->where('id',$id)->delete();

        return response()->json([
            "result" => true,
            "message" => "Role deleted successfully!",
        ],200);
    }
    public function update(Request $request, $id)
    {
        $request->merge(['id' => $id]);
        $validate = $request->validate([
            'id'          => 'required|integer|min:1|exists:roles,id',
            'name'        => 'nullable|string|max:50|unique:roles,name,' . $id,
        ]);
        $role = new Role();
        $role->where('id',$id)->update($validate);
        return response()->json([
            "result" => true,
            "message" => "Role updated successfully!",
        ], 200);
    }
}
