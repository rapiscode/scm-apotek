@extends('Dashboard.sidebar')

@section('title', 'APOTEK SAYA - QRIS')
@section('page_title', 'QRIS')
@section('page_subtitle', 'Pembayaran QRIS.')

@section('content')
<div class="min-h-[calc(100vh-180px)] flex items-center justify-center py-10">
    <div class="bg-white dark:bg-gray-950 rounded-2xl shadow-sm border dark:border-gray-800 border-gray-100 p-10 max-w-3xl w-full text-center">

        <h2 class="text-3xl font-bold text-blue-700 mb-8">
            Scan QRIS untuk Pembayaran
        </h2>

        <div class="flex justify-center mb-8">
            <img
                src="{{ asset('qris/qris-apotek.jpeg') }}"
                alt="QRIS Apotek"
                class="w-[430px] h-[430px] object-contain border dark:border-gray-900 rounded-2xl p-3 mx-auto"
            >
        </div>

        <p class="text-lg text-gray-600 mb-2">
            Scan menggunakan aplikasi:
        </p>

        <p class="font-semibold text-gray-700 text-lg mb-6">
            OVO • GoPay • Dana • ShopeePay • Mobile Banking
        </p>

        <div class="bg-blue-50 border dark:bg-blue-950 border-blue-100 dark:border-blue-800 rounded-xl p-5 text-sm text-blue-700 dark:text-white max-w-2xl mx-auto">
            Setelah pembayaran berhasil, silakan tunjukkan bukti pembayaran kepada kasir.
        </div>

    </div>
</div>
@endsection