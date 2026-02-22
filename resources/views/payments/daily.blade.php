@extends('layouts.master')

@section('content')

<h3 class="text-warning mb-4">التقرير اليومي للإيرادات</h3>

<!-- فورم اختيار التاريخ -->
<form method="GET" action="{{ route('reports.daily') }}" class="mb-4">
    <div class="row">
        <div class="col-md-4">
            <input type="date" name="date" class="form-control"
                   value="{{ $date }}">
        </div>
        <div class="col-md-2">
            <button class="btn btn-warning">عرض</button>
        </div>
    </div>
</form>

<!-- ملخص -->
<div class="card bg-dark border-warning shadow-lg mb-4">
    <div class="card-body text-white">
        التاريخ: <strong>{{ $date }}</strong><br>
        إجمالي الإيرادات:
        <span class="text-success">
            {{ number_format($total) }} ريال
        </span>
    </div>
</div>

<!-- جدول العمليات -->
<div class="card bg-dark border-warning shadow-lg">
    <div class="card-body">
        <table class="table table-dark table-bordered text-center">
            <thead>
                <tr>
                    <th>العميل</th>
                    <th>المبلغ</th>
                    <th>تاريخ الدفع</th>
                    <th>ملاحظات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr>
                    <td>{{ $payment->booking->client->name }}</td>
                    <td>{{ number_format($payment->amount) }} ريال</td>
                    <td>{{ $payment->payment_date }}</td>
                    <td>{{ $payment->notes }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">لا توجد عمليات في هذا اليوم</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection