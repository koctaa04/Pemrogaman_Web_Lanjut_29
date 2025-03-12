<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){

        // $user = UserModel::find(1);
        // $user = UserModel::where('level_id', 1)->first();
        // $user = UserModel::firstwhere('level_id', 1);
        // $user = UserModel::findOr(1,['username', 'nama'], function(){
        //     abort(404);
        // });
        $user = UserModel::findOr(20,['username', 'nama'], function(){
            abort(404);
        });
        return view('user', ['data' => $user]);
    }
}


        // $data = [
        //     'username' => 'customer-2',
        //     'nama' => 'pelanggan',
        //     'password' => Hash::make('12345'),
        //     'level_id' => 4
        // ];

        // UserModel::insert($data);
        
        // $data = [
        //     'nama' => 'pelanggan pertama'
        // ];
        
        // UserModel::where('username', 'customer-1')->update($data);

        // $user = UserModel::all();
        // return view('user', ['data' => $user]);


        // PERTEMUAN 4
        // $data = [
        //     'level_id' => 2,
        //     'username' => 'manager_tiga',
        //     'nama' => 'Manager 3',
        //     'password' => Hash::make('12345')
        // ];

        // UserModel::create($data);
        // $user = UserModel::all();
        // return view('user', ['data' => $user]);
        