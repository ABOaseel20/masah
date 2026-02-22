<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Booking;
use App\Models\Hall;
use Mpdf\Mpdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BookingController extends Controller
{
    // عرض الحجوزات
    public function index()
    {
        $bookings = Booking::with(['client','hall'])->get();
        return view('booking.index', compact('bookings'));
    }

    // عرض صفحة الإضافة
    public function create()
    {
        $halls = Hall::all();
        return view('booking.create', compact('halls'));
    }

    // حفظ الحجز
    public function store(Request $request)
    {
        $exists = Booking::where('hall_id', $request->hall_id)
            ->where('event_date', $request->event_date)
            ->exists();

        if ($exists) {
            return back()->with('error', 'هذه القاعة محجوزة في هذا التاريخ!');
        }

        $client = Client::create([
            'name'  => $request->client_name,
            'phone' => $request->phone,
        ]);

        $remaining = $request->total_price - $request->paid_amount;

        Booking::create([
            'client_id'        => $client->id,
            'hall_id'          => $request->hall_id,
            'event_date'       => $request->event_date,
            'total_price'      => $request->total_price,
            'paid_amount'      => $request->paid_amount,
            'remaining_amount' => $remaining,
            'status'           => 'مؤكد',
        ]);

        return redirect()->route('booking.index')
            ->with('success', 'تم إنشاء الحجز بنجاح');
    }

    // تعديل
    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        $halls = Hall::all();
        return view('booking.edit', compact('booking','halls'));
    }

    // تحديث
    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $booking->update([
            'hall_id' => $request->hall_id,
            'event_date' => $request->event_date,
            'total_price' => $request->total_price,
            'paid_amount' => $request->paid_amount,
            'remaining_amount' => $request->total_price - $request->paid_amount,
        ]);

        return redirect()->route('booking.index')
            ->with('success', 'تم تعديل الحجز');
    }

    // حذف
    public function destroy($id)
    {
        Booking::findOrFail($id)->delete();

        return redirect()->route('booking.index')
            ->with('success', 'تم حذف الحجز');
    }

    // طباعة العقد
    public function print($id)
    {
        $booking = Booking::with(['client','hall'])->findOrFail($id);

        $contractNumber = 'ALMASAH-' . str_pad($booking->id, 5, '0', STR_PAD_LEFT);

        $qrSvg = QrCode::format('svg')
            ->size(120)
            ->generate(route('contract.view', $booking->id));

        $qrSvg = preg_replace('/<\?xml.*?\?>/', '', $qrSvg);

        $html = view('booking.contract', compact(
            'booking',
            'contractNumber',
            'qrSvg'
        ))->render();

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font' => 'dejavusans'
        ]);

        $mpdf->WriteHTML($html);

        return $mpdf->Output('contract_'.$booking->id.'.pdf', 'I');
    }

    // إرسال واتساب
    public function sendWhatsApp($id)
    {
        $booking = Booking::with('client')->findOrFail($id);

        $phone = '966' . ltrim($booking->client->phone, '0');

        $contractNumber = 'ALMASAH-' . str_pad($booking->id, 5, '0', STR_PAD_LEFT);

        $message  = "🎉 قصر الماسة للأفراح\n\n";
        $message .= "تم إنشاء عقدك بنجاح.\n";
        $message .= "رقم العقد: $contractNumber\n\n";
        $message .= "رابط تحميل العقد:\n";
        $message .= route('contract.view', $booking->id);

        $url = "https://wa.me/$phone?text=" . urlencode($message);

        return redirect($url);
    }
}