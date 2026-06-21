<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Transaction;
use App\Models\VisitSchedule;


class DashboardController extends Controller
{
    public function index()
{
    $totalRevenue = Transaction::where('payment_status', 'success')->sum('amount_paid');
    $totalProperties = Property::count();
    $unitsSold = Property::where('status', 'sold')->count();

    $salesData = Transaction::selectRaw('MONTHNAME(created_at) as month, MONTH(created_at) as month_num, SUM(amount_paid) as total')
    ->where('payment_status', 'success')
    ->groupBy('month', 'month_num')
    ->orderBy('month_num', 'asc')
    ->take(6)
    ->get();

    $statusCounts = [
        'available' => Property::where('status', 'available')->count(),
        'sold'      => Property::where('status', 'sold')->count(),
        'booked'    => Property::where('status', 'booked')->count(),
    ];

    $recentProperties = Property::latest()->take(5)->get();

    $pendingVisits = VisitSchedule::where('status', 'pending')->with(['user', 'property'])->latest()->take(5)->get();
    $pendingVisitCount = VisitSchedule::where('status', 'pending')->count();

    return view('admin.dashboard', compact(
        'totalRevenue', 'totalProperties', 'unitsSold',
        'salesData', 'statusCounts', 'recentProperties',
        'pendingVisits', 'pendingVisitCount'
    ));
}
}
