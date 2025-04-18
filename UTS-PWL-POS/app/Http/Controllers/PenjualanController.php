<?php

namespace App\Http\Controllers;

use App\Models\StokModel;
use App\Models\UserModel;
use App\Models\BarangModel;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PenjualanModel;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\PenjualanDetailModel;
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

    public function create_ajax()
    {
        $barangs = BarangModel::all();
        return view('penjualan.create_ajax', compact('barangs'));
    }
public function store_ajax(Request $request)
{
    $rules = [
        'pembeli' => ['required', 'string', 'max:100'],
        'details' => ['required', 'array', 'min:1'],
        'details.*.barang_id' => ['required', 'integer', 'exists:m_barang,barang_id'],
        'details.*.jumlah' => ['required', 'integer', 'min:1'],
        'details.*.harga' => ['required', 'numeric'],
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validasi Gagal',
            'msgField' => $validator->errors()
        ]);
    }

    DB::beginTransaction();
    try {
        $kode = 'TRX-' . strtoupper(substr(preg_replace('/\s+/', '', $request->pembeli), 0, 3)) . '-' . now()->format('YmdHis');
        $tanggal = now();
        $user_id = auth()->id() ?? 1;

        // Buat transaksi penjualan
        $penjualan = PenjualanModel::create([
            'user_id' => $user_id,
            'pembeli' => $request->pembeli,
            'penjualan_kode' => $kode,
            'penjualan_tanggal' => $tanggal,
        ]);

        // Loop melalui detail transaksi penjualan
        foreach ($request->details as $index => $detail) {
            // Ambil stok barang yang dibeli
            $barang = BarangModel::where('barang_id', $detail['barang_id'])->first();
            // Cek apakah stok cukup
            if (!$barang || $barang->stok < $detail['jumlah']) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Stok tidak mencukupi untuk barang pada baris ke-' . ($index + 1)
                ]);
            }


            // Update stok di tabel m_barang
            // $barang = BarangModel::findOrFail($detail['barang_id']);
            $barang->stok -= $detail['jumlah'];
            $barang->save();

            // Simpan detail transaksi
            PenjualanDetailModel::create([
                'penjualan_id' => $penjualan->penjualan_id,
                'barang_id' => $detail['barang_id'],
                'jumlah' => $detail['jumlah'],
                'harga' => $detail['harga'],
            ]);
        }

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Penjualan berhasil disimpan'
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'status' => false,
            'message' => 'Gagal menyimpan: ' . $e->getMessage()
        ]);
    }
}


    public function confirm_ajax($id)
    {
        $penjualan = PenjualanModel::with(['detailPenjualan.barang', 'user'])->find($id);
        return view('penjualan.confirm_ajax', ['penjualan' => $penjualan]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $penjualan = PenjualanModel::find($id);
            if ($penjualan) {
                $penjualan->delete();
                return response()->json([
                    'status'  => true,
                    'message' => 'Data penjualan berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data penjualan tidak ditemukan'
                ]);
            }
        }
    }

    public function edit_ajax($id)
    {
        $penjualan = PenjualanModel::find($id);

        if (!$penjualan) {
            return response()->view('penjualan.edit_ajax', ['penjualan' => null]);
        }

        return response()->view('penjualan.edit_ajax', ['penjualan' => $penjualan]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $validator = Validator::make($request->all(), [
                'pembeli' => 'required|string|max:255',
                'penjualan_tanggal' => 'required|date',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $penjualan = PenjualanModel::find($id);

            if (!$penjualan) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data penjualan tidak ditemukan'
                ]);
            }

            $penjualan->pembeli = $request->pembeli;
            $penjualan->penjualan_tanggal = $request->penjualan_tanggal;
            $penjualan->save();

            return response()->json([
                'status' => true,
                'message' => 'Data penjualan berhasil diperbarui'
            ]);
        }
    }
}
