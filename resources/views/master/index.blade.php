
@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12">
                <a href="{{route('aset.index')}}" class="btn btn-primary mb-3">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0">Master Data</h5>
                                <div class="btn-group mt-2">
                                    <a href="{{ route('master.index', ['type' => 'jenis']) }}"
                                        class="btn btn-sm {{ $type === 'jenis' ? 'btn-primary' : 'btn-outline-primary' }}">
                                        Jenis
                                    </a>
                                    <a href="{{ route('master.index', ['type' => 'kepemilikan']) }}"
                                        class="btn btn-sm {{ $type === 'kepemilikan' ? 'btn-primary' : 'btn-outline-primary' }}">
                                        Kepemilikan
                                    </a>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#createModal">
                                <i class="fas fa-plus"></i> Tambah {{ ucfirst($type) }}
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover" id="masterTable">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>{{ ucfirst($type) }}</th>
                                        <th width="15%">Status</th>
                                        <th width="15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->{$type} }}</td>
                                            <td>
                                                <span class="badge {{ $item->is_active ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $item->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                                </span>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#editModal{{ $item->id }}">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    onclick="confirmDelete('{{ route('master.destroy', $item->id) }}', '{{ $type }}')">
                                                    <i class="fas fa-trash"></i>
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
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('master.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="{{ $type }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Tambah {{ ucfirst($type) }} Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="{{ $type }}" class="form-label">Nama {{ ucfirst($type) }}</label>
                            <input type="text" class="form-control @error($type) is-invalid @enderror"
                                id="{{ $type }}" name="{{ $type }}" value="{{ old($type) }}" required>
                            @error($type)
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit & Delete Modals -->
    @foreach ($data as $item)
        <!-- Edit Modal -->
        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('master.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="type" value="{{ $type }}">
                        <input type="hidden" name="id" value="{{ $item->id }}">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel{{ $item->id }}">
                                Edit {{ ucfirst($type) }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="{{ $type }}{{ $item->id }}" class="form-label">
                                    Nama {{ ucfirst($type) }}
                                </label>
                                <input type="text" class="form-control @error($type) is-invalid @enderror"
                                    id="{{ $type }}{{ $item->id }}" name="{{ $type }}"
                                    value="{{ old($type, $item->{$type}) }}" required>
                                @error($type)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active{{ $item->id }}"
                                        name="is_active" value="1" {{ $item->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active{{ $item->id }}">Status
                                        Aktif</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('master.destroy', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="type" value="{{ $type }}">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel{{ $item->id }}">Konfirmasi Hapus</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin menghapus {{ $type }} "{{ $item->{$type} }}"?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#masterTable').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
                    }
                });

                // Show modal if there are validation errors
                @if ($errors->any())
                    @if (old('_method') == 'PUT')
                        var modalId = '#editModal{{ old('id') }}';
                        $(modalId).modal('show');
                    @else
                        $('#createModal').modal('show');
                    @endif
                @endif
            });
        </script>
    @endpush
@endsection
