@extends('Dashboard.sidebar')

@section('title', 'FinBank - Dashboard')
@section('page_title', 'Welcome to FinBank')
@section('page_subtitle', 'Hi, ' . (auth()->user()->name ?? 'User') . ', Welcome back!')

@section('content')
    <div class="grid grid-cols-3 gap-6">
        <!-- Left Column -->
        <div class="col-span-2 space-y-6">
            <!-- Card Section -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold">Debit Card Account</h2>
                    <button class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
                </div>

                <div class="flex items-center space-x-6">
                    <!-- Card -->
                    <div class="card-3d relative w-80 h-48 bg-linear-to-br from-teal-600 to-teal-800 rounded-2xl p-6 text-white">
                        <div class="flex justify-between items-start mb-8">
                            <div>
                                <p class="text-xs opacity-80">{{ $cardInfo['type'] }}</p>
                                <p class="text-sm font-semibold mt-1">
                                    {{ $cardInfo['frozen'] ? 'Frozen' : 'Platinum Debit' }}
                                </p>
                            </div>
                            <i class="fas fa-wifi text-2xl opacity-80 rotate-90"></i>
                        </div>

                        <div class="mb-6">
                            <i class="fas fa-credit-card text-3xl opacity-80"></i>
                        </div>

                        <div class="flex justify-between items-end">
                            <div>
                                <p class="text-xs opacity-80 mb-1">{{ $cardInfo['number'] }}</p>
                                <p class="text-xs opacity-60">Valid Thru: {{ $cardInfo['valid_thru'] }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold">VISA</p>
                            </div>
                        </div>
                    </div>

                    <!-- Add Card Button -->
                    <div class="flex flex-col items-center justify-center w-32 h-48 bg-gray-100 rounded-2xl cursor-pointer hover:bg-gray-200 transition">
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center mb-2">
                            <i class="fas fa-plus text-gray-400"></i>
                        </div>
                        <p class="text-xs text-gray-600">Add Debit Card</p>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold">Recent Transactions</h2>
                    <div class="flex items-center space-x-2">
                        <button class="p-2 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-search text-gray-400"></i>
                        </button>
                        <button class="text-sm text-blue-600 hover:text-blue-700">Last 7 Days</button>
                    </div>
                </div>

                <div class="space-y-4">
                    @foreach($recentTransactions as $transaction)
                        <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center
                                    {{ $transaction['icon'] == 'paypal' ? 'bg-blue-100' : '' }}
                                    {{ $transaction['icon'] == 'spotify' ? 'bg-green-100' : '' }}
                                    {{ $transaction['icon'] == 'transferwise' ? 'bg-blue-100' : '' }}
                                    {{ $transaction['icon'] == 'hm' ? 'bg-red-100' : '' }}">
                                    @if($transaction['icon'] == 'paypal')
                                        <i class="fab fa-paypal text-blue-600"></i>
                                    @elseif($transaction['icon'] == 'spotify')
                                        <i class="fab fa-spotify text-green-600"></i>
                                    @elseif($transaction['icon'] == 'transferwise')
                                        <i class="fas fa-exchange-alt text-blue-600"></i>
                                    @else
                                        <i class="fas fa-shopping-bag text-red-600"></i>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-medium">{{ $transaction['type'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $transaction['date'] }}</p>
                                </div>
                            </div>

                            <span class="font-semibold {{ $transaction['amount'] > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $transaction['amount'] > 0 ? '+' : '' }}${{ number_format(abs($transaction['amount']), 2) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Invoice Activity -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold">Invoice Activity</h2>
                    <div class="flex items-center space-x-2">
                        <button class="p-2 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-search text-gray-400"></i>
                        </button>
                        <button class="p-2 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-filter text-gray-400"></i>
                        </button>
                        <button class="p-2 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-download text-gray-400"></i>
                        </button>
                    </div>
                </div>

                <table class="w-full">
                    <thead>
                    <tr class="text-xs text-gray-500 border-b">
                        <th class="text-left py-3 font-medium">DATE & TIME</th>
                        <th class="text-left py-3 font-medium">INVOICE NUMBER</th>
                        <th class="text-left py-3 font-medium">RECIPIENT</th>
                        <th class="text-left py-3 font-medium">STATUS</th>
                        <th class="text-left py-3 font-medium">ACTION</th>
                        <th class="text-right py-3 font-medium">AMOUNT</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td colspan="6" class="text-center py-8 text-gray-400">No invoice data available</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            <!-- Total Balance -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-sm text-gray-600 mb-2">Your Total Balance</h3>
                <h2 class="text-4xl font-bold text-gray-900 mb-1">${{ number_format($totalBalance, 2) }}</h2>
                <p class="text-xs text-gray-500">December 31, 2025 • 10:00 PM</p>

                <div class="grid grid-cols-3 gap-2 mt-6">
                    <button class="flex flex-col items-center justify-center py-3 bg-gray-50 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-paper-plane text-blue-600 mb-1"></i>
                        <span class="text-xs">Send</span>
                    </button>
                    <button class="flex flex-col items-center justify-center py-3 bg-gray-50 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-sync text-blue-600 mb-1"></i>
                        <span class="text-xs">Request</span>
                    </button>
                    <button class="flex flex-col items-center justify-center py-3 bg-gray-50 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-ellipsis-h text-blue-600 mb-1"></i>
                        <span class="text-xs">More</span>
                    </button>
                </div>
            </div>

            <!-- Expenses Instead -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold">Expenses Instead</h3>
                    <button class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
                </div>

                <div class="flex justify-center mb-4">
                    <div class="relative w-40 h-40">
                        <svg class="transform -rotate-90 w-40 h-40">
                            <circle cx="80" cy="80" r="70" stroke="#E5E7EB" stroke-width="12" fill="none"/>
                            <circle cx="80" cy="80" r="70"
                                    stroke="url(#gradient)"
                                    stroke-width="12"
                                    fill="none"
                                    stroke-dasharray="{{ 2 * 3.14159 * 70 }}"
                                    stroke-dashoffset="{{ 2 * 3.14159 * 70 * (1 - $expensesData['percentage']/100) }}"
                                    stroke-linecap="round"/>
                            <defs>
                                <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#14B8A6;stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:#0D9488;stop-opacity:1" />
                                </linearGradient>
                            </defs>
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-3xl font-bold">
                                {{ $expensesData['percentage'] }}<span class="text-lg">%</span>
                            </span>
                            <span class="text-xs text-gray-500 mt-1">{{ $expensesData['level'] }}</span>
                        </div>
                    </div>
                </div>

                <p class="text-center text-sm text-gray-600">
                    Total Exp: <span class="font-semibold">${{ number_format($expensesData['total'], 2) }}</span>
                </p>
            </div>
        </div>
    </div>
@endsection
