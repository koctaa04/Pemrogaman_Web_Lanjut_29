@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'welcome')


{{-- Content body: main page content --}}

@section('content_body')
    <p>Ini adalah halaman welcome</p>
@stop

{{-- Push Extra CSS --}}

@push('css')
    <style type="text/css">
        {{-- You can add AdminLTE customizations here --}}
        /*
         .card-header {
         border-bottom: none;
         }
         .card-title {
         font-weight: 600;
         }
         */
    </style>
@endpush

{{-- Push Extra JS --}}

@push('js')
    <script type="text/javascript">
        {{-- You can add AdminLTE customizations here --}}
    </script>
@endpush