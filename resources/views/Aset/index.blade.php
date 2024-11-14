<!-- resources/views/aset/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Manajemen Aset</h4>
            </div>
            <button type="button" class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal"
                data-bs-target="#createAsetModal">
                <i class="fas fa-plus"></i>
                <span>Tambah Aset</span>
            </button>
        </div>

        {{-- <!-- Search and Filter Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row g-3">
                    <!-- Search -->
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0 ps-0" id="searchInput"
                                placeholder="Cari aset...">
                        </div>
                    </div>
                    <!-- Filter Jenis -->
                    <div class="col-md-3">
                        <select class="form-select" id="jenisFilter">
                            <option value="">Semua Jenis</option>
                        </select>
                    </div>
                    <!-- Filter Kepemilikan -->
                    <div class="col-md-3">
                        <select class="form-select" id="kepemilikanFilter">
                            <option value="">Semua Kepemilikan</option>
                            @foreach ($kepemilikan as $k)
                                <option value="{{ $k->id }}">{{ $k->kepemilikan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Export Button -->
                    <div class="col-md-2">
                        <button type="button"
                            class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center gap-2">
                            <i class="fas fa-download"></i>
                            <span>Export</span>
                        </button>
                    </div>
                </div>
            </div>
        </div> --}}

        <!-- Assets List Card -->
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr class="text-center">
                                <th class="border-0 ps-4">No</th>
                                <th class="border-0">ID Aset</th>
                                <th class="border-0">Jenis</th>
                                <th class="border-0">Nama Barang</th>
                                <th class="border-0">Pengguna</th>
                                <th class="border-0 rounded-end text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($aset as $index => $item)
                                <tr class="text-center">
                                    <td class="ps-4">
                                        <span class="fw-medium">{{ $loop->iteration }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-medium">{{ $item->id }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">{{ $item->jenis }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="bg-light rounded p-1">
                                                <i class="fas fa-box text-primary"></i>
                                            </div>
                                            <div>
                                                <span class="d-block fw-medium">{{ $item->nama_barang }}</span>
                                                <small class="text-muted">SN: {{ $item->serial_number }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="bg-light rounded-circle p-1">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                            <span>{{ $item->pengguna }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-1">
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#detailAsetModal" data-aset-id="{{ $item->id }}"
                                                onclick="loadAsetDetail('{{ $item->id }}')">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-warning text-white"
                                                data-bs-toggle="modal" data-bs-target="#editAsetModal"
                                                data-aset-id="{{ $item->id }}"
                                                onclick="loadAsetEdit('{{ $item->id }}')">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-info text-white"
                                                onclick="loadBarcode('{{ $item->id }}')">
                                                <i class="fas fa-qrcode"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">
                    <div class="text-muted small">
                        Menampilkan {{ $aset->firstItem() ?? 0 }} - {{ $aset->lastItem() ?? 0 }} dari
                        {{ $aset->total() ?? 0 }} aset
                    </div>
                    {{ $aset->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createAsetModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title">Tambah Aset Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('aset.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-4">
                            <!-- Basic Information -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="nama_barang" class="form-control" id="createNamaBarang"
                                        placeholder="Nama Barang">
                                    <label for="createNamaBarang">Nama Barang</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="jenis" class="form-control" id="createJenis"
                                        placeholder="Jenis">
                                    <label for="createJenis">Jenis</label>
                                </div>
                            </div>

                            <!-- Numbers -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="serial_number" class="form-control"
                                        id="createSerialNumber" placeholder="Serial Number">
                                    <label for="createSerialNumber">Serial Number</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="part_number" class="form-control" id="createPartNumber"
                                        placeholder="Part Number">
                                    <label for="createPartNumber">Part Number</label>
                                </div>
                            </div>

                            <!-- Specifications -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea name="spek" class="form-control" id="createSpek" style="height: 100px" placeholder="Spesifikasi"></textarea>
                                    <label for="createSpek">Spesifikasi</label>
                                </div>
                            </div>

                            <!-- Additional Info -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="number" name="tahun_kepemilikan" class="form-control" id="createTahun"
                                        placeholder="Tahun">
                                    <label for="createTahun">Tahun Kepemilikan</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" name="pengguna" class="form-control" id="createPengguna"
                                        placeholder="Pengguna">
                                    <label for="createPengguna">Pengguna</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select name="id_kepemilikan" class="form-select" id="createKepemilikan">
                                        <option value="">Pilih Kepemilikan</option>
                                        @foreach ($kepemilikan as $k)
                                            <option value="{{ $k->id }}">{{ $k->kepemilikan }}</option>
                                        @endforeach
                                    </select>
                                    <label for="createKepemilikan">Kepemilikan</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div class="modal fade" id="detailAsetModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Aset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detailAsetContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editAsetModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Aset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="editAsetContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Barcode Modal -->
    <div class="modal fade" id="barcodeModal" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">QR Code Aset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center" id="barcodeContent">
                    <!-- QR Code akan dimuat di sini -->
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function loadAsetDetail(id) {
                fetch(`/aset/${id}/detail`)
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('detailAsetContent').innerHTML = html;
                    });
            }

            function loadAsetEdit(id) {
                fetch(`/aset/${id}/edit`)
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('editAsetContent').innerHTML = html;
                    });
            }

            // Replace the existing loadBarcode function
            // Di bagian scripts pada index.blade.php
            function loadBarcode(id) {
                fetch(`/aset/${id}/barcode`)
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('barcodeContent').innerHTML = html;
                        const modal = new bootstrap.Modal(document.getElementById('barcodeModal'));
                        modal.show();
                    });
            }
        </script>
    @endpush

    @push('styles')
        <style>
            /* Custom Styles */
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

            .form-check-input:checked {
                background-color: #0d6efd;
                border-color: #0d6efd;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Handle search functionality
            document.getElementById('searchInput').addEventListener('keyup', function(e) {
                // Implement search logic
            });

            // Handle filters
            document.getElementById('jenisFilter').addEventListener('change', function(e) {
                // Implement filter logic
            });

            document.getElementById('kepemilikanFilter').addEventListener('change', function(e) {
                // Implement filter logic
            });

            // Confirm delete
            function confirmDelete(id) {
                Swal.fire({
                    title: 'Hapus Aset?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Implement delete logic
                        window.location.href = `/aset/${id}/delete`;
                    }
                });
            }

            // Load modals content
            async function loadAsetDetail(id) {
                const response = await fetch(`/aset/${id}/detail`);
                const html = await response.text();
                document.getElementById('detailAsetContent').innerHTML = html;
            }

            async function loadAsetEdit(id) {
                const response = await fetch(`/aset/${id}/edit`);
                const html = await response.text();
                document.getElementById('editAsetContent').innerHTML = html;
            }

            // Di bagian scripts pada index.blade.php
            function loadBarcode(id) {
                fetch(`/aset/${id}/barcode`)
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('barcodeContent').innerHTML = html;
                        const modal = new bootstrap.Modal(document.getElementById('barcodeModal'));
                        modal.show();
                    });
            }
        </script>
    @endpush
@endsection
