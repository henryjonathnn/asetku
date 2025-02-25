{{-- _edit.blade.php --}}
<style>
    .form-floating {
        position: relative;
    }

    .input-icon {
        position: absolute;
        top: 50%;
        right: 10px;
        /* Adjust to position icon */
        transform: translateY(-50%);
        color: #007bff;
        /* Change to your preferred color */
    }

    .form-control {
        padding-right: 30px;
        /* Make space for the icon */
    }
</style>
<form action="{{ route('aset.update', ['uuid' => $aset->id]) }}" method="POST" enctype="multipart/form-data"
    class="p-4">
    @csrf
    @method('PUT')
    <div class="modal-body">
        <div class="row g-4">
            <!-- Basic Information -->
            <div class="col-12">
                <h6 class="text-primary mb-3">Informasi Dasar</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="nama_barang" class="form-control" id="editNamaBarang"
                                value="{{ $aset->nama_barang }}" required placeholder="Nama Barang">
                            <label for="editNamaBarang">Nama Barang</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select name="id_master_jenis" class="form-select" id="editJenis" required>
                                <option value="">Pilih Jenis</option>
                                @foreach ($jenis as $j)
                                    <option value="{{ $j->id }}"
                                        {{ $aset->id_master_jenis == $j->id ? 'selected' : '' }}>
                                        {{ $j->jenis }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="editJenis">Jenis</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Numbers Section -->
            <div class="col-12">
                <h6 class="text-primary mb-3">Nomor Identifikasi</h6>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" name="nomor_aset" class="form-control" id="editNomorAset"
                                value="{{ $aset->nomor_aset }}" required placeholder="Nomor Aset">
                            <label for="editNomorAset">Nomor Aset</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" name="serial_number" class="form-control" id="editSerialNumber"
                                value="{{ $aset->serial_number }}" required placeholder="Serial Number">
                            <label for="editSerialNumber">Serial Number</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" name="part_number" required class="form-control" id="editPartNumber"
                                value="{{ $aset->part_number }}" placeholder="Part Number">
                            <label for="editPartNumber">Part Number</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Specifications & Status -->
            <div class="col-12">
                <h6 class="text-primary mb-3">Spesifikasi & Status</h6>
                <div class="row g-3">
                    <div class="col-md-8">
                        <div class="form-floating">
                            <textarea name="spek" class="form-control" id="editSpek" style="height: 100px" required placeholder="Spesifikasi">{{ $aset->spek }}</textarea>
                            <label for="editSpek">Spesifikasi</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <select name="status" required class="form-select" id="editStatus">
                                @foreach (App\Models\Aset::getStatusOptions() as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ $aset->status == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="editStatus">Status</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="col-12">
                <h6 class="text-primary mb-3">Informasi Tambahan</h6>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="number" id="editTahun" name="tahun_kepemilikan" class="form-control"
                                data-bs-toggle="modal" data-bs-target="#yearSelectorModal"
                                value="{{ $aset->tahun_kepemilikan ?? now()->year }}" readonly>
                            <label for="editTahun">Tahun Kepemilikan</label>
                            <div class="input-icon">
                                <i class="fas fa-calendar"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" name="pengguna" class="form-control" id="editPengguna"
                                value="{{ $aset->pengguna }}" required placeholder="Pengguna">
                            <label for="editPengguna">Pengguna</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <select name="id_kepemilikan" class="form-select" id="editKepemilikan" required>
                                <option value="">Pilih Kepemilikan</option>
                                @foreach ($kepemilikan as $k)
                                    <option value="{{ $k->id }}"
                                        {{ $aset->id_kepemilikan == $k->id ? 'selected' : '' }}>
                                        {{ $k->kepemilikan }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="editKepemilikan">Kepemilikan</label>
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" name="lokasi" class="form-control" id="editLokasi"
                                    value="{{ $aset->lokasi }}" placeholder="Lokasi">
                                <label for="editLokasi">Lokasi</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="file" name="foto_aset" class="form-control" id="editFotoAset"
                                    placeholder="Foto Aset" accept="image/*">
                                <label for="editFotoAset">Foto Aset</label>
                                @if ($aset->foto_aset)
                                    <div class="mt-2 text-center">
                                        <img src="{{ asset('storage/' . $aset->foto_aset) }}"
                                            alt="Current Asset Photo" class="img-thumbnail float-end"
                                            style="max-width: 150px; max-height: 150px; object-fit: cover;">
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>
