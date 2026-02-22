@extends('layouts.master')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3 class="text-warning">إدارة الحجوزات</h3>
    <a href="{{ route('bookings.create') }}" class="btn btn-warning">
        إضافة حجز جديد
    </a>
</div>

<div class="card bg-dark border-warning shadow">
    <div class="card-body">

        <table class="table table-dark table-hover text-center">
            <thead class="table-warning text-dark">
                <tr>
                    <th>العميل</th>
                    <th>القاعة</th>
                    <th>التاريخ</th>
                    <th>الإجمالي</th>
                    <th>المدفوع</th>
                    <th>المتبقي</th>
                    <th>الاجراءات</th>
                </tr>
            </thead>

            <tbody>
                @foreach($bookings as $booking)
                <tr>
                    <td>{{ $booking->client->name }}</td>
                    <td>{{ $booking->hall->name }}</td>
                    <td>{{ $booking->event_date }}</td>
                    <td>{{ $booking->total_price }}</td>
                    <td>{{ $booking->paid_amount }}</td>
                    <td>{{ $booking->remaining_amount }}</td>
                    <td>

    <!-- زر التعديل -->
    <a href="{{ route('bookings.edit',$booking->id) }}"
       class="btn btn-sm btn-outline-warning me-1"
       title="تعديل">
        <i class="bi bi-pencil-square"></i>
    </a>

    <!-- زر الحذف -->
    <form action="{{ route('bookings.destroy',$booking->id) }}"
          method="POST"
          style="display:inline;">
        @csrf
        @method('DELETE')

        <button type="submit"
                class="btn btn-sm btn-outline-danger"
                title="حذف"
                onclick="return confirm('هل أنت متأكد من حذف الحجز؟')">
            <i class="bi bi-trash3-fill"></i>
        </button>
        <a href="{{ route('bookings.print',$booking->id) }}"
   class="btn btn-sm btn-outline-primary me-1"
   title="طباعة العقد">
    <i class="bi bi-printer-fill"></i>
</a>
<a href="{{ route('bookings.whatsapp', $booking->id) }}"
   class="btn btn-sm btn-success me-1"
   title="إرسال عبر واتساب">
   <i class="bi bi-whatsapp"></i>
</a>
<a href="{{ route('payments.create', $booking->id) }}"
   class="btn btn-sm btn-info me-1"
   title="إضافة دفعة">
   <i class="bi bi-cash-stack"></i>
</a>
<a href="{{ route('payments.show', $booking->id) }}"
   class="btn btn-sm btn-secondary me-1"
   title="سجل الدفعات">
   <i class="bi bi-receipt"></i>
</a>
    </form>

</td>
                </tr>
                @endforeach
            </tbody>

        </table>

    </div>
</div>

@endsection