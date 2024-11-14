<div class="qr-container p-4 bg-light border rounded mb-4">
    <div class="d-flex flex-column align-items-center">
        <div class="qr-code-wrapper d-flex justify-content-center align-items-center mb-4">
            <div style="width: 180px; height: 180px;">{!! $qrcode !!}</div>
        </div>
        <div class="text-center mb-3 mt-4">
            <h6 class="mb-1">{{ $aset->nama_barang }}</h6>
            <small class="text-muted">{{ $aset->serial_number }}</small>
        </div>
    </div>
    <div class="logos d-flex justify-content-center align-items-center gap-3 mb-3">
        <div class="logo-wrapper d-flex align-items-center" style="height: 70px;">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" style="max-height: 100%; width: auto;">
        </div>
        <div class="logo-wrapper d-flex align-items-center" style="height: 40px;">
            <img src="{{ asset('img/it.png') }}" alt="IT Logo" style="max-height: 100%; width: auto;">
        </div>
    </div>
    <a id="downloadQRButton" href="#" class="btn btn-primary w-100" download="qr_code.jpg">
        <i class="fas fa-download me-2"></i>Download QR Code
    </a>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const qrCodeElement = document.querySelector('.qr-code-wrapper > div');
        const downloadButton = document.getElementById('downloadQRButton');
        downloadButton?.addEventListener('click', () => {
            html2canvas(qrCodeElement).then(canvas => {
                const imageData = canvas.toDataURL('image/jpeg', 0.9); // Set quality to 90%
                downloadButton.setAttribute('href', imageData);
                downloadButton.setAttribute('download', 'qr_code.jpg');
            });
        });
    });
</script>
