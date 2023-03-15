{{-- Thông báo khi tác động --}}
@if (session()->has('message'))
<div class="alert alert-success">{{ session()->get('message') }}</div>
@endif
{{-- Thông báo nếu có lỗi đầu vào --}}
@if ($errors->any())
@foreach ($errors->all() as $item)
    <div class="alert alert-danger">{{ $item }}</div>
@endforeach
@endif