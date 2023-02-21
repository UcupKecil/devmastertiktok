<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <title>{{ env('APP_NAME') }} | {{ $title }}</title>
    <!--favicon-->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/templates/omexo/assets/images/favicon.png') }}">
    <!--bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/templates/omexo/assets/css/bootstrap.min.css') }}">
    <!--owl carousel css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/templates/omexo/assets/css/owl.carousel.min.css') }}">
    <!--magnific popup css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/templates/omexo/assets/css/magnific-popup.css') }}">
    <!--font awesome css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/templates/omexo/assets/css/font-awesome.min.css') }}">
    <!--meanmenu css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/templates/omexo/assets/css/meanmenu.css') }}">
    <!--animate css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/templates/omexo/assets/css/animate.css') }}">
    <!--main css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/templates/omexo/assets/css/style1.css') }}">
    <!--responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/templates/omexo/assets/css/responsive.css') }}">
    <!--jQuery js-->
    <script src="{{ asset('assets/templates/omexo/assets/js/jquery-3.3.1.min.js') }}"></script>
    @stack('style')
</head>
