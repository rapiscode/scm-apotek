@extends('Dashboard.sidebar')

@section('title', 'APOTEK SAYA - Penjualan Tertunda')
@section('page_title', 'Penjualan Tertunda')
@section('page_subtitle', 'Kelola transaksi penjualan yang ditunda.')

@section('content')
<div class="h-[calc(100vh-9rem)]">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 h-full flex flex-col">

        <div class="flex items-center justify-between gap-4 flex-wrap mb-3">
            <h2 class="text-3xl font-bold text-blue-700">Penjualan Tertunda</h2>
        </div>

        <div class="flex items-center justify-between gap-3 flex-wrap mb-2">
            <form method="GET" action="{{ route('penjualan.tertunda') }}" class="w-full max-w-xs">
                <div class="relative">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari data"
                        class="w-full pl-4 pr-10 py-2 rounded-lg border border-gray-200 bg-white text-gray-900 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100"
                    >
                    <button
                        type="submit"
                        class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center gap-2 text-gray-500"
                    >
                        <i class="fas fa-bars-staggered text-sm"></i>
                        <i class="fas fa-search text-sm"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="rounded-xl border border-gray-100 overflow-hidden flex-1 flex flex-col">
            <div class="overflow-x-auto overflow-y-auto flex-1">
                <table class="min-w-[1200px] w-full text-sm">
                    <thead class="bg-gray-50 text-gray-700 sticky top-0 z-10">
                        <tr>
                            <th class="text-left px-4 py-3 font-semibold w-16">No.</th>
                            <th class="text-center px-4 py-3 font-semibold min-w-[160px]">Tanggal</th>
                            <th class="text-center px-4 py-3 font-semibold min-w-[180px]">No. Draft</th>
                            <th class="text-left px-4 py-3 font-semibold min-w-[420px]">Produk</th>
                            <th class="text-center px-4 py-3 font-semibold min-w-[160px]">Total Penjualan</th>
                            <th class="text-center px-4 py-3 font-semibold min-w-[140px]">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white">
                        @forelse($penjualans as $index => $item)
                            <tr class="border-t border-gray-100">
                                <td class="px-4 py-4 align-top">{{ $index + 1 }}</td>

                                <td class="px-4 py-4 align-top text-center text-gray-700">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}<br>
                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('H:i') }}
                                </td>

                                <td class="px-4 py-4 align-top text-center text-gray-800">
                                    {{ $item->no_struk }}
                                </td>

                                <td class="px-4 py-4 align-top text-gray-700">
                                    @forelse($item->details as $detail)
                                        <div>
                                            {{ $detail->qty }} {{ $detail->satuan }} x {{ $detail->produk->nama_produk ?? '-' }}
                                        </div>
                                    @empty
                                        -
                                    @endforelse
                                </td>

                                <td class="px-4 py-4 align-top text-center text-gray-800 font-medium">
                                    Rp {{ number_format($item->total_penjualan, 2, ',', '.') }}
                                </td>

                                <td class="px-4 py-4 align-top text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a
                                            href="{{ route('penjualan.kasir.lanjutkan', $item->id) }}"
                                            class="inline-flex items-center px-4 py-2 rounded-lg border border-blue-400 text-blue-600 text-xs font-semibold hover:bg-blue-50"
                                        >
                                            Lanjutkan
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route('penjualan.tertunda.destroy', $item->id) }}"
                                            onsubmit="return confirm('Yakin ingin menghapus draft ini?')"
                                            class="inline-flex"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="text-red-500 hover:text-red-700"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="border-t border-gray-100">
                                <td colspan="6" class="text-center py-24 text-gray-500">
                                    Data penjualan tertunda belum ada
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection