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
    //     public function list(Request $request)
    // {
    //     $query = Penjualan::with(['user', 'penjualan_detail.barang']);

    //     // Filter berdasarkan user dan barang jika dikirim dari client
    //     if ($request->user_id) {
    //         $query->where('user_id', $request->user_id);
    //     }

    //     if ($request->barang_id) {
    //         $query->whereHas('penjualan_detail', function ($q) use ($request) {
    //             $q->where('barang_id', $request->barang_id);
    //         });
    //     }

    //     return DataTables::of($query)
    //         ->addIndexColumn()
    //         ->addColumn('user_nama', function ($row) {
    //             return $row->user->user_nama ?? '-';
    //         })
    //         ->filterColumn('user_nama', function ($query, $keyword) {
    //             $query->whereHas('user', function ($q) use ($keyword) {
    //                 $q->where('user_nama', 'like', "%{$keyword}%");
    //             });
    //         })
    //         ->orderColumn('user_nama', function ($query, $order) {
    //             $query->leftJoin('m_user', 'penjualan.user_id', '=', 'm_user.user_id')
    //                   ->orderBy('m_user.user_nama', $order);
    //         })

    //         ->addColumn('barang_nama', function ($row) {
    //             // ambil nama barang pertama, jika ada
    //             return $row->penjualan_detail->first()->barang->barang_nama ?? '-';
    //         })
    //         ->filterColumn('barang_nama', function ($query, $keyword) {
    //             $query->whereHas('penjualan_detail.barang', function ($q) use ($keyword) {
    //                 $q->where('barang_nama', 'like', "%{$keyword}%");
    //             });
    //         })
    //         ->orderColumn('barang_nama', function ($query, $order) {
    //             $query->leftJoin('penjualan_detail', 'penjualan.penjualan_id', '=', 'penjualan_detail.penjualan_id')
    //                   ->leftJoin('m_barang', 'penjualan_detail.barang_id', '=', 'm_barang.barang_id')
    //                   ->orderBy('m_barang.barang_nama', $order);
    //         })

    //         ->addColumn('total_harga', function ($row) {
    //             return $row->penjualan_detail->sum(function ($item) {
    //                 return $item->harga * $item->jumlah;
    //             });
    //         })
    //         ->filterColumn('total_harga', function ($query, $keyword) {
    //             $query->whereHas('penjualan_detail', function ($q) use ($keyword) {
    //                 $q->whereRaw('(harga * jumlah) like ?', ["%$keyword%"]);
    //             });
    //         })
    //         ->orderColumn('total_harga', function ($query, $order) {
    //             // Sort by total_harga using subquery (or sort in collection if needed)
    //             // DataTables server-side can't easily sort by computed total unless denormalized
    //             // Simpler to skip orderColumn if complex, or pre-calculate and store total
    //         })

    //         ->addColumn('aksi', function ($row) {
    //             return view('penjualan.aksi', compact('row'))->render();
    //         })

    //         ->make(true);
    // }


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
            // ->filterColumn('user_nama', function ($query, $keyword) {
            //     $query->whereHas('user', function ($q) use ($keyword) {
            //         $q->where('nama', 'like', "%{$keyword}%");
            //     });
            // })
            ->orderColumn('user_nama', function ($query, $order) {
                $query->leftJoin('m_user', 't_penjualan.user_id', '=', 'm_user.user_id')
                    ->orderBy('m_user.nama', $order);
            })
            ->addColumn('barang_nama', function ($penjualan) {
                return $penjualan->detailPenjualan->pluck('barang.barang_nama')->join(', ');
            })
            // ->filterColumn('barang_nama', function ($query, $keyword) {
            //     $query->whereHas('detailPenjualan.barang', function ($q) use ($keyword) {
            //         $q->where('barang_nama', 'like', "%{$keyword}%");
            //     });
            // })
            ->orderColumn('barang_nama', function ($query, $order) {
                $query->leftJoin('t_penjualan_detail', 't_penjualan.penjualan_id', '=', 't_penjualan_detail.penjualan_id')
                    ->leftJoin('m_barang', 't_penjualan_detail.barang_id', '=', 'm_barang.barang_id')
                    ->orderBy('m_barang.barang_nama', $order);
            })
            ->addColumn('total_harga', function ($penjualan) {
                return 'Rp ' . number_format($penjualan->detailPenjualan->sum(function ($item) {
                    return $item->harga * $item->jumlah;
                }), 0, ',', '.');
            })
            ->filterColumn('total_harga', function ($query, $keyword) {
                $query->whereHas('detailPenjualan', function ($q) use ($keyword) {
                    $q->whereRaw('(harga * jumlah) like ?', ["%$keyword%"]);
                });
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
