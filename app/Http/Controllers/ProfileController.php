<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        /* return response()->json(['status'=>$request]); */
        $user = User::findOrfail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();
        sleep(1);
        return response()->json(['status'=>'User successfully edited.']);
    }
    public function updatePassword(Request $request, string $id)
    {
        /* return response()->json(['status'=>$request]); */
        $user = User::findOrfail($id);

        $request->validate([
            'oldPassword' => 'required|string|max:255',
            'newPassword' => 'required|string|max:255',
            'confimNewPassword' => 'required|string|max:255',
        ]);

        if (Hash::check($request->oldPassword, $user->password)) {
            /* return response()->json(['message' => 'Succesfull password']); */
            if ($request->newPassword == $request->confimNewPassword) {
                $user->password = Hash::make($request->newPassword);
                $user->save();
                return response()->json(['status' => 'Succesfull password'], 422);
            }
            if ($request->newPassword != $request->confimNewPassword) {
                return response()->json(['status' => 'Password does not match'], 401);
            }
        }

        if ( !Hash::check($request->oldPassword, $user->password)) {
            return response()->json(['status' => 'Not succesfull password'], 401);
        }

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
