{{-- MODAL QR CODE --}}
<div class="qr-container p-4 bg-light border rounded mb-4">
    <div class="d-flex flex-column align-items-center">
        <div class="qr-code-wrapper d-flex justify-content-center align-items-center">
            <div style="width: 180px; height: 180px;">{!! $qrcode !!}</div>
        </div>
        <div class="text-center mb-3">
            <h6 class="mb-1">Nomor Aset</h6>
            <small class="text-muted">{{ $aset->nomor_aset }}</small>
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
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const qrCodeElement = document.querySelector('.qr-code-wrapper > div');
    });
</script>
