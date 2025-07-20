<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50,unique:roles,name',
            'status' => 'nullable|boolean|in:1,0',
            'description' => 'nullable|string'
        ]);
        // $validatedData = $request->validate([
        //     'name' => 'required|string|max:50|unique:roles,name',
        //     'status' => 'nullable|boolean|in:1, 0',
        //     'description' => 'nullable|string'
        // ]);

        // $role = Role::create($validatedData);

        $role = new Role();
        $role->name = $request->input('name');
        $role->status = $request->input('status');
        $role->description = $request->input('description');
        $role->save();
        return response()->json([
            "result" => true,
            "message" => "Role created successfully!",
            "data" => $role
        ], 201);
    }

    public function index(Request $request)
    {
        $request->validate([
            "column" => "nullable|in:roles,id,name",
            "sort" => "nullable|in:desc,asc",
        ]);
        $column = $request->input('column') ?? 'id';
        $sort = $request->input('sort') ?? 'asc';
        $role = new Role();

        if ($request->filled('id')) {
            $role = $role->where('id', 'like', '%' . $request->input('id') . '%');
        }

        if ($request->filled('name')) {
            $role = $role->where('name', 'like', '%' . $request->input('name') . '%');
        }

        $role = $role->orderBy($column, $sort)->get();

        return response()->json([
            "result" => true,
            "message" => "Successfully!",
            "data" => $role
        ], 200, [], JSON_PRETTY_PRINT);
    }

    public function destroy(Request $request ,$id)
    {
        $request->merge(['id' => $id]);

        // use validated when delete if id not found it's not show status 500
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
            'status'      => 'nullable|boolean|in:1,0',
            'description' => 'nullable|string'
        ]);
        $role = new Role();
        $role->where('id',$id)->update($validate);
        return response()->json([
            "result" => true,
            "message" => "Role updated successfully!",
        ], 200);
    }
}
