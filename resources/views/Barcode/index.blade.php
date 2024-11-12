@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>QR Code Aset</h4>
            </div>
            <div class="card-body text-center">
                <div style="width: {{ $width }}px; height: {{ $height }}px;">
                    {!! $qrcode !!}
                </div>
            </div>
        </div>
    </div>
@endsection