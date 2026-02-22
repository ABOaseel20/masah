@extends('layouts.master')

@section('content')

<h3 class="text-warning mb-4">التقرير الشهري للإيرادات</h3>

<!-- فورم اختيار الشهر -->
<form method="GET" action="{{ route('reports.monthly') }}" class="mb-4">
    <div class="row">
        <div class="col-md-4">
            <input type="month" name="month" class="form-control"
                   value="{{ $month }}">
        </div>
        <div class="col-md-2">
            <button class="btn btn-warning">عرض</button>
        </div>
    </div>
</form>

<!-- الملخص -->
<div class="card bg-dark border-warning shadow-lg mb-4">
    <div class="card-body text-white">
        الشهر: <strong>{{ $month }}</strong><br>
        عدد العمليات: {{ $count }}<br>
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
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr>
                    <td>{{ $payment->booking->client->name }}</td>
                    <td>{{ number_format($payment->amount) }} ريال</td>
                    <td>{{ $payment->payment_date }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3">لا توجد عمليات في هذا الشهر</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection