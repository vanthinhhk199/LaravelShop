<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title')
    </title>

    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">


    {{-- New --}}

     <link href="{{ asset('frontend/css/custom.css') }}" rel="stylesheet">

     <!-- Favicon -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css">

     <!-- Google Web Fonts -->
     <link rel="preconnect" href="https://fonts.gstatic.com">
     <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

     <!-- Font Awesome -->
     <link href="{{ asset('frontend/css/all.min.css') }}" rel="stylesheet">

     <!-- Libraries Stylesheet -->
     <link href="{{ asset('frontend/css/animate.min.css') }}" rel="stylesheet">
     <link href="{{ asset('frontend/css/owl.carousel.min.css') }}" rel="stylesheet">

     <!-- Customized Bootstrap Stylesheet -->
     <link href="{{ asset('frontend/css/style_custom.css') }}" rel="stylesheet">



</head>
<body>
    @include('layouts.inc.frontnavbar')
    <div class="content">
        @yield('content')
    </div>
    @include('layouts.inc.frontfooter')

    {{-- New --}}

    <!-- JavaScript Libraries -->
    <script src="{{ asset('frontend/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/js/easing.min.js') }}"></script>
    <script src="{{ asset('frontend/js/owl.carousel.min.js') }}"></script>

    <!-- Contact Javascript File -->
    <script src="{{ asset('frontend/js/jqBootstrapValidation.min.js') }}"></script>
    <script src="{{ asset('frontend/js/contact.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('frontend/js/main.js') }}"></script>

    <script src="{{ asset('frontend/js/custom.js') }}"></script>

    <script src="{{ asset('frontend/js/sweetalert.min.js') }}"></script>

    {{-- ---------------------------------------}}

    {{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}
    @if (session('status'))
        <script>
            swal("Good job!", "{{ session('status')}}", "success");
        </script>
    @endif
    @if (session('status_er'))
        <script>
            swal("Error!", "{{ session('status_er')}}", "error");
        </script>
    @endif
    @yield('scripts')
</body>
</html>
