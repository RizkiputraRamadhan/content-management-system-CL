<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>@yield('title', $meta->meta_title)</title>

    <!-- Meta Tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="description" content="{{ $meta->meta_description }}" />
    <meta name="keywords" content="{{ $meta->meta_keywords }}" />
    <meta name="author" content="{{ $meta->web_name }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="{{ $meta->meta_title }}">
    <meta property="og:description" content="{{ $meta->meta_description }}">
    <meta property="og:image" content="{{ getFile($meta->og_image) }}">
    <meta property="og:url" content="{{ $meta->domain }}">
    <meta property="og:type" content="website">

    <!-- Favicon & Logo -->
    <link rel="shortcut icon" href="{{ getFile($meta->favicon) }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ getFile($meta->logo) }}">

    <!-- Stylesheets -->
    <link href="{{ asset('dist/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('dist/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('dist/css/style.css') }}" rel="stylesheet" type="text/css">

    <!-- DataTables -->
    <link href="{{ asset('dist/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('dist/plugins/datatables/responsive.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('dist/plugins/datatables/dataTables.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Google Maps -->
    <script src="{{ $meta->google_maps }}"></script>

    <!-- Vite Assets -->
    @vite(['resources/css/styles.css', 'resources/js/script.js'])

    <!-- Additional Styles -->
    @stack('styles')
</head>


<body class="fixed-left">

    <div id="wrapper">
        @include('widget.admin.topbar')
        @include('widget.admin.sidebar')
        <div class="content-page">
            <div class="content">
                <div class="container">
                    @include('widget.admin.page-header-title')
                    @yield('content')
                </div>
            </div>
            <footer class="footer text-center">{{ now()->format('Y') }} © Powered By
                <a href="https://kuliittecno-production.up.railway.app/" target="_blank" class="text-primary">Kuli IT
                    Tecno</a> - All Rights Reserved. V{{ $meta->version }}
            </footer>
        </div>
    </div>

    <!-- jQuery  -->
    <script src="{{ asset('dist/js/jquery.min.js') }}"></script>
    <script src="{{ asset('dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('dist/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('dist/js/detect.js') }}"></script>
    <script src="{{ asset('dist/js/fastclick.js') }}"></script>
    <script src="{{ asset('dist/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('dist/js/jquery.blockUI.js') }}"></script>
    <script src="{{ asset('dist/js/waves.js') }}"></script>
    <script src="{{ asset('dist/js/wow.min.js') }}"></script>
    <script src="{{ asset('dist/js/jquery.nicescroll.js') }}"></script>
    <script src="{{ asset('dist/js/jquery.scrollTo.min.js') }}"></script>
    <script src="{{ asset('dist/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('dist/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dist/plugins/datatables/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('dist/plugins/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('dist/plugins/datatables/responsive.bootstrap.min.js') }}"></script>
    <script src="{{ asset('dist/pages/dashborad.js') }}"></script>
    <script src="{{ asset('dist/plugins/parsleyjs/parsley.min.js') }}"></script>

    <script src="{{ asset('dist/js/app.js') }}"></script>

    @include('components.confrm_session_swal')
    @stack('scripts')

</body>

</html>
