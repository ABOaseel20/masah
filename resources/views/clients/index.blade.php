@extends('layouts.master')

@section('content')

<h3 class="text-warning mb-4">قائمة العملاء</h3>

<div class="card bg-dark border-warning shadow-lg">
    <div class="card-body">
        <table class="table table-dark table-bordered text-center">
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>الجوال</th>
                    <th>عدد الحجوزات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clients as $client)
                <tr>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->phone }}</td>
                    <td>{{ $client->bookings_count }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection