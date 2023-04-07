<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>{{ config('app.name') }}</title>
    <meta name="robots" content="noindex, nofollow">
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    {{-- <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon"> --}}

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('client/css/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('client/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('client/css/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('client/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('client/css/app.css') }}" rel="stylesheet">

</head>

<body>
    @yield('content')
    <!-- Vendor JS Files -->
    <script src="{{ asset('client/js/aos.js') }}"></script>
    {{-- <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script> --}}
    <script src="https://bootstrapmade.com/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('client/js/glightbox.min.js') }}"></script>
    {{-- <script src="{{ asset('client/js/isotope.pkgd.min.js') }}"></script> --}}
    <script src="https://bootstrapmade.com/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="{{ asset('client/js/swiper-bundle.min.js') }}"></script>
    {{-- <script src="{{ asset('client/js/noframework.waypoints.js') }}"></script> --}}
    <script src="https://bootstrapmade.com/assets/vendor/waypoints/noframework.waypoints.js"></script>

    <!-- Template Main JS File -->
    {{-- <script src="{{ asset('client/js/main.js') }}"></script> --}}
    <script src="https://bootstrapmade.com/demo/templates/Arsha/assets/js/main.js"></script>
</body>

</html>
