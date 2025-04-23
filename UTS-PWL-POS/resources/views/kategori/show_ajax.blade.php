
<div id="modal-master" class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Data Kategori</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            @empty($kategori)
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                Data yang Anda cari tidak ditemukan.
            </div>
        @else
            <table class="table table-bordered table-striped table-hover table-sm">
                <tr>
                    <th>ID</th>
                    <td>{{ $kategori->kategori_id }}</td>
                </tr>
                <tr>
                    <th>Kode</th>
                    <td>{{ $kategori->kategori_kode }}</td>
                </tr>
                <tr>
                    <th>Nama</th>
                    <td>{{ $kategori->kategori_nama }}</td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td>{{ $kategori->deskripsi }}</td>
                </tr>
            </table>
        @endempty
        </div>
    </div>
</div>