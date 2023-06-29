<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return User::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Validator::make($request->all(), [
            'first_name' => 'string|max:50',
            'last_name' => 'string|max:50',
            'user_role_id' => 'exists:user_role,id',
            'email' => 'string|email|unique:user|max:255',
        ])->validate();

        $user = User::find($id);

        $firstName = $request->input('first_name') ?? $user->first_name;
        $lastName = $request->input('last_name') ?? $user->last_name;
        $userRoleId = $request->input('user_role_id') ?? $user->user_role_id;
        $email = $request->input('email') ?? $user->email;

        $user->update([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
        ]);

        if ($request->user()->can('updateUserRole', User::class))
        {
            $user->update(['user_role_id' => intval($userRoleId)]);
        }

        return $user;    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return User::destroy($id);
    }

    /**
     * Search resource listings by email.
     */
    public function search(string $email)
    {
        return User::where('email', 'like', '%'.$email.'%')->get();
    }
}
