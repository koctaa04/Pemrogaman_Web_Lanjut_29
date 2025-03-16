<?php

namespace App\Http\Controllers;

use App\DataTables\KategoriDataTable;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index(KategoriDataTable $dataTable){
        return $dataTable->render('kategori.index');
    }
}


// public function index(){
//     // $data = [
//     //     'kategori_kode' => 'SNK',
//     //     'kategori_nama' => 'Snack/Makanan Ringan',
//     //     'created_at' => now()
//     // ];

//     // DB::table('m_kategori')->insert($data);
//     // return 'insert data baru berhasil';

//     // $row = DB::table('m_kategori')->where('kategori_kode', 'SNK')->update(['kategori_nama' => 'Camilan']);
//     // return 'Update data berhasil. Jumlah data yang diupdate: ' . $row;

//     // $row = DB::table('m_kategori')->where('kategori_kode', 'SNK')->delete();
//     // return 'Delete data berhasil. Jumlah data yang dihapus: ' . $row;

//     $data = DB::table('m_kategori')->get();
//     return view('kategori', ['data' => $data]);
// }