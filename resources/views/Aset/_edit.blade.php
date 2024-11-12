<form action="{{ route('aset.update', ['uuid' => $aset->id]) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row mb-3">
        <div class="col-md-6">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" value="{{ $aset->nama_barang }}">
        </div>
        <div class="col-md-6">
            <label>Jenis</label>
            <input type="text" name="jenis" class="form-control" value="{{ $aset->jenis }}">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label>Serial Number</label>
            <input type="text" name="serial_number" class="form-control" value="{{ $aset->serial_number }}">
        </div>
        <div class="col-md-6">
            <label>Part Number</label>
            <input type="text" name="part_number" class="form-control" value="{{ $aset->part_number }}">
        </div>
        <div class="col-md-6">
            <label>Pengguna</label>
            <input type="text" name="pengguna" class="form-control" value="{{ $aset->pengguna }}">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <label>Spesifikasi</label>
            <textarea name="spek" class="form-control" rows="3">{{ $aset->spek }}</textarea>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label>Tahun Kepemilikan</label>
            <input type="number" name="tahun_kepemilikan" class="form-control" value="{{ $aset->tahun_kepemilikan }}">
        </div>
        <div class="col-md-6">
            <label>Kepemilikan</label>
            <select name="id_kepemilikan" class="form-control">
                @foreach($kepemilikan as $kepemilikan)
                    <option value="{{ $kepemilikan->id }}" {{ $aset->id_kepemilikan == $kepemilikan->id ? 'selected' : '' }}>
                        {{ $kepemilikan->kepemilikan }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <hr>
    <div class="text-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </div>
</form>