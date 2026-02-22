@extends('layouts.master')

@section('content')

<h3 class="text-warning mb-4">إضافة حجز جديد</h3>

<div class="card bg-dark border-warning shadow">
    <div class="card-body">

        <form method="POST" action="{{ route('booking.store') }}">
            @csrf

            <!-- اسم العميل -->
            <div class="mb-3">
                <label class="form-label text-white" >اسم العميل</label>
                <input type="text" name="client_name" class="form-control" required>
            </div>

            <!-- رقم الجوال -->
            <div class="mb-3">
                <label class="form-label text-white">رقم الجوال</label>
                <input type="text" name="phone" class="form-control" required>
            </div>

            <!-- اختيار القاعة -->
            <div class="mb-3">
                <label class="form-label text-white">اختر القاعة</label>
                <select name="hall_id" class="form-control" required>
                    @foreach($halls as $hall)
                        <option value="{{ $hall->id }}">
                            {{ $hall->name }} - {{ $hall->price }} ريال
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- تاريخ المناسبة -->
            <div class="mb-3">
                <label class="form-label text-white">تاريخ المناسبة</label>
                <input type="date" name="event_date" class="form-control" required>
            </div>

            <!-- إجمالي السعر -->
            <div class="mb-3">
                <label class="form-label text-white">إجمالي العقد</label>
                <input type="number" name="total_price" class="form-control" required>
            </div>

            <!-- المدفوع -->
            <div class="mb-3">
                <label class="form-label text-white">المبلغ المدفوع</label>
                <input type="number" name="paid_amount" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-warning">حفظ الحجز</button>

        </form>

    </div>
</div>

@endsection