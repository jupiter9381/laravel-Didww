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
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="{{ asset('css/colors.css') }}" rel="stylesheet">
    <link href="{{ asset('css/components.css') }}" rel="stylesheet">
</head>
<body class="vertical-layout vertical-menu 1-column   blank-page blank-page" data-open="click" data-menu="vertical-menu" data-col="1-column">
  <!-- BEGIN: Content-->
  <div class="app-content content">
      <div class="content-wrapper">
          <div class="content-header row">
          </div>
          <div class="content-body">
              <section class="flexbox-container">
                  <div class="col-12 d-flex align-items-center justify-content-center">
                      <div class="col-lg-4 col-md-8 col-10 box-shadow-2 p-0">
                          <div class="card border-grey border-lighten-3 m-0">
                              <div class="card-header border-0">
                                  <div class="card-title text-center">
                                      <div class="p-1"><img src="{{ asset('images/logo/stack-logo-dark.png') }}" alt="branding logo"></div>
                                  </div>
                                  <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2"><span>Login with Stack</span></h6>
                              </div>
                              <div class="card-content">
                                  <div class="card-body">
                                        @yield('content')
                                  </div>
                              </div>
                              <div class="card-footer">
                                  <div class="">
                                      <p class="float-sm-left text-center m-0"><a href="recover-password.html" class="card-link">Recover password</a></p>
                                      <p class="float-sm-right text-center m-0">New to Stack? <a href="register-simple.html" class="card-link">Sign Up</a></p>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </section>

          </div>
      </div>
  </div>
  <!-- END: Content-->
    <!-- Scripts -->
    <script src="{{ asset('vendors/js/vendors.min.js') }}" defer></script>
</body>
</html>
