@extends('layouts.master')

@section('content')

<div class="row mb-4">
    <div class="col-md-6">
        <h3 class="text-warning">إدارة القاعات</h3>
    </div>
    <div class="col-md-6 text-start">
        <a href="{{ route('halls.create') }}" class="btn btn-warning">
            إضافة قاعة جديدة
        </a>
    </div>
</div>

<div class="card bg-dark border-warning shadow-lg">
    <div class="card-body">

        <table class="table table-dark table-striped table-hover text-center align-middle mb-0">
            <thead class="table-warning text-dark">
                <tr>
                    <th>اسم القاعة</th>
                    <th>السعة</th>
                    <th>السعر</th>
                    <th>الحالة</th>
                </tr>
            </thead>

            <tbody>
                @forelse($halls as $hall)
                <tr>
                    <td>{{ $hall->name }}</td>
                    <td>{{ $hall->capacity }}</td>
                    <td>{{ $hall->price }} ريال</td>
                    <td>
                        <span class="badge bg-success">
                            {{ $hall->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">لا توجد قاعات مضافة بعد</td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </div>
</div>

@endsection