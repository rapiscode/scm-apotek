@extends('Dashboard.sidebar')

@section('title', 'APOTEK SAYA - QRIS')
@section('page_title', 'QRIS')
@section('page_subtitle', 'Pembayaran QRIS.')

@section('content')
<div class="min-h-[calc(100vh-180px)] flex items-center justify-center py-10">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10 max-w-3xl w-full text-center">

        <h2 class="text-3xl font-bold text-blue-700 mb-8">
            Scan QRIS untuk Pembayaran
        </h2>

        <div class="flex justify-center mb-8">
            <img
                src="{{ asset('qris/qris-apotek.jpeg') }}"
                alt="QRIS Apotek"
                class="w-[430px] h-[430px] object-contain border rounded-2xl p-3 mx-auto"
            >
        </div>

        <p class="text-lg text-gray-600 mb-2">
            Scan menggunakan aplikasi:
        </p>

        <p class="font-semibold text-gray-800 text-lg mb-6">
            OVO • GoPay • Dana • ShopeePay • Mobile Banking
        </p>

        <div class="bg-blue-50 border border-blue-100 rounded-xl p-5 text-sm text-blue-700 max-w-2xl mx-auto">
            Setelah pembayaran berhasil, silakan tunjukkan bukti pembayaran kepada kasir.
        </div>

    </div>
</div>
@endsection