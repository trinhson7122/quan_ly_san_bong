<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>{{ config('app.name') }} - {{ $title }}</title>
  <meta content="Cho thuê sân đá bóng tiện lợi" name="description">
  <meta content="thue san da bong" name="keywords">

  <!-- Favicons -->
  {{-- <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon"> --}}

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('/vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ asset('/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('/vendor/simple-datatables/style.css') }}" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

  <!-- Template Main CSS File -->
  <link href="{{ asset('/css/style.css') }}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin - v2.5.0
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
  @yield('content')
  <!-- Vendor JS Files -->
  <script src="{{ asset('/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
  <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('70186e1524c4c44a9000', {
      cluster: 'ap1'
    });

    var channel = pusher.subscribe('quanlysanbong-channel');
    channel.bind('pitchType-updated', function(data) {
      //alert(1);
    });
  </script>
  <!-- Template Main JS File -->
  <script src="{{ asset('js/main.js') }}"></script>
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="{{ asset('js/ajax.js') }}"></script>

</body>

</html>