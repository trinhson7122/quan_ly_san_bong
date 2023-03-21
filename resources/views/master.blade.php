<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>{{ config('app.name') }} - {{ $title }}</title>
    <meta content="Cho thuê sân đá bóng tiện lợi" name="description">
    <meta content="thue san da bong" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    {{-- <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon"> --}}

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.toast.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/jquery.min.js') }}"></script>

    <!-- Template Main CSS File -->
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
</head>

<body>
    @yield('content')
    <!-- Vendor JS Files -->
    <script src="{{ asset('/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    {{-- <script src="https://js.pusher.com/7.2/pusher.min.js"></script> --}}
    <script>
        // // Enable pusher logging - don't include this in production
        // Pusher.logToConsole = false;

        // var pusher = new Pusher('70186e1524c4c44a9000', {
        //     cluster: 'ap1'
        // });

        // var channel = pusher.subscribe('quanlysanbong-channel');
        // channel.bind('pitchType-updated', function(data) {
        //     console.log(data);
        //     $.toast({
        //         heading: 'Thông báo',
        //         text: 'test',
        //         showHideTransition: 'plain',
        //         icon: 'info',
        //         position: 'bottom-right',
        //         stack: 4
        //     })
        // });
    </script>
    <!-- Template Main JS File -->
    <script src="{{ asset('js/jquery.toast.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/ajax.js') }}"></script>
    <script src="{{ asset('js/func.js') }}"></script>

</body>

</html>