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
                            <tr class="text-left">
                                <div class="mt-4 ms-3">
                                    <button type="button" id="printSelected" class="btn btn-primary" disabled>
                                        <i class="fas fa-print me-2"></i>Cetak QR Code Terpilih
                                    </button>
                                </div>
                                <th class="border-0 ps-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAll">
                                    </div>
                                </th>
                                <th class="border-0 ps-4">No</th>
                                <th class="border-0">Nomor Aset</th>
                                <th class="border-0">Jenis</th>
                                <th class="border-0">Nama Barang</th>
                                <th class="border-0">Pengguna</th>
                                <th class="border-0 rounded-end text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($aset as $index => $item)
                                <tr class="text-left">
                                    <td class="ps-4">
                                        <div class="form-check">
                                            <input class="form-check-input aset-checkbox" type="checkbox"
                                                value="{{ $item->id }}" name="selected_asets[]">
                                        </div>
                                    </td>
                                    <td class="ps-4">
                                        <span class="fw-medium">{{ $loop->iteration ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-medium">{{ $item->nomor_aset ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">{{ $item->jenis->jenis ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="bg-light rounded p-1">
                                                <i class="fas fa-box text-primary"></i>
                                            </div>
                                            <div>
                                                <span class="d-block fw-medium">{{ $item->nama_barang }}</span>
                                                <small class="text-muted">SN: {{ $item->serial_number }}</small>
                                                <small class="text-muted">PN: {{ $item->part_number }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="bg-light rounded-circle p-1">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                            <span>{{ $item->pengguna ?? '-' }}</span>
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
                <form action="{{ route('aset.store') }}" method="POST" class="p-4">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-4">
                            <!-- Basic Information -->
                            <div class="col-12">
                                <h6 class="text-primary mb-3">Informasi Dasar</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="nama_barang" class="form-control"
                                                id="createNamaBarang" placeholder="Nama Barang">
                                            <label for="createNamaBarang">Nama Barang</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select name="id_master_jenis" class="form-select" id="createJenis">
                                                <option value="">Pilih Jenis</option>
                                                @foreach ($jenis as $j)
                                                    <option value="{{ $j->id }}">
                                                        {{ $j->jenis }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="createJenis">Jenis</label>
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
                                            <input type="text" name="nomor_aset" class="form-control"
                                                id="createNomorAset" placeholder="Nomor Aset">
                                            <label for="createNomorAset">Nomor Aset</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="text" name="serial_number" class="form-control"
                                                id="createSerialNumber" placeholder="Serial Number">
                                            <label for="createSerialNumber">Serial Number</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="text" name="part_number" class="form-control"
                                                id="createPartNumber" placeholder="Part Number">
                                            <label for="createPartNumber">Part Number</label>
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
                                            <textarea name="spek" class="form-control" id="createSpek" style="height: 100px" placeholder="Spesifikasi"></textarea>
                                            <label for="createSpek">Spesifikasi</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <select name="status" class="form-select" id="createStatus">
                                                <option value="">Pilih Status</option>
                                                <option value="baik">Baik</option>
                                                <option value="kurang_layak">Kurang Layak</option>
                                                <option value="rusak">Rusak</option>
                                            </select>
                                            <label for="createStatus">Status</label>
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
                                            <input type="number" name="tahun_kepemilikan" class="form-control"
                                                id="createTahun" placeholder="Tahun">
                                            <label for="createTahun">Tahun Kepemilikan</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="text" name="pengguna" class="form-control"
                                                id="createPengguna" placeholder="Pengguna">
                                            <label for="createPengguna">Pengguna</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <select name="id_kepemilikan" class="form-select" id="createKepemilikan">
                                                <option value="">Pilih Kepemilikan</option>
                                                @foreach ($kepemilikan as $k)
                                                    <option value="{{ $k->id }}">
                                                        {{ $k->kepemilikan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="createKepemilikan">Kepemilikan</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Buat</button>
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

    <!-- Photo View Modal -->
    <div class="modal fade" id="photoViewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center p-0">
                    <img src="" id="modalPhotoPreview" alt="Foto Kegiatan" class="img-fluid">
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
            // Main initialization
            // Main initialization
            document.addEventListener('DOMContentLoaded', function() {
                // Cache DOM elements
                const elements = {
                    selectAll: document.getElementById('selectAll'),
                    asetCheckboxes: document.querySelectorAll('.aset-checkbox'),
                    printSelected: document.getElementById('printSelected'),
                    photoViewModal: document.getElementById('photoViewModal'),
                    modalPhotoPreview: document.getElementById('modalPhotoPreview'),
                    detailAsetModal: document.getElementById('detailAsetModal'),
                    photoPreview: document.getElementById('photoPreview'),
                    createModal: document.getElementById('createKegiatanModal'),
                    imagePreview: document.querySelector('#imagePreview'),
                    fileInput: document.querySelector('#foto')
                };

                // Initialize event listeners
                initializePhotoHandlers();
                initializeCheckboxHandlers();
                initializeModalHandlers();
            });

            // Photo handling functions
            function initializePhotoHandlers() {
                // Global click handler for photo viewing
                document.addEventListener('click', function(e) {
                    const photoButton = e.target.closest('.view-photo');
                    if (!photoButton) return;

                    e.preventDefault();
                    showPhotoModal(photoButton.dataset.photo);
                });

                // Photo modal events
                const photoViewModal = document.getElementById('photoViewModal');
                photoViewModal.addEventListener('hidden.bs.modal', function() {
                    document.getElementById('modalPhotoPreview').src = '';
                });

                // Nested modal handling
                photoViewModal.addEventListener('show.bs.modal', function() {
                    document.getElementById('detailAsetModal').style.opacity = 1;
                });

                photoViewModal.addEventListener('hidden.bs.modal', function() {
                    document.getElementById('detailAsetModal').style.opacity = 1;
                    document.getElementById('photoPreview').src = '';
                });
            }

            // Checkbox handling functions
            function initializeCheckboxHandlers() {
                const selectAll = document.getElementById('selectAll');
                const asetCheckboxes = document.querySelectorAll('.aset-checkbox');
                const printSelected = document.getElementById('printSelected');

                // Select All checkbox handler
                selectAll.addEventListener('change', function() {
                    asetCheckboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                    updatePrintButtonState();
                });

                // Individual checkboxes handler
                asetCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const allChecked = Array.from(asetCheckboxes).every(cb => cb.checked);
                        const anyChecked = Array.from(asetCheckboxes).some(cb => cb.checked);
                        selectAll.checked = allChecked;
                        updatePrintButtonState();
                    });
                });

                // Print button handler
                if (printSelected) {
                    printSelected.addEventListener('click', handlePrintSelected);
                }
            }

            // Modal handling functions
            function initializeModalHandlers() {
                const createModal = document.getElementById('createKegiatanModal');
                if (createModal) {
                    createModal.addEventListener('hidden.bs.modal', resetModalForm);
                }
            }

            // Utility functions
            function showPhotoModal(photoUrl) {
                const modalImg = document.getElementById('modalPhotoPreview');
                modalImg.src = photoUrl;
                const photoModal = new bootstrap.Modal(document.getElementById('photoViewModal'));
                photoModal.show();
            }

            function updatePrintButtonState() {
                const asetCheckboxes = document.querySelectorAll('.aset-checkbox');
                const printSelected = document.getElementById('printSelected');
                const checkedBoxes = Array.from(asetCheckboxes).filter(cb => cb.checked);
                if (printSelected) {
                    printSelected.disabled = checkedBoxes.length === 0;
                }
            }

            function handlePrintSelected(e) {
                e.preventDefault();
                const asetCheckboxes = document.querySelectorAll('.aset-checkbox');
                const selectedAsets = Array.from(asetCheckboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value);

                if (selectedAsets.length === 0) {
                    alert('Pilih minimal satu aset untuk dicetak');
                    return;
                }

                // Create form for printing
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/aset/print-multiple'; // Pastikan URL ini sesuai dengan route Anda
                form.target = '_blank'; // Buka di tab baru

                // Add CSRF token
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = document.querySelector('meta[name="csrf-token"]').content;
                form.appendChild(csrfInput);

                // Add selected assets
                selectedAsets.forEach(asetId => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'selected_asets[]';
                    input.value = asetId;
                    form.appendChild(input);
                });

                // Submit form
                document.body.appendChild(form);
                form.submit();
                document.body.removeChild(form);
            }

            function resetModalForm() {
                const preview = document.querySelector('#imagePreview');
                const previewImg = preview.querySelector('img');
                const fileInput = document.querySelector('#foto');

                previewImg.src = '';
                preview.classList.add('d-none');
                fileInput.value = '';
            }

            // Image preview function
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

            // AJAX loading functions
            async function loadAsetDetail(id) {
                try {
                    const response = await fetch(`/aset/${id}/detail`);
                    const html = await response.text();
                    document.getElementById('detailAsetContent').innerHTML = html;
                } catch (error) {
                    console.error('Error loading asset detail:', error);
                }
            }

            async function loadAsetEdit(id) {
                try {
                    const response = await fetch(`/aset/${id}/edit`);
                    const html = await response.text();
                    document.getElementById('editAsetContent').innerHTML = html;
                } catch (error) {
                    console.error('Error loading asset edit:', error);
                }
            }

            async function loadBarcode(id) {
                try {
                    const response = await fetch(`/aset/${id}/barcode`);
                    const html = await response.text();
                    document.getElementById('barcodeContent').innerHTML = html;

                    const modal = new bootstrap.Modal(document.getElementById('barcodeModal'));
                    modal.show();

                    const printButton = document.getElementById('printQRButton');
                    if (printButton) {
                        printButton.addEventListener('click', () => window.print());
                    }
                } catch (error) {
                    console.error('Error loading barcode:', error);
                }
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
@endsection
