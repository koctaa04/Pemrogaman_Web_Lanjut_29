
<div id="modal-master" class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Data Supplier</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            @empty($supplier)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>Kode Supplier</th>
                        <td>{{ $supplier->supplier_kode }}</td>
                    </tr>
                    <tr>
                        <th>Nama Supplier</th>
                        <td>{{ $supplier->supplier_nama }}</td>
                    </tr>
                    <tr>
                        <th>Alamat Supplier</th>
                        <td>{{ $supplier->supplier_alamat }}</td>
                    </tr>
                </table>
            @endempty
        </div>
    </div>
</div>