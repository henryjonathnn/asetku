<!-- QR Code and Logos Container -->
<div class="qr-container p-4 bg-light border rounded mb-4">
    <!-- QR Code Display -->
    <div class="qrcode-wrapper d-flex justify-content-center align-items-center mb-4">
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
    <div class="logos d-flex justify-content-center gap-3 mb-3">
        <img src="{{ asset('img/logo.png') }}" alt="Logo" height="40">
        <img src="{{ asset('img/it.png') }}" alt="IT Logo" height="40">
    </div>

    <!-- Print Button -->
    <button onclick="printQRCode()" class="btn btn-primary w-100">
        <i class="fas fa-print me-2"></i>Print QR Code
    </button>
</div>

<style>

    @media print {
        body * {
            visibility: hidden;
        }

        .btn-print {
            display: none;
        }
    }
</style>

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

    // function printQRCode() {
    //     window.print();
    // }
</script>
