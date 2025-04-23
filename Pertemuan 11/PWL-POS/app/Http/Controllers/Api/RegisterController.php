<?php

namespace App\Http\Controllers\Api;

use App\Models\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'nama' => 'required',
            'password' => 'required|min:5|confirmed',
            'level_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048' // menambahkan image
        ]);

        // if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(),422);
        }
        $image = $request->file('image');

        // create user
        $user = UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password),
            'level_id' => $request->level_id,
            // 'image' => $request->image // menambahkan image
            'image' => $image->hashName()
        ]);

        // Return response JSON user is created
        if($user) {
            return response()->json([
                'success' => true,
                'user' => $user,
            ],201);
        }

        // Return JSON process insert failed
        return response()->json([
            'success' => false,
        ], 409);
    }
}
