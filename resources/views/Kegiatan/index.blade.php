<!-- resources/views/kegiatan/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Kegiatan Aset {{ $aset->jenis }} {{ $aset->nama_barang }}</h4>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createKegiatanModal">
                    Tambah Kegiatan
                </button>
            </div>
            <div class="card-body">
                <!-- Asset Details -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Jenis:</strong> {{ $aset->jenis }}
                    </div>
                    <div class="col-md-4">
                        <strong>Nama Barang:</strong> {{ $aset->nama_barang }}
                    </div>
                    <div class="col-md-4">
                        <strong>Serial Number:</strong> {{ $aset->serial_number }}
                    </div>
                </div>
                <!-- ... (bagian detail aset lainnya tetap sama) ... -->

                <!-- Kegiatan Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Kegiatan</th>
                                <th>Petugas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kegiatan as $index => $k)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $k->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        @if ($k->masterKegiatan->is_custom)
                                            {{ $k->custom_kegiatan }}
                                        @else
                                            {{ $k->masterKegiatan->kegiatan }}
                                        @endif
                                    </td>
                                    <td>{{ $k->user->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Kegiatan Modal -->
    <div class="modal fade" id="createKegiatanModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('kegiatan.store', $aset->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="id_master_kegiatan" class="form-label">Kegiatan</label>
                            <select class="form-select @error('id_master_kegiatan') is-invalid @enderror"
                                id="id_master_kegiatan" name="id_master_kegiatan" required>
                                <option value="">Pilih Kegiatan</option>
                                @foreach ($masterKegiatan as $mKegiatan)
                                    <option value="{{ $mKegiatan->id }}" data-is-custom="{{ $mKegiatan->is_custom }}">
                                        {{ $mKegiatan->kegiatan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_master_kegiatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3" id="customKegiatanDiv" style="display: none;">
                            <label for="custom_kegiatan" class="form-label">Deskripsi Kegiatan</label>
                            <textarea class="form-control @error('custom_kegiatan') is-invalid @enderror" id="custom_kegiatan"
                                name="custom_kegiatan" rows="3"></textarea>
                            @error('custom_kegiatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const masterKegiatanSelect = document.getElementById('id_master_kegiatan');
                const customKegiatanDiv = document.getElementById('customKegiatanDiv');
                const customKegiatanTextarea = document.getElementById('custom_kegiatan');
                const form = document.querySelector('form');

                masterKegiatanSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const isCustom = selectedOption.dataset.isCustom === '1';

                    customKegiatanDiv.style.display = isCustom ? 'block' : 'none';
                    customKegiatanTextarea.required = isCustom;

                    if (!isCustom) {
                        customKegiatanTextarea.value = ''; // Clear the textarea if not custom
                    }
                });

                // Validate form before submit
                form.addEventListener('submit', function(e) {
                    const selectedOption = masterKegiatanSelect.options[masterKegiatanSelect.selectedIndex];
                    const isCustom = selectedOption.dataset.isCustom === '1';

                    if (isCustom && !customKegiatanTextarea.value.trim()) {
                        e.preventDefault();
                        alert('Silakan isi deskripsi kegiatan untuk opsi Lainnya');
                        customKegiatanTextarea.focus();
                    }
                });
            });
        </script>
    @endpush
@endsection
