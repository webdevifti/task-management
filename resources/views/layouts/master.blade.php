<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-dataTable/dataTables.bootstrap5.css') }}">
    {{-- <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('assets/vendor/iziToast/dist/css/iziToast.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
   

    @yield('styles')
</head>

<body>
    @include('layouts.header')
    @include('layouts.sidebar')

    @yield('main_content')

    @include('layouts.footer')

    <script src="{{ asset('assets/vendor/jquery/jquery-3.7.1.js') }}"></script>
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-dataTable/dataTables.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-dataTable/dataTables.bootstrap5.js') }}"></script>
    {{-- <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script> --}}
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/vendor/iziToast/dist/js/iziToast.js') }}"></script>
    
    
    @yield('scripts')

    @if (session()->has('success'))
        <script>
            iziToast.success({
                position: 'topRight',
                message: "{{ session()->get('success') }}"
            });
        </script>
    @endif
    @if (session()->has('error'))
        <script>
            iziToast.error({
                position: 'topRight',
                message: "{{ session()->get('error') }}"
            });
        </script>
    @endif
</body>

</html>
