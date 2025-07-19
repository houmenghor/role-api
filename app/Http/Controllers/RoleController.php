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
        $role = new Role();
        $role->name = $request->input('name');
        $role->status = $request->input('status');
        $role->description = $request->input('description');
        $role->save();
        return response()->json([
            "result" => true,
            "message" => "Role created successfully!",
            "data" => $role
        ],201);
    }

    public function index(Request $request)
    {
        $request->validate([
            "column" => "nullable|exists:roles,id,name",
            "sort" => "nullable|in:desc,asc",
        ]);
        $column = $request->input('column') ?? 'id';
        $sort = $request->input('sort') ?? 'asc';
        $role = new Role();
        if ($request->filled('search'))
        {
            $role = $role->where('id','like','%'.$request->input('search').'%');
            // $role = $role->orWhere('name','like','%'.$request->input('search').'%');
        }
        $role = $role->orderBy($column,$sort)->get();

        return response()->json([
            "result" => true,
            "message" => "Successfully!",
            "data" => $role
        ],200);
    }

    public function destroy($id)
    {

    }
}
