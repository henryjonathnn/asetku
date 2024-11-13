@extends('layouts.app')

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow-lg rounded text-center p-4" style="max-width: 500px; width: 100%;">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">QR Code Aset</h4>
            </div>
            <div class="card-body">
                <!-- QR Code and Logos Container -->
                <div class="qr-container p-4 bg-light border rounded mb-4 d-flex flex-column align-items-center">
                    <!-- QR Code Display -->
                    <div class="qrcode-wrapper d-flex justify-content-center align-items-center mb-3">
                        <div style="width: 300px; height: 300px; overflow: hidden;">
                            {!! $qrcode !!}
                        </div>
                    </div>
                    <!-- Logos Display -->
                    <div class="logos d-flex justify-content-center mt-3 mb-3" style="gap: 20px;">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo" class="logo-img">
                        <img src="{{ asset('img/it.png') }}" alt="IT Logo" class="logo-img">
                    </div>
                </div>
                <!-- Print Button -->
                <button onclick="printQRCode()" class="btn btn-success w-100">
                    <i class="fas fa-print"></i> Print QR Code
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function printQRCode() {
                const printContent = document.querySelector('.qr-container').innerHTML;
                const originalContent = document.body.innerHTML;

                document.body.innerHTML = `
                    <div style="display: flex; justify-content: center; align-items: center; min-height: 100vh;">
                        <div style="background: white; padding: 20px; border-radius: 8px;">
                            ${printContent}
                        </div>
                    </div>
                `;

                window.print();
                document.body.innerHTML = originalContent;
                location.reload();
            }
        </script>
    @endpush

    <style>
        .card {
            border: none;
        }

        .qr-container {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .qrcode-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            max-width: 300px;
            height: 300px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 8px;
            overflow: hidden;
        }

        .logo-img {
            max-width: 80px;
            object-fit: contain;
        }

        .btn-success {
            background-color: #4CAF50;
            border-color: #4CAF50;
        }

        .btn-success:hover {
            background-color: #45a049;
            border-color: #45a049;
        }
    </style>
@endsection
