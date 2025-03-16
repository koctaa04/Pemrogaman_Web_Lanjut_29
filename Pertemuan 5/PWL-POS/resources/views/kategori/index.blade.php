@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'kategori')
@section('content_header_title', 'Data Kategori')
@section('content_header_subtitle', 'kategori')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h3 class="mb-0">Manage Kategori</h3>
                <a href="{{ route('kategori.create') }}" class="btn btn-primary ms-auto">Add</a>
            </div>
    
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush