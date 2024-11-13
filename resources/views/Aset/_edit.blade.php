<form action="{{ route('aset.update', ['uuid' => $aset->id]) }}" method="POST" class="p-4">
    @csrf
    @method('PUT')
    <div class="row g-4">
        <!-- Basic Information -->
        <div class="col-md-6">
            <div class="form-floating">
                <input type="text" name="nama_barang" class="form-control" id="nama_barang" value="{{ $aset->nama_barang }}" placeholder="Nama Barang">
                <label for="nama_barang">Nama Barang</label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-floating">
                <input type="text" name="jenis" class="form-control" id="jenis" value="{{ $aset->jenis }}" placeholder="Jenis">
                <label for="jenis">Jenis</label>
            </div>
        </div>
        
        <!-- Numbers Section -->
        <div class="col-md-6">
            <div class="form-floating">
                <input type="text" name="serial_number" class="form-control" id="serial_number" value="{{ $aset->serial_number }}" placeholder="Serial Number">
                <label for="serial_number">Serial Number</label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-floating">
                <input type="text" name="part_number" class="form-control" id="part_number" value="{{ $aset->part_number }}" placeholder="Part Number">
                <label for="part_number">Part Number</label>
            </div>
        </div>
        
        <!-- User Information -->
        <div class="col-md-6">
            <div class="form-floating">
                <input type="text" name="pengguna" class="form-control" id="pengguna" value="{{ $aset->pengguna }}" placeholder="Pengguna">
                <label for="pengguna">Pengguna</label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-floating">
                <input type="number" name="tahun_kepemilikan" class="form-control" id="tahun_kepemilikan" value="{{ $aset->tahun_kepemilikan }}" placeholder="Tahun Kepemilikan">
                <label for="tahun_kepemilikan">Tahun Kepemilikan</label>
            </div>
        </div>
        
        <!-- Ownership -->
        <div class="col-md-12">
            <div class="form-floating">
                <select name="id_kepemilikan" class="form-select" id="id_kepemilikan">
                    @foreach($kepemilikan as $kepemilikan)
                        <option value="{{ $kepemilikan->id }}" {{ $aset->id_kepemilikan == $kepemilikan->id ? 'selected' : '' }}>
                            {{ $kepemilikan->kepemilikan }}
                        </option>
                    @endforeach
                </select>
                <label for="id_kepemilikan">Kepemilikan</label>
            </div>
        </div>
        
        <!-- Specifications -->
        <div class="col-12">
            <div class="form-floating">
                <textarea name="spek" class="form-control" id="spek" style="height: 100px" placeholder="Spesifikasi">{{ $aset->spek }}</textarea>
                <label for="spek">Spesifikasi</label>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="d-flex justify-content-end gap-2 mt-4">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>Tutup
        </button>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i>Simpan Perubahan
        </button>
    </div>
</form>