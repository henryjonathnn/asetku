<div class="container-fluid p-4">
    <!-- Asset Information Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light py-3">
            <h6 class="mb-0 fw-bold text-primary">Informasi Aset</h6>
        </div>
        <div class="card-body">
            <div class="row g-4">
                <!-- Left Column -->
                <div class="col-md-6">
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-light rounded-circle p-2 me-3">
                                <i class="fas fa-box text-primary"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Nama Barang</small>
                                <strong>{{ $aset->nama_barang ?? '-' }}</strong>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-light rounded-circle p-2 me-3">
                                <i class="fas fa-tag text-primary"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Jenis</small>
                                <strong>{{ $aset->jenis->jenis ?? '-' }}</strong>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-light rounded-circle p-2 me-3">
                                <i class="fas fa-barcode text-primary"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Nomor Aset</small>
                                <strong>{{ $aset->nomor_aset ?? '-' }}</strong>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-light rounded-circle p-2 me-3">
                                <i class="fas fa-barcode text-primary"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Serial Number</small>
                                <strong>{{ $aset->serial_number ?? '-' }}</strong>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-light rounded-circle p-2 me-3">
                                <i class="fas fa-hashtag text-primary"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Part Number</small>
                                <strong>{{ $aset->part_number ?? '-' }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Right Column -->
                <div class="col-md-6">
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-light rounded-circle p-2 me-3">
                                <i class="fas fa-user text-primary"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Pengguna</small>
                                <strong>{{ $aset->pengguna ?? '-' }}</strong>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-light rounded-circle p-2 me-3">
                                <i class="fas fa-calendar text-primary"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Tahun</small>
                                <strong>{{ $aset->tahun_kepemilikan ?? '-' }}</strong>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-light rounded-circle p-2 me-3">
                                <i class="fas fa-building text-primary"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Kepemilikan</small>
                                <strong>{{ $aset->kepemilikan->kepemilikan ?? '-' }}</strong>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-light rounded-circle p-2 me-3">
                                <i class="fas fa-clock text-primary"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Tanggal Dibuat</small>
                                <strong>{{ $aset->created_at ?? ($aset->updated_at ?? '-') }}</strong>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-light rounded-circle p-2 me-3">
                                <i class="fas fa-clock text-primary"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Status Aset</small>
                                <strong>{{ $aset->status_formatted ?? '-' }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Specifications Section -->
            <div class="mt-4">
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-light rounded-circle p-2 me-3">
                        <i class="fas fa-list-ul text-primary"></i>
                    </div>
                    <h6 class="mb-0 fw-bold">Spesifikasi</h6>
                </div>
                <div class="bg-light rounded p-3 mt-2">
                    {{ $aset->spek ?? '-' }}
                </div>
            </div>
        </div>
    </div>

    <!-- Activity History Card -->
    <div class="card shadow-sm">
        <div class="card-header bg-light py-3 d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold text-primary">Riwayat Kegiatan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kegiatan</th>
                            <th>Petugas</th>
                            <th>Foto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($aset->kegiatan as $index => $k)
                            <tr>
                                <td class="align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle">{{ $k->created_at->format('d-m-Y') }}</td>
                                <td class="align-middle">
                                    @if ($k->masterKegiatan->is_custom)
                                        {{ $k->custom_kegiatan ?? '-' }}
                                    @else
                                        {{ $k->masterKegiatan->kegiatan }}
                                    @endif
                                </td>
                                <td class="align-middle">{{ $k->user->name }}</td>
                                <td class="align-middle">
                                    @if ($k->foto)
                                        <button type="button" class="btn btn-sm btn-primary view-photo"
                                            data-photo="{{ asset('storage/' . $k->foto) }}">
                                            <i class="fas fa-image me-1"></i>Lihat Foto
                                        </button>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="fas fa-info-circle me-2"></i>Belum ada riwayat kegiatan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
