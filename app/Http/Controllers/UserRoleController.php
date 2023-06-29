<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\UserRole;

class UserRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserRole::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required|unique:user_role|string|max:20'
        ], [
            'name.unique' => 'A user role with that name already exists.',
        ])->validate();

        return UserRole::create([
            'name' => $request->name
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return UserRole::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Validator::make($request->all(), [
            'name' => 'required|unique:user_role|string|max:20'
        ], [
            'name.unique' => 'A user role with that name already exists.',
        ])->validate();

        $userRole = UserRole::find($id);
        $userRole->update([
            'name' => $request->name
        ]);
        
        return $userRole;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return UserRole::destroy($id);
    }

    /**
     * Search resource listings by name.
     */
    public function search(string $name)
    {
        return UserRole::where('name', 'like', '%'.$name.'%')->get();
    }
}
