@extends('layouts.master')

@section('content')

<h3 class="text-warning mb-4">تعديل الحجز</h3>

<div class="card bg-dark border-warning shadow-lg">
    <div class="card-body">

        <form method="POST" action="{{ route('booking.update', $booking->id) }}">
            @csrf
            @method('PUT')

            <!-- اختيار القاعة -->
            <div class="mb-3">
                <label class="form-label text-white fw-bold">القاعة</label>
                <select name="hall_id"
                        class="form-control bg-dark text-white border-warning">
                    @foreach($halls as $hall)
                        <option value="{{ $hall->id }}"
                            {{ $booking->hall_id == $hall->id ? 'selected' : '' }}>
                            {{ $hall->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- التاريخ -->
            <div class="mb-3">
                <label class="form-label text-white fw-bold">تاريخ المناسبة</label>
                <input type="date"
                       name="event_date"
                       value="{{ $booking->event_date->format('Y-m-d') }}"
                       class="form-control bg-dark text-white border-warning">
            </div>

            <!-- إجمالي العقد -->
            <div class="mb-3">
                <label class="form-label text-white fw-bold">إجمالي العقد</label>
                <input type="number"
                       name="total_price"
                       value="{{ $booking->total_price }}"
                       class="form-control bg-dark text-white border-warning">
            </div>

            <!-- المدفوع -->
            <div class="mb-4">
                <label class="form-label text-white fw-bold">المدفوع</label>
                <input type="number"
                       name="paid_amount"
                       value="{{ $booking->paid_amount }}"
                       class="form-control bg-dark text-white border-warning">
            </div>

            <button type="submit" class="btn btn-warning fw-bold">
                حفظ التعديل
            </button>

        </form>

    </div>
</div>

@endsection