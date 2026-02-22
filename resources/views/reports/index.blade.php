@extends('layouts.master')

@section('content')

<h3 class="text-warning mb-4">مركز التقارير</h3>

<div class="row">
    <div class="col-md-4">
        <a href="{{ route('reports.daily') }}" class="btn btn-warning w-100 mb-3">
            التقرير اليومي
        </a>
    </div>

    <div class="col-md-4">
        <a href="{{ route('reports.monthly') }}" class="btn btn-secondary w-100 mb-3">
            التقرير الشهري
        </a>
    </div>

   
</div>

@endsection