<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
  <title>Kasir | @yield('title', 'Dashboard')</title>
  
  <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet">
  
  <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet">
  
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  
  <link id="pagestyle" href="{{ asset('assets/css/soft-ui-dashboard.css') }}" rel="stylesheet">
  
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="g-sidenav-show bg-gray-100">
  @include('side-nav.sidenav')
  
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">@yield('bread', 'Dashboard')</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">@yield('title', 'Dashboard')</h6>
        </nav>
        
        {{-- <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <form method="GET" action="{{ request()->segment(1) == 'produk' ? route('produk.index') : (request()->segment(1) == 'pembelian' ? route('pembelian.index') : '#') }}">
              <div class="input-group">
                <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                <input
                  type="text"
                  class="form-control"
                  name="search"
                  value="{{ request('search') }}"
                  placeholder="Cari di {{ ucfirst(request()->segment(1)) }}...">
              </div>
            </form>            
          </div> --}}
          
          <ul class="navbar-nav justify-content-end">
            <li class="nav-item d-flex align-items-center">
              <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-danger font-weight-bold px-3">
                  <i class="fa fa-user me-sm-1"></i>
                  <span class="d-sm-inline d-none">Log Out</span>
                </button>
              </form>
            </li>            
            
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li>
            
            <li class="nav-item px-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0">
                <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container-fluid py-4">
      @yield('content')
    </div>
  </main>

  <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
  
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
  
  <script src="{{ asset('assets/js/soft-ui-dashboard.min.js') }}"></script>
  
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      };
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
    
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    });
  </script>
  
  @if(config('app.debug'))
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const assets = [
        '/assets/css/soft-ui-dashboard.css',
        '/assets/js/soft-ui-dashboard.min.js',
        '/assets/img/apple-icon.png'
      ];
      
      assets.forEach(asset => {
        fetch(asset)
          .then(response => {
            if (!response.ok) {
              console.error('Asset not found:', asset);
            }
          })
          .catch(error => {
            console.error('Error loading asset:', asset, error);
          });
      });
    });
  </script>
  @endif
  @stack('scripts')
</body>
</html>