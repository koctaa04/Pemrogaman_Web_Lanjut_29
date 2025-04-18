<form id="formEdit" method="POST">
  @csrf
  @method('PUT')
  <div class="form-group">
      <label for="pembeli">Pembeli</label>
      <input type="text" class="form-control" name="pembeli" value="{{ $penjualan->pembeli }}">
  </div>

  <div class="form-group">
      <label for="penjualan_tanggal">Tanggal</label>
      <input type="date" class="form-control" name="penjualan_tanggal" value="{{ $penjualan->penjualan_tanggal }}">
  </div>

  <h5>Detail Barang</h5>
  <table class="table table-bordered" id="table-barang">
      <thead>
          <tr>
              <th>Barang</th>
              <th>Jumlah</th>
              <th>Harga</th>
              <th><button type="button" class="btn btn-sm btn-success" id="tambah-barang">+</button></th>
          </tr>
      </thead>
      <tbody>
          @foreach ($penjualan->detailPenjualan as $detail)
          <tr>
              <td>
                  <select name="barang_id[]" class="form-control barang-select">
                      @foreach ($barang as $b)
                      <option value="{{ $b->barang_id }}" data-harga="{{ $b->harga }}" {{ $detail->barang_id == $b->barang_id ? 'selected' : '' }}>
                          {{ $b->nama_barang }}
                      </option>
                      @endforeach
                  </select>
              </td>
              <td><input type="number" name="jumlah[]" class="form-control" value="{{ $detail->jumlah }}"></td>
              <td><input type="number" name="harga[]" class="form-control harga" value="{{ $detail->harga }}" readonly></td>
              <td><button type="button" class="btn btn-sm btn-danger btn-hapus">x</button></td>
          </tr>
          @endforeach
      </tbody>
  </table>

  <button type="submit" class="btn btn-primary">Simpan</button>
</form>

<script>
  $(document).ready(function () {
      // Update harga otomatis saat barang berubah
      $(document).on('change', '.barang-select', function () {
          const harga = $(this).find('option:selected').data('harga');
          $(this).closest('tr').find('.harga').val(harga);
      });

      // Tambah baris barang
      $('#tambah-barang').click(function () {
          const row = `
          <tr>
              <td>
                  <select name="barang_id[]" class="form-control barang-select">
                      @foreach ($barang as $b)
                      <option value="{{ $b->barang_id }}" data-harga="{{ $b->harga }}">{{ $b->nama_barang }}</option>
                      @endforeach
                  </select>
              </td>
              <td><input type="number" name="jumlah[]" class="form-control"></td>
              <td><input type="number" name="harga[]" class="form-control harga" readonly></td>
              <td><button type="button" class="btn btn-sm btn-danger btn-hapus">x</button></td>
          </tr>`;
          $('#table-barang tbody').append(row);
      });

      // Hapus baris
      $(document).on('click', '.btn-hapus', function () {
          $(this).closest('tr').remove();
      });

      // Submit form via AJAX
      $('#formEdit').submit(function (e) {
          e.preventDefault();
          const formData = $(this).serialize();
          $.ajax({
              url: '{{ url("penjualan/update-ajax/" . $penjualan->penjualan_id) }}',
              type: 'POST',
              data: formData,
              success: function (res) {
                  if (res.status) {
                      alert(res.message);
                      $('#modalEdit').modal('hide');
                      $('#datatable').DataTable().ajax.reload();
                  } else {
                      alert(res.message);
                  }
              },
              error: function (xhr) {
                  console.error(xhr.responseText);
              }
          });
      });
  });
</script>
