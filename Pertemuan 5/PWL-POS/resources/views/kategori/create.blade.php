@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', 'kategori')
@section('content_header_title', 'Kategori')
@section('content_header_subtitle', 'create')

{{-- Content body: main page content --}}
@section('content')
    <div class="container">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Form Tambah Data Kategori</h3>
            </div>
            <form action="../kategori" method="post">
                <div class="card-body">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="kategori_id">ID Kategori</label>
                        <input type="number" name="kategori_id" id="kategori_id" placeholder="Masukkan ID Kategori">
                    </div>
                    <div class="form-group">
                        <label for="kategori_nama">Kode Kategori</label>
                        <input type="text" name="kategori_nama" id="kategori_nama" placeholder="Masukkan Nama Kategori">
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
