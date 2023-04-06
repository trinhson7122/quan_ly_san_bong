@extends('master')
@section('content')
    @include('client.layouts.header')
    @include('client.layouts.sidebar')
    @yield('client_content')
    @include('client.layouts.footer')
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
@endsection