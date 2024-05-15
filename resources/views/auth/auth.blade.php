<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="js">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="National Inland Waterways Authority, Self Service Portal (NIWA).">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="./assets/images/logo.png">
    <!-- Page Title  -->
    <title>@yield('title') | {{ env('APP_NAME') }}</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="./new/vendors/iconfonts/font-awesome/css/all.min.css">
  <link rel="stylesheet" href="./new/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="./new/vendors/css/vendor.bundle.addons.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="./new/css/style.css">
  <!-- endinject -->
  
  @stack('styles')
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">

        @yield('content')

      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="./new/vendors/js/vendor.bundle.base.js"></script>
  <script src="./new/vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="./new/js/off-canvas.js"></script>
  <script src="./new/js/hoverable-collapse.js"></script>
  <script src="./new/js/misc.js"></script>
  <script src="./new/js/settings.js"></script>
  <script src="./new/js/todolist.js"></script>
  <!-- endinject -->
</body>
@stack('scripts')

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/64ef0da4a91e863a5c10a087/1h92sqjuh';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
</html>
