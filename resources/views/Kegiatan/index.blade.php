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
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Part Number:</strong> {{ $aset->part_number }}
                    </div>
                    <div class="col-md-4">
                        <strong>Tahun Kepemilikan:</strong> {{ $aset->tahun_kepemilikan }}
                    </div>
                    <div class="col-md-4">
                        <strong>Pengguna:</strong> {{ $aset->pengguna }}
                    </div>
                </div>

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
                                    <td>{{ $k->kegiatan }}</td>
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
                            <label for="kegiatan" class="form-label">Kegiatan</label>
                            <textarea class="form-control" id="kegiatan" name="kegiatan" rows="3" required></textarea>
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
@endsection
