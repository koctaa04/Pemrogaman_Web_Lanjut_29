<?php

namespace App\Http\Controllers;

use App\Models\StokModel;
use App\Models\UserModel;
use App\Models\BarangModel;
use Illuminate\Http\Request;
use App\Models\SupplierModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class StokController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar stok',
            'list' => ['Home', 'stok']
        ];
        $page = (object) [
            'title' => 'Daftar stok yang terdaftar dalam sistem'
        ];
        $activeMenu = 'stok';
        $barang = BarangModel::all(); // ambil data barang untuk filter barang
        $supplier = SupplierModel::all(); // ambil data supplier untuk filter supplier
        return view('stok.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'supplier' => $supplier, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $stoks = StokModel::select('stok_id', 'barang_id', 'user_id', 'supplier_id', 'stok_tanggal', 'stok_jumlah')
            ->with(['barang', 'user', 'supplier']);

        if ($request->barang_id) {
            $stoks->where('barang_id', $request->barang_id);
        }

        if ($request->supplier_id) {
            $stoks->where('supplier_id', $request->supplier_id);
        }

        return DataTables::of($stoks)
            ->addIndexColumn()
            ->addColumn('aksi', function ($stok) {
                $btn = '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
    public function show_ajax($id)
    {
        $stok = StokModel::with(['barang', 'user', 'supplier'])->find($id);
        return view('user.show_ajax', compact('stok'));
    }


    public function create_ajax()
    {
        $barang = BarangModel::select('barang_id', 'barang_nama')->get();
        // $user = UserModel::select('user_id', 'nama')->get();
        $supplier = SupplierModel::select('supplier_id', 'supplier_nama')->get();

        return view('stok.create_ajax', [
            'barang' => $barang,
            // 'user' => $user,
            'supplier' => $supplier
        ]);
    }

    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'barang_id'    => 'required|integer|exists:m_barang,barang_id',
                'supplier_id'  => 'required|integer|exists:m_supplier,supplier_id',
                'stok_tanggal' => 'required|date',
                'stok_jumlah'  => 'required|integer|min:1',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors() // pesan error validasi
                ]);
            }

            $data = $request->all();
            $data['user_id'] = 1;
            // $data['user_id'] = auth()->user()->user_id;
            StokModel::create($data);

            return response()->json([
                'status'  => true,
                'message' => 'Data stok berhasil disimpan.',
            ]);
        }
        

        return redirect('/');
    }
}
