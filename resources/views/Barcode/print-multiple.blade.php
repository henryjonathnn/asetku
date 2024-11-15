<!DOCTYPE html>
<html>
<head>
    <title>Print QR Codes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .qr-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            padding: 10px;
        }

        .qr-item {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
            page-break-inside: avoid;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .qr-code {
            width: 180px;
            height: 180px;
            margin: 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
            /* Tambahan untuk memastikan QR code tetap sejajar */
            transform: rotate(0deg) !important;
        }

        /* Styling khusus untuk SVG QR code */
        .qr-code svg {
            width: 100% !important;
            height: 100% !important;
            transform: none !important;
            display: block !important;
            margin-left: 32px
        }

        .aset-info {
            margin-top: 10px;
            text-align: center;
            width: 100%;
        }

        .aset-info h4 {
            margin: 5px 0;
            font-size: 16px;
            font-weight: bold;
        }

        .aset-info p {
            margin: 5px 0;
            font-size: 14px;
            line-height: 1.4;
        }

        .print-controls {
            margin-bottom: 20px;
            padding: 10px;
            background: #f5f5f5;
            border-radius: 5px;
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

        /* Penyesuaian untuk print */
        @media print {
            .print-controls {
                display: none;
            }

            body {
                padding: 0;
            }

            .qr-item {
                break-inside: avoid;
                padding: 20px;
            }

            /* Memastikan QR code tetap sejajar saat print */
            .qr-code,
            .qr-code svg {
                transform: none !important;
                -webkit-transform: none !important;
                -ms-transform: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="print-controls">
        <button class="btn btn-print" onclick="window.print()">
            <i class="fas fa-print"></i> Print QR Codes
        </button>
        <button class="btn btn-close" onclick="window.close()">
            <i class="fas fa-times"></i> Close
        </button>
    </div>

    <div class="qr-grid">
        @foreach ($asetsWithQR as $item)
            <div class="qr-item">
                <div class="qr-code">
                    {!! $item['qrcode'] !!}
                </div>
                <div class="aset-info">
                    <h4>{{ $item['aset']->nama_barang }}</h4>
                    <p>
                        ID: {{ $item['aset']->id }}<br>
                        Jenis: {{ $item['aset']->jenis }}<br>
                        Pengguna: {{ $item['aset']->pengguna }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Memastikan semua SVG QR code tidak memiliki transformasi yang tidak diinginkan
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