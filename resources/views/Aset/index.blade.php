@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Daftar Aset</h4>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createAsetModal">
                    Tambah Aset
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>ID Aset</th>
                                <th>Jenis</th>
                                <th>Nama Barang</th>
                                <th>Pengguna</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($aset as $index => $aset)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $aset->id }}</td>
                                    <td>{{ $aset->jenis }}</td>
                                    <td>{{ $aset->nama_barang }}</td>
                                    <td>{{ $aset->pengguna }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#detailAsetModal" data-aset-id="{{ $aset->id }}"
                                            onclick="loadAsetDetail('{{ $aset->id }}')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-warning btn-sm text-white"
                                            data-bs-toggle="modal" data-bs-target="#editAsetModal"
                                            data-aset-id="{{ $aset->id }}"
                                            onclick="loadAsetEdit('{{ $aset->id }}')">
                                            <i class="fas fa-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#barcodeModal" data-aset-id="{{ $aset->id }}"
                                            onclick="loadBarcode('{{ $aset->id }}')">
                                            <i class="fas fa-print"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createAsetModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Aset Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('aset.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Nama Barang</label>
                                <input type="text" name="nama_barang" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Jenis</label>
                                <input type="text" name="jenis" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Serial Number</label>
                                <input type="text" name="serial_number" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Part Number</label>
                                <input type="text" name="part_number" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label>Spesifikasi</label>
                                <textarea name="spek" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Tahun Kepemilikan</label>
                                <input type="number" name="tahun_kepemilikan" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Pengguna</label>
                                <input type="text" name="pengguna" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Kepemilikan</label>
                                <select name="id_kepemilikan" class="form-control">
                                    @foreach ($kepemilikan as $kepemilikan)
                                        <option value="{{ $kepemilikan->id }}">{{ $kepemilikan->kepemilikan }}</option>
                                    @endforeach
                                </select>
                            </div>
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Barcode Aset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center" id="barcodeContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
@endsection

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

        function loadBarcode(id) {
            window.open(`/aset/${id}/barcode`, '_blank', 'width=400,height=400');
        }
    </script>
@endpush
