<?php

namespace App\Http\Controllers;

use App\Models\StokModel;
use App\Models\UserModel;
use App\Models\BarangModel;
use Illuminate\Http\Request;
use App\Models\SupplierModel;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Shared\Date;
        use Barryvdh\DomPDF\Facade\Pdf;

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
            $data['user_id'] = auth()->user()->user_id;
            
            // Simpan data stok
            StokModel::create($data);

            // Update stok di tabel m_barang
            $barang = BarangModel::find($data['barang_id']);
            $barang->stok += $data['stok_jumlah'];

            $barang->save();

            return response()->json([
                'status'  => true,
                'message' => 'Data stok berhasil disimpan.',
            ]);
        }


        return redirect('/');
    }

    // Form edit data stok
    public function edit_ajax(string $id)
    {
        $stok = StokModel::find($id);
        $barang = BarangModel::select('barang_id', 'barang_nama')->get();
        $user = UserModel::select('user_id', 'nama')->get();
        $supplier = SupplierModel::select('supplier_id', 'supplier_nama')->get(); // Ambil daftar supplier

        return view('stok.edit_ajax', [
            'stok' => $stok,
            'barang' => $barang,
            'user' => $user,
            'supplier' => $supplier,
        ]);
    }

    // Update data stok
    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'barang_id'    => 'required|integer|exists:m_barang,barang_id',
                'user_id'      => 'required|integer|exists:m_user,user_id',
                'supplier_id'  => 'required|integer|exists:m_supplier,supplier_id', // Tambahkan validasi supplier
                'stok_tanggal' => 'required|date', 
                'stok_jumlah'  => 'required|integer|min:1',
            ];

            $validator = Validator::make($request->all(), $rules);


            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi gagal.',
                    'msgField' => $validator->errors(),
                ]);
            }

            $stok = StokModel::find($id);
            $barang = BarangModel::find($request->barang_id);
    
            // Hitung selisih stok
            $stokLama = $stok->stok_jumlah;
            $stokBaru = $request->stok_jumlah;
            $selisih = $stokBaru - $stokLama;
    
            // Update stok di tabel m_barang
            $barang->stok += $selisih;
            $barang->save();
    
            // Update data stok
            $stok->update([
                'stok_jumlah'  => $stokBaru,
                'stok_tanggal' => $request->stok_tanggal,
                'barang_id'    => $request->barang_id,
                'supplier_id'  => $request->supplier_id,
                'user_id'      => auth()->user()->user_id,
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Data stok berhasil diperbarui dan stok barang disesuaikan.',
            ]);
        }

        return redirect('/');
    }
    public function confirm_ajax(string $id)
    {
        $stok = StokModel::find($id);

        return view('stok.confirm_ajax', ['stok' => $stok]);
    }
    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $stok = StokModel::find($id);

            if ($stok) {
                $stok->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'Data stok berhasil dihapus.',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan.',
                ]);
            }
        }

        return redirect('/');
    }

    
    public function import(){
        return view('stok.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {

            $rules = [
                // Validasi file harus xlsx, maksimal 1MB
                'file_stok' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            // Ambil file dari request
            $file = $request->file('file_stok');

            // Membuat reader untuk file excel dengan format Xlsx
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true); // Hanya membaca data saja

            $path = $file->getPathname();
            $spreadsheet = $reader->load($path);
            $sheet = $spreadsheet->getActiveSheet();

            // Ambil data excel sebagai array
            $data = $sheet->toArray(null, false, true, true);
            $insert = [];
             if (count($data) > 1) { // Jika data lebih dari 1 baris
                foreach ($data as $baris => $value) {
                    if ($baris > 1) { // Baris ke-1 adalah header, maka lewati

                        $tanggal_masuk = is_numeric($value['D'])
                        ? Date::excelToDateTimeObject($value['D'])->format('Y-m-d')
                        : date('Y-m-d', strtotime($value['D']));


                        $insert[] = [
                            'barang_id'           => $value['A'],
                            'user_id'             => $value['B'],
                            'supplier_id'         => $value['C'],
                            'stok_tanggal'  => $tanggal_masuk,
                            'stok_jumlah'         => $value['E'],
                            'created_at'           => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    // Insert data ke database, jika data sudah ada, maka diabaikan
                    StokModel::insertOrIgnore($insert);
                }

                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil diimport'
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Tidak ada data yang diimport'
                ]);
            }
        }

        return redirect('/');
    }

    public function export_excel()
    {
        //Ambil value stok yang akan diexport
        $stok = StokModel::select(
            'barang_id',
            'user_id',
            'supplier_id',
            'stok_tanggal',
            'stok_jumlah'
        )
        ->orderBy('stok_id')
        ->with(['barang', 'user', 'supplier'])
        ->get();

        //load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); //ambil sheet aktif

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Barang');
        $sheet->setCellValue('C1', 'Nama User');
        $sheet->setCellValue('D1', 'Nama Supplier');
        $sheet->setCellValue('E1', 'Tanggal Stok');
        $sheet->setCellValue('F1', 'Jumlah Stok');

        $sheet->getStyle('A1:F1')->getFont()->setBold(true); // Set header bold

        $no = 1; //Nomor value dimulai dari 1
        $baris = 2; //Baris value dimulai dari 2
        foreach ($stok as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->barang->barang_nama);
            $sheet->setCellValue('C' . $baris, $value->user->nama);
            $sheet->setCellValue('D' . $baris, $value->supplier->supplier_nama);
            $sheet->setCellValue('E' . $baris, $value->stok_tanggal);
            $sheet->setCellValue('F' . $baris, $value->stok_jumlah);
            $no++;
            $baris++;
        }

        foreach (range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); //set auto size untuk kolom
        }

        $sheet->setTitle('Data Stock Barang'); //set judul sheet
        $writer = IOFactory ::createWriter($spreadsheet, 'Xlsx'); //set writer
        $filename = 'Data_Stock_Barang_' . date('Y-m-d_H-i-s') . '.xlsx'; //set nama file

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output'); //simpan file ke output
        exit; //keluar dari scriptA
    }

    public function export_pdf(){
        $stok = StokModel::select(
            'barang_id',
            'user_id',
            'supplier_id',
            'stok_tanggal',
            'stok_jumlah'
        )
        ->orderBy('barang_id')
        ->orderBy('stok_tanggal')
        ->with(['barang', 'user', 'supplier'])
        ->get();

        $pdf = PDF::loadView('stok.export_pdf', ['stok' => $stok]);
        $pdf->setPaper('A4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url
        $pdf->render(); // render pdf

        return $pdf->stream('Data Stock Barang '.date('Y-m-d H-i-s').'.pdf');
    }
}
