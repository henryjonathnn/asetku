<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistem Manajemen Aset</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css" />

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .main-content {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .navbar {
            background-color: #00813f;
            padding: 0;
            height: 80px;
            /* Increased height */
        }

        .navbar-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
            padding: 0 15px;
        }

        .branding-section {
            display: flex;
            align-items: center;
            gap: 25px;
            /* Increased gap */
            height: 100%;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 15px;
            /* Increased gap */
            height: 100%;
        }

        .logo-container {
            height: 65px;
            /* Adjusted height */
            width: 65px;
            /* Added width to maintain aspect ratio */
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            background-color: white;
            border-radius: 50%;
            box-shadow: 0 0 0 2px white;
        }

        .logo-container img {
            height: 100%;
            width: 100%;
            object-fit: contain;
        }

        .hospital-info {
            color: white;
            padding-left: 5px;
        }

        .hospital-name {
            font-size: 1.3rem;
            /* Increased font size */
            font-weight: bold;
            margin: 0;
            line-height: 1.3;
            white-space: nowrap;
        }

        .hospital-location {
            font-size: 0.9rem;
            /* Increased font size */
            margin: 0;
        }

        .contact-info {
            display: flex;
            align-items: center;
            gap: 20px;
            /* Increased gap */
            color: white;
            font-size: 0.85rem;
            margin: 0 25px;
        }

        .contact-info-item {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0 6px;
            /* Increased gap */
            white-space: nowrap;
        }

        .dropdown-menu.show {
            display: block;
        }

        .user-section {
            margin-left: auto;
            padding-right: 15px;
        }

        .user-dropdown {
            color: white;
            cursor: pointer;
            font-size: 1rem;
            /* Increased font size */
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .user-dropdown:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        /* Responsive adjustments */
        @media (max-width: 1200px) {
            .contact-info-item span {
                display: none;
            }

            .contact-info-item i {
                font-size: 1.1rem;
            }

            .contact-info {
                gap: 15px;
            }
        }

        @media (max-width: 768px) {
            .navbar {
                height: 60px;
            }

            .hospital-name {
                font-size: 1.1rem;
            }

            .hospital-location {
                font-size: 0.8rem;
            }

            .logo-container {
                height: 45px;
                width: 45px;
            }

            .contact-info {
                display: none;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-container">
                <div class="branding-section">
                    <div class="logo-section">
                        <a href={{ route('aset.index') }}>
                            <div class="logo-container">
                                <img src="/img/logo.png" alt="Logo RSUD">
                            </div>
                        </a>
                        <div class="hospital-info">
                            <h1 class="hospital-name">RSUD Daha Husada</h1>
                            <h3 class="hospital-location">Kota Kediri</h3>
                        </div>
                    </div>

                    <div class="contact-info">
                        <div class="contact-info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Jl. Veteran No.48, Mojoroto, Kediri</span>
                        </div>
                        <div class="contact-info-item">
                            <i class="fas fa-phone"></i>
                            <span>(WA) 0857-1085-6584</span>
                        </div>
                        <div class="contact-info-item">
                            <i class="fas fa-globe"></i>
                            <a class="text-white" href="https://rsuddahahusada.jatimprov.go.id/"
                                target="_blank">rsuddahahusada.jatimprov.go.id</a>
                        </div>
                    </div>
                </div>
                @if (!Route::is('kegiatan.*'))
                    <div class="user-section">
                        <div class="dropdown">
                            <a class="user-dropdown dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> {{ Auth::user()->name ?? 'User' }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href={{ route('settings') }}><i class="fas fa-cog"></i>
                                        Pengaturan</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href={{ route('master.index') }}><i
                                            class="fas fa-server"></i>
                                        Data Master</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </nav>


    <!-- Main Content -->
    <div class="container main-content">
        @yield('content')
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>

    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom Scripts -->
    <script>
        // Display Laravel Flash Messages using SweetAlert
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        function confirmDelete(url, type) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data yang dihapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create form element
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = url;

                    // Add CSRF token
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    form.appendChild(csrfToken);

                    // Add method DELETE
                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';
                    form.appendChild(methodField);

                    // Add type field
                    const typeField = document.createElement('input');
                    typeField.type = 'hidden';
                    typeField.name = 'type';
                    typeField.value = type;
                    form.appendChild(typeField);

                    // Append form to body and submit
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Add CSRF token to all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            var dropdownToggle = document.querySelector('.user-dropdown');

            if (dropdownToggle) {
                dropdownToggle.addEventListener('click', function(e) {
                    console.log('Dropdown clicked');

                    // Force toggle dropdown manually
                    var dropdownMenu = this.nextElementSibling;
                    if (dropdownMenu && dropdownMenu.classList.contains('dropdown-menu')) {
                        dropdownMenu.classList.toggle('show');
                        this.setAttribute('aria-expanded', this.getAttribute('aria-expanded') === 'true' ?
                            'false' : 'true');
                    }
                });
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
