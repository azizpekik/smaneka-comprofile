<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <title>@yield('title', 'SMANeka - School Management System')</title>
  <meta name="description" content="@yield('description', 'Sistem Manajemen Sekolah SMANeka')">

  <!-- Favicons -->
  @if(setting('favicon'))
  <link href="{{ asset('storage/' . setting('favicon')) }}" rel="icon">
  @else
  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
  @endif
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('vendors/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendors/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('vendors/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('vendors/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendors/glightbox/css/glightbox.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

  @stack('styles')
</head>

<body class="@yield('body-class', 'index-page')">

  @include('partials.header')

  <main class="main">
    @yield('content')
  </main>

  @include('partials.footer')

  <!-- Vendor JS Files -->
  <script src="{{ asset('vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('vendors/aos/aos.js') }}"></script>
  <script src="{{ asset('vendors/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('vendors/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('vendors/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('vendors/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
  <script src="{{ asset('vendors/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('vendors/php-email-form/validate.js') }}"></script>

  <!-- Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

  @stack('scripts')
</body>
</html>
