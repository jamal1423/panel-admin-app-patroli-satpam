<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed " dir="ltr" data-theme="theme-default" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Dashboard - Admin | Sistem Informasi Security</title>
    
    <meta name="description" content="SMKN 1 Wongsorejo" />
    <meta name="keywords" content="SMKN 1 Wongsorejo">
        
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('gambar-umum/logo.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap" rel="stylesheet">

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/boxicons.css') }}" />
    
    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/trix.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/sweetalert.css') }}">

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <!-- Page CSS -->
    
    <style>
      trix-toolbar [data-trix-button-group="file-tools"],
      trix-toolbar [data-trix-attribute='quote'],
      trix-toolbar [data-trix-attribute='code'],
      trix-toolbar [data-trix-attribute='heading1'] {
        display: none;
      }
    </style>

    @stack('styles')
    
    <!-- Helpers -->
    <script src="{{ asset('admin/assets/vendor/js/helpers.js') }}"></script>

    <script src="{{ asset('admin/assets/js/config.js') }}"></script>
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async="async" src="https://www.googletagmanager.com/gtag/js?id=GA_MEASUREMENT_ID"></script>
    <script>
      window.dataLayer = window.dataLayer || [];

      function gtag() {
        dataLayer.push(arguments);
      }
      gtag('js', new Date());
      gtag('config', 'GA_MEASUREMENT_ID');
    </script>

</head>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar  ">
      <div class="layout-container">
      
      <!-- MENU NAV -->
      @include('admin.partials.menu-nav')

      <div class="layout-page">
          <!-- Menu Header -->
          @include('admin.partials.header')
      
          <!-- Content wrapper -->
          <div class="content-wrapper">
          
          <div class="container-xxl flex-grow-1 container-p-y">
              <!-- isi content -->
              @yield('content')  
          </div>
          
          @include('admin.partials.footer')
          
          <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
      </div>
      <!-- / Layout page -->
      </div>
      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
  </div>
  <!-- / Layout wrapper -->

  <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->
  <script src="{{ asset('admin/assets/vendor/libs/jquery/jquery.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/libs/popper/popper.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/js/bootstrap.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
  
  <script src="{{ asset('admin/assets/vendor/js/menu.js') }}"></script>
  <!-- endbuild -->

  <!-- Vendors JS -->
  <script src="{{ asset('admin/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

  <!-- Main JS -->
  <script src="{{ asset('admin/assets/js/main.js') }}"></script>

  
  <script src="{{ asset('admin/assets/js/trix.js') }}"></script>
  <script>
  document.addEventListener('trix-file-accept', function(e) {
    e.preventDefault();
  });
  </script>

  <!-- Modals -->
  <script src="{{ asset('admin/assets/js/ui-modals.js') }}"></script>
  <script src="{{ asset('admin/assets/js/ui-toasts.js') }}"></script>

  <script>
    $(document).ready(function() {
			$.ajax({
				url: "/get-data-dashboard",
				type: "GET",
				dataType: "JSON",
				success: function(data) {
          let {
            dataUser,
            // totalKelas,
            // totalSiswa,
            // totalLokasi,
          } = data

					$('#nama1').text(dataUser.fullname);
					$('#nama2').text(dataUser.fullname);
					$('#role').text(dataUser.role);
					// $('#totalKelas').text(totalKelas);
					// $('#totalSiswa').text(totalSiswa);
					// $('#totalLokasi').text(totalLokasi);
				}
			});
    });
  </script>

@stack('scripts')
</body>
</html>
