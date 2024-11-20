<!-- resources/views/auth/settings.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row">

            <div class="col-12">
                <a href="{{route('aset.index')}}" class="btn btn-primary mb-3">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <!-- Sidebar -->
            <div class="col-12 col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle"
                                width="150">
                            <div class="mt-3">
                                <h4>{{ Auth::user()->name }}</h4>
                                <p class="text-muted font-size-sm">Admin</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-12 col-md-9">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Profile Settings -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Pengaturan Profil</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" name="username"
                                    value="{{ Auth::user()->username }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password Saat Ini</label>
                                <input type="password" class="form-control" name="current_password">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password" class="form-control" name="new_password">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" name="new_password_confirmation">
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>

                <!-- User Management -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Manajemen Petugas</h5>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
                            Tambah Petugas
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#editUserModal{{ $user->id }}">
                                                    <i class="fas fa-pencil"></i>
                                                </button>
                                                <form action="{{ route('users.delete', $user) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="confirmDelete('{{ route('users.delete', $user) }}', 'users')" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Edit User Modal -->
                                        <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Petugas</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="{{ route('users.update', $user) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Nama</label>
                                                                <input type="text" class="form-control" name="edit_name"
                                                                    value="{{ $user->name }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Username</label>
                                                                <input type="text" class="form-control"
                                                                    name="edit_username" value="{{ $user->username }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Password Baru (Kosongkan jika
                                                                    tidak ingin mengubah)</label>
                                                                <input type="password" class="form-control"
                                                                    name="edit_password">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah User Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('users.create') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
