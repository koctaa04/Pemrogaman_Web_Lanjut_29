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
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

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
                // hanya tampilkan tombol Edit & Hapus jika user adalah manager
                if (auth()->user()->level->level_kode === 'MNG') {
                    $btn .= '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                    $btn .= '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                }
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
                // Ambil data barang yang dibeli
                $barang = BarangModel::where('barang_id', $detail['barang_id'])->first();
                // Cek apakah stok cukup
                if (!$barang || $barang->stok < $detail['jumlah']) {
                    DB::rollBack();
                    return response()->json([
                        'status' => false,
                        'message' => 'Stok tidak mencukupi untuk barang pada baris ke-' . ($index + 1)
                    ]);
                }

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

    public function import()
    {
        return view('penjualan.import');
    }

    public function import_ajax(Request $request)
    {
        if (! $request->ajax() && ! $request->wantsJson()) {
            return redirect()->back();
        }

        // 1) validasi file
        $validator = Validator::make($request->all(), [
            'file_penjualan' => ['required', 'mimes:xlsx', 'max:2048'],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        // 2) load spreadsheet
        $path        = $request->file('file_penjualan')->getPathname();
        $reader      = IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($path);

        // Sheet pertama = header penjualan, sheet kedua = detail
        $sheetH = $spreadsheet->getSheet(0)->toArray(null, true, true, true);
        $sheetD = $spreadsheet->getSheet(1)->toArray(null, true, true, true);

        DB::beginTransaction();
        try {
            // Mengimport penjualan
            $mapKode = []; // [ penjualan_kode => penjualan_id ]
            foreach ($sheetH as $rowNum => $row) {
                if ($rowNum === 1) {
                    // anggap baris 1 adalah header kolom: skip
                    continue;
                }

                // baca kolom A:D sesuai template:
                $userId  = intval($row['A'] ?? 0);
                $pembeli = trim($row['B']  ?? '');
                $kode    = trim($row['C']  ?? '');
                $tgl     = trim($row['D']  ?? '');

                // jika salah satu field wajib kosong, skip baris ini
                if (! $userId || $kode === '' || ! $tgl) {
                    continue;
                }

                // insert penjualan baru
                $p = PenjualanModel::create([
                    'user_id'           => $userId,
                    'pembeli'           => $pembeli,
                    'penjualan_kode'    => $kode,
                    'penjualan_tanggal' => date('Y-m-d H:i:s', strtotime($tgl)),
                ]);

                // simpan mapping untuk detail
                $mapKode[$kode] = $p->penjualan_id;
            }

            // Mengimport detail penjualan serta update stok di barang
            foreach ($sheetD as $rowNum => $row) {
                if ($rowNum === 1) {
                    // skip header kolom
                    continue;
                }

                $kode      = trim($row['A'] ?? '');
                $barangId  = intval($row['B'] ?? 0);
                $jumlah    = intval($row['C'] ?? 0);
                $harga     = floatval($row['D'] ?? 0);

                // pastikan header dengan kode ini sudah di‐import
                if (! isset($mapKode[$kode])) {
                    throw new \Exception("Header penjualan kode “{$kode}” tidak ditemukan (baris {$rowNum}).");
                }
                $penjualanId = $mapKode[$kode];

                // cek & kurangi stok di BarangModel
                $barang = BarangModel::find($barangId);
                if (! $barang) {
                    throw new \Exception("Barang dengan ID {$barangId} tidak ditemukan (baris {$rowNum}).");
                }
                if ($barang->stok < $jumlah) {
                    throw new \Exception("Stok tidak mencukupi untuk barang “{$barang->barang_nama}” (baris {$rowNum}).");
                }
                // kurangi stok
                $barang->decrement('stok', $jumlah);

                // simpan detail
                PenjualanDetailModel::create([
                    'penjualan_id' => $penjualanId,
                    'barang_id'    => $barangId,
                    'jumlah'       => $jumlah,
                    'harga'        => $harga,
                ]);
            }

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Import berhasil: data penjualan & detail tersimpan.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => 'Import gagal: ' . $e->getMessage()
            ]);
        }
    }
    public function export_excel()
    {
        // Ambil semua penjualan beserta relasi user dan detail->barang
        $penjualans = PenjualanModel::with(['user', 'detailPenjualan.barang'])
            ->orderBy('penjualan_tanggal')
            ->get();

        // Buat objek spreadsheet dan sheet pertama
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle(' Penjualan');

        // Header untuk sheet Master
        $sheet1->setCellValue('A1', 'No');
        $sheet1->setCellValue('B1', 'Nama Kasir');
        $sheet1->setCellValue('C1', 'Pembeli');
        $sheet1->setCellValue('D1', 'Kode Transaksi');
        $sheet1->setCellValue('E1', 'Tanggal Penjualan');
        $sheet1->getStyle('A1:E1')->getFont()->setBold(true);

        // Isi data master
        $row = 2;
        $no = 1;
        foreach ($penjualans as $penjualan) {
            $sheet1->setCellValue("A{$row}", $no);
            $sheet1->setCellValue("B{$row}", $penjualan->user->nama);
            $sheet1->setCellValue("C{$row}", $penjualan->pembeli);
            $sheet1->setCellValue("D{$row}", $penjualan->penjualan_kode);
            $sheet1->setCellValue("E{$row}", date('Y-m-d H:i:s', strtotime($penjualan->penjualan_tanggal)));
            $no++;
            $row++;
        }

        // Auto‑size kolom sheet1
        foreach (range('A','E') as $col) {
            $sheet1->getColumnDimension($col)->setAutoSize(true);
        }

        // Buat sheet kedua untuk detail
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Detail Penjualan');

        // Header untuk sheet Detail
        $sheet2->setCellValue('A1', 'No');
        $sheet2->setCellValue('B1', 'Kode Transaksi');
        $sheet2->setCellValue('C1', 'Nama Barang');
        $sheet2->setCellValue('D1', 'Jumlah');
        $sheet2->setCellValue('E1', 'Total Harga');
        $sheet2->getStyle('A1:E1')->getFont()->setBold(true);

        // Isi data detail
        $row = 2;
        $no = 1;
        foreach ($penjualans as $penjualan) {
            foreach ($penjualan->detailPenjualan as $detail) {
                $sheet2->setCellValue("A{$row}", $no);
                $sheet2->setCellValue("B{$row}", $penjualan->penjualan_kode);
                $sheet2->setCellValue("C{$row}", $detail->barang->barang_nama);
                $sheet2->setCellValue("D{$row}", $detail->jumlah);
                $sheet2->setCellValue("E{$row}", $detail->harga);
                $no++;
                $row++;
            }
        }

        // Auto‑size kolom sheet2
        foreach (range('A','E') as $col) {
            $sheet2->getColumnDimension($col)->setAutoSize(true);
        }

        // Kirim header untuk download
        $writer   = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data_Penjualan_Detail_' . date('Y-m-d_H-i-s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. $filename .'"');
        header('Cache-Control: max-age=0');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: '. gmdate('D, d M Y H:i:s') .' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }
    public function export_pdf()
    {
        $penjualan = PenjualanModel::with(['user', 'detailPenjualan'])
            ->orderBy('penjualan_id')
            ->orderBy('penjualan_kode')
            ->get();


        $pdf = PDF::loadView('penjualan.export_pdf', ['penjualan' => $penjualan]);
        $pdf->setPaper('A4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url
        $pdf->render(); // render pdf

        return $pdf->stream('Data Supplier ' . date('Y-m-d H-i-s') . '.pdf');
    }
}
