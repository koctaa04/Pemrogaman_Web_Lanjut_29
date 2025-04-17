@extends('layouts.template') @section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"> <button onclick="modalAction('{{ url('/penjualan/create_ajax') }}')"
                    class="btn btn-sm btn-success mt-1 mr-4">Tambah Data</button> </div>
        </div>
        <div class="card-body"> {{-- Alerts --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            {{-- Filter --}}
            <div class="row mb-3">
                <div class="col-3">
                    <select class="form-control" id="user_id" name="user_id">
                        <option value="">- Semua Penjual -</option>
                        @foreach ($user as $item)
                            <option value="{{ $item->user_id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Penjual</small>
                </div>
                <div class="col-3">
                    <select class="form-control" id="barang_id" name="barang_id">
                        <option value="">- Semua Barang -</option>
                        @foreach ($barang as $item)
                            <option value="{{ $item->barang_id }}">{{ $item->barang_nama }}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Barang</small>
                </div>
            </div>

            {{-- Table --}}
            <table class="table table-bordered table-striped table-sm" id="table_penjualan">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Transaksi</th>
                        <th>Pembeli</th>
                        <th>Tanggal</th>
                        <th>Penjual</th>
                        <th>Nama Barang</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }
        $(document).ready(function() {
            var table = $('#table_penjualan').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('penjualan/list') }}",
                    type: "POST",
                    data: function(d) {
                        d.user_id = $('#user_id').val();
                        d.barang_id = $('#barang_id').val();
                    }
                },
                columns: [{
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "penjualan_kode"
                    },
                    {
                        data: "pembeli"
                    },
                    {
                        data: "penjualan_tanggal"
                    },
                    {
                        data: "user_nama"
                    },
                    {
                        data: "barang_nama"
                    },
                    {
                        data: "total_harga",
                        className: "text-end"
                    },
                    {
                        data: "aksi",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                ]
            });
            $('#user_id, #barang_id').on('change', function() {
                table.ajax.reload();
            });
        });
    </script>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endpush
