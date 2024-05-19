<?php

namespace App\Http\Controllers;

use App\Exceptions\SuccessResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('register')->only('store');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 'get all users';
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
        try {
//            $validator = Validator::make($request->all(), [
//                'name' => 'required|string|max:255',
//                'email' => 'required|string|email|max:255|unique:users',
//                'password' => 'required|string|min:8',
//            ]);
//
//            if ($validator->fails()) {
//                return response()->json([
//                    'errors' => $validator->errors(),
//                ], 422);
//            }.
            $existingUser = User::where('name', $request->name)->first();
            if ($existingUser) {
                return response()->json([
                    'message' => 'User already exists.',
                ], 409);
            }

            $newUser = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'country' => $request->country,
                'city' => $request->city,
            ]);
            $newUser->roles()->attach(3);
            $newUser->save();

            return SuccessResponse::create('User created successfully.', $newUser, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'errors' => $th->getMessage(),
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json([
                    'message' => 'User not found.',
                ], 404);
            }

            var_dump($user);

            return response()->json([
                'user' => $user,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'errors' => $th->getMessage(),
            ], 500);
        }
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
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'message' => 'User not found.',
            ], 404);
        }

        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json([
            'message' => 'User updated successfully.',
            'user' => $user,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'message' => 'User not found.',
            ], 404);
        }

        $user->delete();
        return response()->json([
            'message' => 'User soft deleted successfully.',
            'id' => $id,
        ], 200);
    }
}
