@extends('layouts.master')

@section('content')

<h3 class="text-warning mb-4">إضافة دفعة جديدة</h3>

<div class="card bg-dark border-warning shadow-lg">
    <div class="card-body">

        <p class="text-white">
            العميل: <strong>{{ $booking->client->name }}</strong><br>
            إجمالي العقد: {{ number_format($booking->total_price) }} ريال<br>
            المدفوع حتى الآن: {{ number_format($booking->total_paid) }} ريال<br>
            المتبقي:
            <span class="text-danger">
                {{ number_format($booking->remaining) }} ريال
            </span>
        </p>

        <form method="POST" action="{{ route('payments.store') }}">
            @csrf

            <input type="hidden" name="booking_id" value="{{ $booking->id }}">

            <div class="mb-3">
                <label class="form-label text-white">مبلغ الدفعة</label>
                <input type="number" name="amount" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-white">تاريخ الدفعة</label>
                <input type="date" name="payment_date" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-white">ملاحظات</label>
                <textarea name="notes" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-warning">
                حفظ الدفعة
            </button>

        </form>

    </div>
</div>

@endsection