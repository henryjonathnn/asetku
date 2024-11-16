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
            gap: 10px;
            padding: 4px;
        }

        .qr-item {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: auto;
            width: auto;
        }

        .qr-code {
            width: 150px;
            height: 150px;
            margin-left: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .qr-code svg {
            width: 100% !important;
            height: 100% !important;
            transform: none !important;
            display: block !important;
            margin: 0 !important;
        }

        .aset-info {
            margin-top: 2px;
            text-align: center;
            width: 100%;
        }

        .aset-info p {
            margin: 2px 0;
            font-size: 11px;
            word-break: break-all;
        }

        .logos {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 4px;
            gap: 8px;
        }

        .logo-wrapper {
            display: flex;
            align-items: center;
            height: 60px;
        }

        .gambar-rs {
            height: 80px;
            width: auto;
        }

        .gambar-it {
            height: 40px;
            width: auto;
            margin-left: 8px;
            margin-bottom: -6px;
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

        /* Print styles */
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
                gap: 10px;
            }

            .qr-item {
                break-inside: avoid;
                page-break-inside: avoid;
                margin-left: 25px;
                display: flex;
            }

            .qr-code svg {
                margin: 0 !important;
            }

            .qr-code,
            .aset-info {
                margin: inherit;
            }

            .logos {
                margin: 0, auto;
            }

            .logo-wrapper {
                height: 60px;
            }

            .gambar-rs {
                height: 70px;
            }

            .gambar-it {
                height: 35px;
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
            {{-- @for ($u = 0; $u < 5; $u++) --}}
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
