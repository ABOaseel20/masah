<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Hall;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBookings = Booking::count();
        $totalRevenue  = Payment::sum('amount');

        $todayRevenue = Payment::whereDate('payment_date', Carbon::today())
            ->sum('amount');

        $monthRevenue = Payment::whereMonth('payment_date', Carbon::now()->month)
            ->whereYear('payment_date', Carbon::now()->year)
            ->sum('amount');

        // رسم بياني الشهر الحالي
        $dailyData = Payment::selectRaw('DAY(payment_date) as day, SUM(amount) as total')
            ->whereMonth('payment_date', Carbon::now()->month)
            ->whereYear('payment_date', Carbon::now()->year)
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $chartLabels = $dailyData->pluck('day');
        $chartData   = $dailyData->pluck('total');

        // مناسبات قادمة خلال 7 أيام
        $upcomingBookings = Booking::with('client')
            ->whereBetween('event_date', [now(), now()->addDays(7)])
            ->get();

        // عقود غير مكتملة الدفع
        $unpaidBookings = Booking::with('client')
            ->whereColumn('total_price', '>', 'paid_amount')
            ->get();

        // أفضل قاعة هذا الشهر
        $topHall = Hall::withCount(['bookings' => function($q){
            $q->whereMonth('event_date', now()->month);
        }])->orderByDesc('bookings_count')->first();

        return view('dashboard.index', compact(
            'totalBookings',
            'totalRevenue',
            'todayRevenue',
            'monthRevenue',
            'chartLabels',
            'chartData',
            'upcomingBookings',
            'unpaidBookings',
            'topHall'
        ));
    }
}