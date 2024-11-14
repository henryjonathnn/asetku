<!-- QR Code and Logos Container -->
<div class="qr-container p-4 bg-light border rounded mb-4">
    <!-- QR Code Display -->
    <div class="qr-code-wrapper d-flex justify-content-center align-items-center mb-4">
        <div style="width: 200px; height: 200px;">
            {!! $qrcode !!}
        </div>
    </div>

    <!-- Asset Information -->
    <div class="text-center mb-3 mt-4">
        <h6 class="mb-1">{{ $aset->nama_barang }}</h6>
        <small class="text-muted">{{ $aset->serial_number }}</small>
    </div>

    <!-- Logos Display -->
    <div class="logos d-flex justify-content-center align-items-center gap-3 mb-3">
        <div class="logo-wrapper d-flex align-items-center" style="height: 70px;">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" style="max-height: 100%; width: auto;">
        </div>
        <div class="logo-wrapper d-flex align-items-center" style="height: 40px;">
            <img src="{{ asset('img/it.png') }}" alt="IT Logo" style="max-height: 100%; width: auto;">
        </div>
    </div>

    <!-- Print Button -->
    <button id="printQRButton" class="btn btn-primary w-100 no-print">
        <i class="fas fa-print me-2"></i>Print QR Code
    </button>
</div>

<style>
    .logo-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .logo-wrapper img {
        object-fit: contain;
    }

    @media print {
        @page {
            size: auto;
            margin: 0mm;
        }

        body * {
            visibility: hidden;
        }

        .qr-container,
        .qr-container * {
            visibility: visible;
        }

        .qr-container {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background: white !important;
            padding: 20px;
            margin: 0;
            border: none !important;
        }

        .no-print {
            display: none !important;
        }
    }
</style>

<script>
    // Tunggu sampai dokumen sepenuhnya dimuat
    document.addEventListener('DOMContentLoaded', function() {
        // Tambahkan event listener ke tombol print
        const printButton = document.getElementById('printQRButton');
        if (printButton) {
            printButton.addEventListener('click', function() {
                window.print();
            });
        }
    });
</script>