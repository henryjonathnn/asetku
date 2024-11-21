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
            /* Menambah jarak antar elemen */
            padding: 20px;
            /* Menambah jarak tepi */
            justify-content: center;
        }

        .qr-item {
            border: 1px solid #ddd;
            padding: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
            width: 120px;
            /* Set a fixed width */
            height: 120px;
            /* Set a fixed height to match the width */
            justify-content: center;
        }


        .qr-code {
            width: 80px;
            height: 80px;
            flex-shrink: 0;
        }

        .qr-content {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: -20px;
        }

        .aset-info {
            margin-top: 0;
            text-align: left;
            flex-grow: 1;
        }

        .aset-info p {
            margin: 0;
            font-size: 11px;
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
            gap: 8px;
        }

        .logo-wrapper {
            display: flex;
            align-items: center;
            height: 60px;
        }

        .gambar-rs {
            height: 55px;
            width: auto;
        }

        .gambar-it {
            height: 28px;
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
        /* Print styles */
        @page {
            size: A4;
            margin: 0.5cm;
        }

        @media print {
            body {
                padding: 0;
                margin: 0;
                font-family: Arial, sans-serif;
            }

            .print-controls {
                display: none;
            }

            .qr-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                /* Ensure same column layout */
                gap: 10px;
                /* Adjust spacing for print */
                padding: 1px;
            }

            .qr-item {
                break-inside: avoid;
                page-break-inside: avoid;
                margin-top: 20px;
                padding: 10px;
                /* Uniform padding */
                display: flex;
                justify-content: center;
                align-items: center;
                width: 110px;
                /* Fixed width for consistency */
                height: 110px;
                /* Fixed height for consistency */
                border: 1px solid #ddd;
            }

            .qr-code svg {
                width: 80px !important;
                height: 80px !important;
            }

            .qr-content {
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: -20px;
            }

            .aset-info p {
                font-size: 8px;
                text-align: center;
                margin: 0;
            }

            .logos {
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 8px;
                margin: 0 auto;
            }

            .logo-wrapper {
                display: flex;
                align-items: center;
                height: 60px;
            }

            .gambar-rs {
                height: 40px;
            }

            .gambar-it {
                height: 20px;
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
