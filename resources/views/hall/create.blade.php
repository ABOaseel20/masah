@extends('layouts.master')

@section('content')

<h3 class="text-warning mb-4">إضافة قاعة جديدة</h3>

<form method="POST" action="{{ route('halls.store') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">اسم القاعة</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">السعة</label>
        <input type="number" name="capacity" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">السعر</label>
        <input type="number" name="price" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">الحالة</label>
        <select name="status" class="form-control">
            <option value="متاحة">متاحة</option>
            <option value="صيانة">صيانة</option>
        </select>
    </div>

    <button type="submit" class="btn btn-warning">حفظ</button>
</form>

@endsection