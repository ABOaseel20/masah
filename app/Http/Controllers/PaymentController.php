<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Booking;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MonthlyReportExport;

class PaymentController extends Controller
{

    /* ===============================
       عرض صفحة إضافة دفعة
    =============================== */

    public function create($booking_id)
    {
        $booking = Booking::with('client')->findOrFail($booking_id);
        return view('payments.create', compact('booking'));
    }


    /* ===============================
       حفظ الدفعة
    =============================== */

    public function store(Request $request)
    {
        $booking = Booking::findOrFail($request->booking_id);

        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_date' => 'required|date'
        ]);

        if ($request->amount > $booking->remaining_amount) {
            return back()->with('error', 'المبلغ أكبر من المتبقي!');
        }

        Payment::create([
            'booking_id' => $booking->id,
            'amount' => $request->amount,
            'payment_date' => $request->payment_date,
            'notes' => $request->notes
        ]);

        return redirect()->route('payments.show', $booking->id)
            ->with('success', 'تم إضافة الدفعة بنجاح');
    }


    /* ===============================
       عرض دفعات عقد معين
    =============================== */

    public function show($booking_id)
    {
        $booking = Booking::with(['client','payments'])->findOrFail($booking_id);
        return view('payments.show', compact('booking'));
    }


    /* ===============================
       التقرير اليومي
    =============================== */

    public function dailyReport(Request $request)
    {
        $date = $request->date ?? Carbon::today()->toDateString();

        $payments = Payment::with('booking.client')
            ->whereDate('payment_date', $date)
            ->get();

        $total = $payments->sum('amount');
        $count = $payments->count();

        return view('payments.daily', compact('payments','total','count','date'));
    }


    /* ===============================
       التقرير الشهري
    =============================== */

    public function monthlyReport(Request $request)
    {
        $month = $request->month ?? now()->format('Y-m');

        $year  = substr($month, 0, 4);
        $monthNumber = substr($month, 5, 2);

        $payments = Payment::with('booking.client')
            ->whereYear('payment_date', $year)
            ->whereMonth('payment_date', $monthNumber)
            ->get();

        $total = $payments->sum('amount');
        $count = $payments->count();

        return view('payments.monthly', compact(
            'payments',
            'total',
            'count',
            'month'
        ));
    }


}

   
    

