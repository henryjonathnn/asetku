<!DOCTYPE html>
<html>
<head>
    <title>Print QR Codes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 5px;
        }

        .qr-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            padding: 4px;
        }

        .qr-item {
            border: 1px solid #ddd;
            padding: 4px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: auto;
            width: auto;
        }

        .qr-code {
            width: 180px;
            height: 180px;
            margin: 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .qr-code svg {
            width: 100% !important;
            height: 100% !important;
            transform: none !important;
            display: block !important;
            margin-left: 32px;
        }

        .aset-info {
            margin-top: 5px;
            text-align: center;
            width: 100%;
        }

        .aset-info p {
            margin: 5px 0;
            font-size: 12px;
            word-break: break-all;
        }

        .logos {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 5px;
            gap: 10px;
        }

        .logo-wrapper {
            display: flex;
            align-items: center;
            height: 80px; /* Ditingkatkan dari 40px ke 80px */
        }

        .gambar-rs {
            height: 80px; /* Ditingkatkan dari 40px ke 80px */
            width: auto;
        }

        .gambar-it {
            height: 50px; /* Ditingkatkan dari 20px ke 50px */
            width: auto;
            margin-left: 10px;
            margin-bottom: 8px;
        }

        .print-controls {
            margin-bottom: 20px;
            padding: 10px;
            background: #f5f5f5;
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

        /* Print styles that maintain website layout */
        @page {
            size: A4;
            margin: 0.5cm;
        }

        @media print {
            body {
                padding: 0;
                margin: 0;
            }

            .print-controls {
                display: none;
            }

            .qr-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 20px;
                padding: 4px;
                margin: 0;
            }

            .qr-item {
                break-inside: avoid;
                page-break-inside: avoid;
                margin: 0;
                padding: 4px;
                border: 1px solid #ddd;
                height: auto;
            }

            .qr-code {
                width: 180px;
                height: 180px;
                margin: 0 auto;
            }

            .qr-code svg {
                width: 100% !important;
                height: 100% !important;
                transform: none !important;
                -webkit-transform: none !important;
                margin-left: 32px !important;
            }

            .aset-info {
                margin-top: 5px;
            }

            .aset-info p {
                margin: 5px 0;
                font-size: 12px;
            }

            .logos {
                margin-top: 5px;
            }

            .logo-wrapper {
                height: 80px; /* Disesuaikan untuk print juga */
            }

            .gambar-rs {
                height: 80px; /* Disesuaikan untuk print juga */
            }

            .gambar-it {
                height: 50px; /* Disesuaikan untuk print juga */
                margin-left: 10px;
                margin-bottom: 8px;
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
            @for ($u = 0; $u < 5; $u++)
                <div class="qr-item">
                    <div class="qr-code">
                        {!! $item['qrcode'] !!}
                    </div>
                    <div class="aset-info">
                        <p>{{ $item['aset']->id ?? '-' }}</p>
                    </div>
                    <div class="logos">
                        <div class="logo-wrapper">
                            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="gambar-rs">
                            <img src="{{ asset('img/it.png') }}" alt="IT Logo" class="gambar-it">
                        </div>
                    </div>
                </div>
            @endfor
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