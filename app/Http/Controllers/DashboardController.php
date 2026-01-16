<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Sample data - replace with your actual database queries
        $totalBalance = 80201.50;
        
        $recentTransactions = [
            [
                'type' => 'Paypal - Received',
                'date' => '28 January 2025, 09:20 AM',
                'amount' => 8200.00,
                'status' => 'received',
                'icon' => 'paypal'
            ],
            [
                'type' => 'Spotify Premium',
                'date' => '19 December 2025, 07:55 PM',
                'amount' => -179.00,
                'status' => 'paid',
                'icon' => 'spotify'
            ],
            [
                'type' => 'Transferwise - Received',
                'date' => '17 December 2025, 11:14 AM',
                'amount' => 1200.00,
                'status' => 'received',
                'icon' => 'transferwise'
            ],
            [
                'type' => 'H&M Payment',
                'date' => '15 December 2025, 04:30 PM',
                'amount' => -2200.00,
                'status' => 'paid',
                'icon' => 'hm'
            ]
        ];

        $expensesData = [
            'percentage' => 85.5,
            'level' => 'Normal Level',
            'total' => 1800.80
        ];

        $cardInfo = [
            'number' => '4771 4080 1080 7889',
            'valid_thru' => '08/25',
            'type' => 'Platinum Debit',
            'frozen' => false
        ];

        return view('dashboard.index', compact(
            'totalBalance',
            'recentTransactions',
            'expensesData',
            'cardInfo'
        ));
    }
}