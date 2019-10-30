<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('vendors/css/vendors.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/css/forms/icheck/icheck.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/css/forms/icheck/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/css/forms/selects/select2.css') }}" rel="stylesheet">

    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="{{ asset('css/colors.css') }}" rel="stylesheet">
    <link href="{{ asset('css/components.css') }}" rel="stylesheet">

    <link href="{{ asset('css/vertical-menu.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/forms/checkboxes-radios.css') }}" rel="stylesheet">
</head>
<body class="vertical-layout vertical-menu 2-columns   fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">
  <!-- BEGIN: Content-->
  @include('templates.navbar')
  @include('templates.sidebar')
  @yield('content')
  <!-- END: Content-->
    <!-- Scripts -->
    <script src="{{ asset('vendors/js/vendors.min.js') }}" defer></script>
    <script src="{{ asset('vendors/js/forms/icheck/icheck.min.js') }}" defer></script>
    <script src="{{ asset('vendors/js/forms/select/select2.full.min.js') }}" defer></script>

    <script src="{{ asset('js/scripts/forms/checkbox-radio.js') }}" defer></script>
    <script src="{{ asset('js/scripts/forms/select/form-select2.js') }}" defer></script>

    <script src="{{ asset('js/custom.js') }}" defer></script>
</body>
</html>
