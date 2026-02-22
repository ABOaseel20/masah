@extends('layouts.master')

@section('content')

<h3 class="text-warning mb-4">لوحة التحكم</h3>

<!-- الإحصائيات -->
<div class="row mb-4">

    <div class="col-md-3">
        <div class="card bg-dark text-white text-center p-3">
            <h6>إجمالي الحجوزات</h6>
            <h3 class="counter" data-target="{{ $totalBookings }}">0</h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-dark text-white text-center p-3">
            <h6>إجمالي الإيرادات</h6>
            <h3 class="counter" data-target="{{ $totalRevenue }}">0</h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-dark text-white text-center p-3">
            <h6>إيرادات اليوم</h6>
            <h3 class="counter" data-target="{{ $todayRevenue }}">0</h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-dark text-white text-center p-3">
            <h6>إيرادات الشهر</h6>
            <h3 class="counter" data-target="{{ $monthRevenue }}">0</h3>
        </div>
    </div>

</div>

<!-- أفضل قاعة -->
@if($topHall)
<div class="card bg-dark text-white p-3 mb-4">
    <h5>أفضل قاعة هذا الشهر</h5>
    <strong>{{ $topHall->name }}</strong>
</div>
@endif

<!-- تنبيه مناسبات قادمة -->
@if($upcomingBookings->count())
<div class="card bg-dark text-white p-3 mb-4 border-warning">
    <h5>مناسبات خلال 7 أيام</h5>
    <ul>
        @foreach($upcomingBookings as $booking)
            <li>{{ $booking->client->name }} - {{ $booking->event_date }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- تنبيه عقود غير مكتملة -->
@if($unpaidBookings->count())
<div class="card bg-dark text-white p-3 mb-4 border-danger">
    <h5>عقود غير مكتملة الدفع</h5>
    <ul>
        @foreach($unpaidBookings as $booking)
            <li>
                {{ $booking->client->name }} -
                المتبقي:
                {{ number_format($booking->total_price - $booking->paid_amount) }} ريال
            </li>
        @endforeach
    </ul>
</div>
@endif

<!-- الرسم البياني -->
<div class="card bg-dark text-white p-4">
    <canvas id="revenueChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// عدادات متحركة
document.querySelectorAll('.counter').forEach(counter=>{
    const update=()=>{
        const target=+counter.dataset.target;
        const current=+counter.innerText;
        const inc=target/100;
        if(current<target){
            counter.innerText=Math.ceil(current+inc);
            setTimeout(update,20);
        }else{
            counter.innerText=target.toLocaleString();
        }
    };
    update();
});

// رسم بياني
new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
        labels: @json($chartLabels),
        datasets: [{
            label: 'إيرادات الشهر الحالي',
            data: @json($chartData),
            borderWidth: 2,
            tension: 0.3
        }]
    }
});
</script>

@endsection