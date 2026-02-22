public function yearlyReport(Request $request)
{
    $year = $request->year ?? now()->year;

    $monthlyData = [];

    for ($m = 1; $m <= 12; $m++) {
        $total = \App\Models\Payment::whereYear('payment_date', $year)
            ->whereMonth('payment_date', $m)
            ->sum('amount');

        $monthlyData[] = $total;
    }

    // إجمالي السنة
    $yearTotal = array_sum($monthlyData);

    // عدد العمليات
    $yearCount = \App\Models\Payment::whereYear('payment_date', $year)->count();

    // أفضل شهر
    $bestMonthValue = max($monthlyData);
    $bestMonthIndex = array_search($bestMonthValue, $monthlyData) + 1;

    // أفضل القاعات
    $topHalls = \App\Models\Payment::with('booking.hall')
        ->whereYear('payment_date', $year)
        ->get()
        ->groupBy(function ($payment) {
            return $payment->booking->hall->name ?? 'غير محدد';
        })
        ->map(function ($group) {
            return $group->sum('amount');
        })
        ->sortDesc()
        ->take(3);

    return view('payments.yearly', compact(
        'year',
        'monthlyData',
        'bestMonthIndex',
        'bestMonthValue',
        'yearTotal',
        'yearCount',
        'topHalls'
    ));
}