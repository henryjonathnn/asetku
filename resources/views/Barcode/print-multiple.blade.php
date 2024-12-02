<!DOCTYPE html>
<html>
<head>
    <title>Print QR Codes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .qr-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr); /* 6 QR Code per baris */
            gap: 2px; /* Jarak antar item */
            justify-content: center;
            padding: 2px; /* Sedikit padding di container */
            margin: 0 auto;
            width: fit-content;
        }

        .qr-item {
            border: 1px solid #ddd;
            padding: 4px 3px;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100px;
            height: 100px;
            justify-content: space-between;
            margin: 0; /* Menghapus negative margin */
        }

        .qr-content {
            display: flex;
            align-items: center;
            gap: 1px;
            margin-bottom: 1px;
        }

        .qr-code {
            width: 70px;
            height: 70px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 1px;
        }

        .aset-info {
            height: 70px;
            display: flex;
            align-items: center;
            max-width: 25px;
        }

        .aset-info p {
            margin: 0;
            font-size: 7px;
            word-break: break-all;
        }

        .qr-code svg {
            width: 100% !important;
            height: 100% !important;
            transform: none !important;
            display: block !important;
            margin: 0 !important;
        }

        .logos {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            margin-top: 0;
        }

        .logo-wrapper {
            display: flex;
            align-items: center;
            height: 22px;
        }

        .gambar-rs {
            height: 22px;
            width: auto;
        }

        .gambar-it {
            height: 14px;
            width: auto;
            margin-left: 2px;
        }

        .btn {
            padding: 8px 15px;
            margin-right: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-print {
            background: #007bff;
            color: white;
        }

        .btn-close {
            background: #6c757d;
            color: white;
        }

        @media print {
            body {
                padding: 0;
            }

            .qr-grid {
                gap: 2px; /* Mempertahankan jarak yang sama saat print */
                padding: 2px;
                margin: 0 auto;
            }

            .print-controls {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="print-controls">
        <button class="btn btn-print" onclick="window.print()">Print QR Codes</button>
        <button class="btn btn-close" onclick="window.close()">Close</button>
    </div>

    <div class="qr-grid">
        @foreach ($asetsWithQR as $item)
            <div class="qr-item">
                <div class="qr-content">
                    <div class="qr-code">
                        {!! $item['qrcode'] !!}
                    </div>
                    <div class="aset-info">
                        <p>{{ Str::afterLast($item['aset']->id, '-') }}</p>
                    </div>
                </div>
                <div class="logos">
                    <div class="logo-wrapper">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo" class="gambar-rs">
                        <img src="{{ asset('img/it.png') }}" alt="IT Logo" class="gambar-it">
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const qrCodes = document.querySelectorAll('.qr-code svg');
            qrCodes.forEach(svg => {
                svg.style.transform = 'none';
                svg.setAttribute('width', '100%');
                svg.setAttribute('height', '100%');
            });
        });
    </script>
</body>
</html>
