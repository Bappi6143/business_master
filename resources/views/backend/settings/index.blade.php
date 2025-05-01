@extends('backend.master')

@section('content')
<div class="container">
    <h2>Settings</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="logo">Logo</label><br>
            <img src="{{ asset(\App\Models\Setting::getValue('logo')) }}" alt="Logo" style="height: 80px;"><br>
            <input type="file" name="logo" class="form-control mt-2">
        </div>
        <div class="form-group mt-3">
            <label for="customer_service_phone">Customer Service Phone</label>
            <input type="text" name="customer_service_phone" class="form-control" value="{{ \App\Models\Setting::getValue('customer_service_phone') }}">
        </div>
        <button type="submit" class="btn btn-primary mt-3">Update</button>
    </form>
</div>
@endsection
