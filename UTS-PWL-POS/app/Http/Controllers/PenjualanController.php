<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\BarangModel;
use Illuminate\Http\Request;
use App\Models\PenjualanModel;
use Illuminate\Routing\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PenjualanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar penjualan',
            'list' => ['Home', 'penjualan']
        ];
        $page = (object) [
            'title' => 'Daftar penjualan yang terdaftar dalam sistem'
        ];
        $activeMenu = 'penjualan';
        $barang = BarangModel::all(); // ambil data barang untuk filter barang
        $user = UserModel::all(); // ambil data user untuk filter user
        return view('penjualan.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $penjualans = PenjualanModel::with(['user', 'detailPenjualan.barang']);

        if ($request->barang_id) {
            $penjualans->whereHas('detailPenjualan', function ($query) use ($request) {
                $query->where('barang_id', $request->barang_id);
            });
        }

        if ($request->user_id) {
            $penjualans->where('user_id', $request->user_id);
        }

        return DataTables::of($penjualans)
            ->addIndexColumn()
            ->addColumn('user_nama', function ($penjualan) {
                return $penjualan->user->nama ?? '-';
            })
            ->addColumn('barang_nama', function ($penjualan) {
                return $penjualan->detailPenjualan->pluck('barang.barang_nama')->join(', ');
            })
            ->addColumn('total_harga', function ($penjualan) {
                return 'Rp ' . number_format($penjualan->detailPenjualan->sum(function ($item) {
                    return $item->harga * $item->jumlah;
                }), 0, ',', '.');
            })
            ->addColumn('aksi', function ($penjualan) {
                $btn = '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show_ajax(string $id)
    {
        $penjualan = PenjualanModel::with(['user', 'detailPenjualan'])->find($id);
        $penjualan->total_bayar = $penjualan->detailPenjualan->sum(fn($d) => $d->harga * $d->jumlah);

        return view('penjualan.show_ajax', ['penjualan' => $penjualan]);
    }
}
