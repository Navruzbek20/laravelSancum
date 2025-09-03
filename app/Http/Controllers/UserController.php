<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function register(Request $request){
        // $validatedData = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'username' => 'required|string|username|max:255|unique:username',
        //     'password' => 'required|string|min:8',
        // ]);

        $user = User::create([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password'))
        ]);

        return response()->json(['message' => 'Malumot saqlandi'], 201);
    }
    public function login(Request $request){

        $password = $request->get('password');
        $username = $request->get('username');
        if (!(isset($username) && isset($password))) {
            return response()->json(['message' => 'Логин ва паролни киритинг.', 'error' => true], 403);
        }
        $user = User::where('username', '=', $username)->first();
        if (!$user) return response()->json(['message' => 'Бундай фойдаланувчи йўқ!', 'error' => true], 403);
        if (Hash::check($password, $user->password)) {
            $token = $user->createToken("SECRET")->plainTextToken;
            return response()->json(["token" => $token, "error" => false], 200);
        } else {
            return response()->json(['message' => 'Логин ёки парол нотўғри!', 'error' => true], 403, []);
        }
    }
    public function user(){

        return UserResource::collection(User::paginate(env('PG')));

    }
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ], 200);
    }
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $user->update([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            // password bo'sh kelmaganida yangilaymiz
            'password' => $request->filled('password')
                ? Hash::make($request->input('password'))
                : $user->password,
        ]);

        return response()->json([
            'message' => 'User updated successfully',
        ], 200);
    }
    public function setActive($id){
        $user = User::find($id);
        $user->active = ! $user->active;
        $user->save();
        return  $user;
    }

}