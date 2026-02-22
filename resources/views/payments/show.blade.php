@extends('layouts.master')

@section('content')

<h3 class="text-warning mb-4">سجل دفعات الحجز</h3>

<div class="card bg-dark border-warning shadow-lg mb-4">
    <div class="card-body text-white">
        العميل: <strong>{{ $booking->client->name }}</strong><br>
        إجمالي العقد: {{ number_format($booking->total_price) }} ريال<br>
        المدفوع: {{ number_format($booking->total_paid) }} ريال<br>
        المتبقي:
        <span class="{{ $booking->remaining <= 0 ? 'text-success' : 'text-danger' }}">
            {{ number_format($booking->remaining) }} ريال
        </span>
    </div>
</div>

<div class="card bg-dark border-warning shadow-lg">
    <div class="card-body">

        <table class="table table-dark table-bordered text-center">
            <thead>
                <tr>
                    <th>المبلغ</th>
                    <th>التاريخ</th>
                    <th>ملاحظات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($booking->payments as $payment)
                <tr>
                    <td>{{ number_format($payment->amount) }} ريال</td>
                    <td>{{ $payment->payment_date }}</td>
                    <td>{{ $payment->notes }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3">لا توجد دفعات</td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

@endsection