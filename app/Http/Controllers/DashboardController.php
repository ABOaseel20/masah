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
        // إجمالي الحجوزات
        $totalBookings = Booking::count();

        // إجمالي الإيرادات
        $totalRevenue = Payment::sum('amount');

        // إيرادات اليوم
        $todayRevenue = Payment::whereDate('payment_date', Carbon::today())
            ->sum('amount');

        // إيرادات الشهر الحالي
        $monthRevenue = Payment::whereMonth('payment_date', Carbon::now()->month)
            ->whereYear('payment_date', Carbon::now()->year)
            ->sum('amount');

        // ===== رسم بياني للشهر الحالي (حل آمن بدون DAY()) =====
        $paymentsThisMonth = Payment::whereMonth('payment_date', Carbon::now()->month)
            ->whereYear('payment_date', Carbon::now()->year)
            ->get();

        $dailyData = $paymentsThisMonth
            ->groupBy(function ($item) {
                return Carbon::parse($item->payment_date)->day;
            })
            ->map(function ($day) {
                return $day->sum('amount');
            });

        $chartLabels = $dailyData->keys();
        $chartData   = $dailyData->values();

        // مناسبات قادمة خلال 7 أيام
        $upcomingBookings = Booking::with('client')
            ->whereBetween('event_date', [now(), now()->addDays(7)])
            ->get();

        // عقود غير مكتملة الدفع
        $unpaidBookings = Booking::with('client')
            ->whereColumn('total_price', '>', 'paid_amount')
            ->get();

        // أفضل قاعة هذا الشهر
        $topHall = Hall::withCount(['bookings' => function ($q) {
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
