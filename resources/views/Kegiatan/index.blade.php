@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Detail Aset & Kegiatan</h4>
            </div>
            <button type="button" class="btn btn-success d-flex align-items-center gap-2" data-bs-toggle="modal"
                data-bs-target="#createKegiatanModal">
                <i class="fas fa-plus"></i>
                <span>Tambah Kegiatan</span>
            </button>
        </div>

        <!-- Asset Details Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Informasi Aset</h5>
                <button type="button" class="btn btn-primary btn-sm d-flex align-items-center gap-2" data-bs-toggle="modal"
                    data-bs-target="#editAssetModal">
                    <i class="fas fa-edit"></i>
                    <span>Edit Data Master</span>
                </button>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <!-- Basic Information -->
                    <div class="col-md-6">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="d-flex flex-column">
                                    <span class="text-muted small">Jenis Aset</span>
                                    <span class="fw-medium">{{ $aset->jenis->jenis ?? '-' }}</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex flex-column">
                                    <span class="text-muted small">Nama Barang</span>
                                    <span class="fw-medium">{{ $aset->nama_barang ?? '-' }}</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex flex-column">
                                    <span class="text-muted small">Nomor Aset</span>
                                    <span class="fw-medium">{{ $aset->nomor_aset ?? '-' }}</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex flex-column">
                                    <span class="text-muted small">Serial Number</span>
                                    <span class="fw-medium">{{ $aset->serial_number ?? '-' }}</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex flex-column">
                                    <span class="text-muted small">Kepemilikan</span>
                                    <span class="fw-medium">{{ $aset->kepemilikan->kepemilikan ?? '-' }}</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex flex-column">
                                    <span class="text-muted small">Status Aset</span>
                                    <span class="fw-medium">{{ $aset->status_formatted }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="col-md-6">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="d-flex flex-column">
                                    <span class="text-muted small">Pengguna</span>
                                    <span class="fw-medium">{{ $aset->pengguna ?? '-' }}</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex flex-column">
                                    <span class="text-muted small">Tahun Kepemilikan</span>
                                    <span class="fw-medium">{{ $aset->tahun_kepemilikan ?? '-' }}</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex flex-column">
                                    <span class="text-muted small">Part Number</span>
                                    <span class="fw-medium">{{ $aset->part_number ?? '-' }}</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex flex-column">
                                    <span class="text-muted small">Total Kegiatan</span>
                                    <span class="fw-medium">{{ $kegiatan->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Specifications -->
                    <div class="col-12">
                        <div class="p-3 bg-light rounded-3">
                            <div class="text-muted small mb-1">Spesifikasi</div>
                            <div class="fw-semibold">{{ $aset->spek ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activities Card -->
        <div class="card shadow-sm">
            <div class="card-header bg-light py-3">
                <h5 class="mb-0">Riwayat Kegiatan</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 ps-4">No</th>
                                <th class="border-0">Tanggal</th>
                                <th class="border-0">Kegiatan</th>
                                <th class="border-0">PIC</th>
                                <th class="border-0">Foto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kegiatan as $index => $k)
                                <tr>
                                    <td class="ps-4">{{ $loop->iteration }}</td>
                                    <td>{{ $k->created_at->format('d M Y, H:i') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="bg-light rounded p-1">
                                                <i class="fas fa-tools text-primary"></i>
                                            </div>
                                            <div>
                                                @if ($k->masterKegiatan->is_custom)
                                                    <span class="d-block fw-medium">Kegiatan Lainnya</span>
                                                    <small class="text-muted">{{ $k->custom_kegiatan }}</small>
                                                @else
                                                    <span class="fw-medium">{{ $k->masterKegiatan->kegiatan }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="bg-light rounded-circle p-1">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                            <span>{{ $k->user->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($k->foto)
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#photoModal-{{ $k->id }}">
                                                <i class="fas fa-image me-1"></i>Lihat Foto
                                            </button>

                                            <!-- Modal for this photo -->
                                            <div class="modal fade" id="photoModal-{{ $k->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header border-0 pb-0">
                                                            <h5 class="modal-title">Foto Kegiatan</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <img src="{{ asset('storage/' . $k->foto) }}"
                                                                alt="Foto Kegiatan" class="img-fluid rounded">
                                                        </div>
                                                        <div class="modal-footer border-0">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="5" style="height: 100px;">
                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                            <div class="bg-light rounded-circle p-1">
                                                <i class="fas fa-info-circle me-2"></i>
                                            </div>
                                            <span>Belum Ada Riwayat Kegiatan</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($kegiatan->hasPages())
                    <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">
                        <div class="text-muted small">
                            Menampilkan {{ $kegiatan->firstItem() ?? 0 }} - {{ $kegiatan->lastItem() ?? 0 }} dari
                            {{ $kegiatan->total() ?? 0 }} kegiatan
                        </div>
                        {{ $kegiatan->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Create Kegiatan Modal -->
    <div class="modal fade" id="createKegiatanModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title">Tambah Kegiatan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('kegiatan.store', $aset->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="username" name="username" required
                                        placeholder="Username">
                                    <label for="username">Username</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="password" name="password" required
                                        placeholder="Password">
                                    <label for="password">Password</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <select class="form-select @error('id_master_kegiatan') is-invalid @enderror"
                                        id="id_master_kegiatan" name="id_master_kegiatan" required>
                                        <option value="">Pilih Kegiatan</option>
                                        @foreach ($masterKegiatan as $mKegiatan)
                                            <option value="{{ $mKegiatan->id }}"
                                                data-is-custom="{{ $mKegiatan->is_custom }}">
                                                {{ $mKegiatan->kegiatan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="id_master_kegiatan">Jenis Kegiatan</label>
                                    @error('id_master_kegiatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12" id="customKegiatanDiv" style="display: none;">
                                <div class="form-floating">
                                    <textarea class="form-control @error('custom_kegiatan') is-invalid @enderror" id="custom_kegiatan"
                                        name="custom_kegiatan" style="height: 100px" placeholder="Deskripsi Kegiatan"></textarea>
                                    <label for="custom_kegiatan">Deskripsi Kegiatan</label>
                                    @error('custom_kegiatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="foto" class="form-label">Foto Kegiatan</label>
                                    <input type="file" class="form-control" id="foto" name="foto"
                                        accept="image/*" onchange="previewImage(this)">
                                    <div id="imagePreview" class="mt-2 d-none">
                                        <img src="" alt="Preview" class="img-fluid rounded"
                                            style="max-height: 200px">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Edit Asset Modal -->
    <div class="modal fade" id="editAssetModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title">Edit Data Aset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('kegiatan.update-master', $aset->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row g-3">
                            <!-- Credentials Section -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="username" name="username" required
                                        placeholder="Username">
                                    <label for="username">Username</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="password" name="password" required
                                        placeholder="Password">
                                    <label for="password">Password</label>
                                </div>
                            </div>

                            <!-- Asset Data Section -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="nama_barang" class="form-control" id="nama_barang"
                                        value="{{ $aset->nama_barang }}" placeholder="Nama Barang" required>
                                    <label for="nama_barang">Nama Barang</label>
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
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="nomor_aset" class="form-control" id="nomor_aset"
                                        value="{{ $aset->nomor_aset }}" placeholder="Serial Number" required>
                                    <label for="nomor_aset">Nomor Aset</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="serial_number" class="form-control" id="serial_number"
                                        value="{{ $aset->serial_number }}" placeholder="Serial Number" required>
                                    <label for="serial_number">Serial Number</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="part_number" class="form-control" id="part_number"
                                        value="{{ $aset->part_number }}" placeholder="Part Number" required>
                                    <label for="part_number">Part Number</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="pengguna" class="form-control" id="pengguna"
                                        value="{{ $aset->pengguna }}" placeholder="Pengguna" required>
                                    <label for="pengguna">Pengguna</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" name="tahun_kepemilikan" class="form-control"
                                        id="tahun_kepemilikan" value="{{ $aset->tahun_kepemilikan }}"
                                        placeholder="Tahun Kepemilikan" required>
                                    <label for="tahun_kepemilikan">Tahun Kepemilikan</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select name="status" class="form-select" id="editStatus">
                                        @foreach(App\Models\Aset::getStatusOptions() as $value => $label)
                                            <option value="{{ $value }}" {{ $aset->status == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="status">Jenis</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <select name="id_kepemilikan" class="form-select" id="id_kepemilikan" required>
                                        @foreach ($kepemilikan as $k)
                                            <option value="{{ $k->id }}"
                                                {{ $aset->id_kepemilikan == $k->id ? 'selected' : '' }}>
                                                {{ $k->kepemilikan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="id_kepemilikan">Kepemilikan</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea name="spek" class="form-control" id="spek" style="height: 100px" placeholder="Spesifikasi"
                                        required>{{ $aset->spek }}</textarea>
                                    <label for="spek">Spesifikasi</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    @push('scripts')
        <script>
            function previewImage(input) {
                const preview = document.querySelector('#imagePreview');
                const previewImg = preview.querySelector('img');

                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        preview.classList.remove('d-none');
                    }

                    reader.readAsDataURL(input.files[0]);
                } else {
                    previewImg.src = '';
                    preview.classList.add('d-none');
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                const masterKegiatanSelect = document.getElementById('id_master_kegiatan');
                const customKegiatanDiv = document.getElementById('customKegiatanDiv');
                const customKegiatanTextarea = document.getElementById('custom_kegiatan');
                const editAssetModal = new bootstrap.Modal(document.getElementById('editAssetModal'));
                const form = document.querySelector('form');

                masterKegiatanSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const isCustom = selectedOption.dataset.isCustom === '1';

                    customKegiatanDiv.style.display = isCustom ? 'block' : 'none';
                    customKegiatanTextarea.required = isCustom;

                    if (!isCustom) {
                        customKegiatanTextarea.value = '';
                    }
                });

                form.addEventListener('submit', function(e) {
                    const selectedOption = masterKegiatanSelect.options[masterKegiatanSelect.selectedIndex];
                    const isCustom = selectedOption.dataset.isCustom === '1';

                    if (isCustom && !customKegiatanTextarea.value.trim()) {
                        e.preventDefault();
                        alert('Silakan isi deskripsi kegiatan untuk opsi Lainnya');
                        customKegiatanTextarea.focus();
                    }
                });

                editAssetForm.addEventListener('submit', async function(e) {
                    e.preventDefault();

                    try {
                        const response = await fetch(this.action, {
                            method: 'POST',
                            body: new FormData(this),
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });

                        const data = await response.json();

                        if (response.ok) {
                            window.location.reload(); // Refresh page to show updated data
                        } else {
                            alert(data.message || 'Terjadi kesalahan saat memperbarui data.');
                        }
                    } catch (error) {
                        alert('Terjadi kesalahan saat memperbarui data.');
                    }
                });

                const createModal = document.getElementById('createKegiatanModal');
                createModal.addEventListener('hidden.bs.modal', function() {
                    const preview = document.querySelector('#imagePreview');
                    const previewImg = preview.querySelector('img');
                    const fileInput = document.querySelector('#foto');

                    previewImg.src = '';
                    preview.classList.add('d-none');
                    fileInput.value = '';
                });
            });
        </script>
    @endpush

    @push('styles')
        <style>
            .table> :not(caption)>*>* {
                padding: 1rem 0.75rem;
            }

            .badge {
                font-weight: 500;
                letter-spacing: 0.3px;
                padding: 0.35em 0.65em;
            }

            .pagination {
                margin-bottom: 0;
            }

            .modal-lg {
                max-width: 800px;
            }

            .modal img.img-fluid {
                max-height: 70vh;
                width: auto;
            }

            #imagePreview img {
                max-width: 100%;
                height: auto;
            }
        </style>
    @endpush
@endsection
