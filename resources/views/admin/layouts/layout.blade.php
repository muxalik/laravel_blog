<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Admin Page</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  
  <!-- Icons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  @vite([
    'resources/assets/admin/plugins/fontawesome-free/css/all.min.css',
    'resources/assets/admin/plugins/select2/css/select2.css',
    'resources/assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.css',
    'resources/assets/admin/css/adminlte.css',
    'resources/assets/admin/plugins/select2/js/select2.full.js',
    'resources/assets/admin/plugins/bs-custom-file-input/bs-custom-file-input.js',
    'resources/assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js',
    'resources/assets/admin/js/adminlte.js',
    'resources/assets/admin/js/demo.js',
  ])

  <link rel="stylesheet" href="{{ asset('mainstyle.css') }}">

</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <div class="preloader flex-column justify-content-center align-items-center" style="height: 0px;">
    <img class="animation__shake" src="{{ asset('images/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60" width="60" style="display: none;">
    </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        {{-- <a class="nav-link" data-widget="pushmenu" data-enable-remember="true" href="#" role="button">
          <i class="fas fa-bars"></i>
        </a> --}}
        <a class="nav-link nav-icon-container" data-widget="pushmenu" data-enable-remember="true" href="#" role="button">
          <img src="{{ asset('images/icons/menu_1.png') }}" alt="menu" class="nav-icon">
        </a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ asset('/') }}" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('categories.single', ['slug' => 'marketing']) }}" class="nav-link">Marketing</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('categories.single', ['slug' => 'make-money']) }}" class="nav-link">Make Money</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('categories.single', ['slug' => 'blog']) }}" class="nav-link">Blog</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('categories.single', ['slug' => 'programming']) }}" class="nav-link">Programming</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('contact') }}" class="nav-link">Contact</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('logout') }}" class="nav-link">Logout</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link nav-icon-container" data-widget="navbar-search" href="#" role="button">
          {{-- <i class="fas fa-search"></i> --}}
          <img src="{{ asset('images/icons/search_1.png') }}" alt="search" class="nav-icon">
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link nav-icon-container" data-toggle="dropdown" href="#">
          {{-- <i class="far fa-comments"></i> --}}
          <img src="{{ asset('images/icons/messages_1.png') }}" alt="messages" class="nav-icon">
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="/images/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="/images/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="/images/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link nav-icon-container" data-toggle="dropdown" href="#">
          {{-- <i class="far fa-bell"></i> --}}
          <img src="{{ asset('images/icons/notifications_1.png') }}" alt="notifications" class="nav-icon">
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link nav-icon-container" data-toggle="dropdown" href="#" aria-expanded="false">
          <img src="{{ asset('images/icons/langs_1.png') }}" alt="languages" class="nav-icon">
        </a>
        <div class="dropdown-menu dropdown-menu-right p-0" style="left: inherit; right: 0px;">
          <a href="#" class="dropdown-item active">
            <i class="flag-icon flag-icon-us mr-2"></i> English
          </a>
          <a href="#" class="dropdown-item">
            <i class="flag-icon flag-icon-de mr-2"></i> German
          </a>
          <a href="#" class="dropdown-item">
            <i class="flag-icon flag-icon-fr mr-2"></i> French
          </a>
          <a href="#" class="dropdown-item">
            <i class="flag-icon flag-icon-es mr-2"></i> Spanish
          </a>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link nav-icon-container" href="{{ asset('/') }}" role="button">
          <img src="{{ asset('images/icons/exit_2.png') }}" alt="exit" class="nav-icon">
        </a>
      </li>

    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <div class="brand-link" style="cursor: default">
      <img src="/images/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Admin Panel</span>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/images/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
          {{-- <img src="{{ asset('images/icons/anonym_1.png') }}" alt="avatar"> --}}
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          
          <li class="nav-item">
            <a href="{{ route('admin.index') }}" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>Главная</p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-archive"></i>
              <p>
                Категории
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('categories.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Список категорий</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('categories.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Новая категория</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tags"></i>
              <p>
                Теги
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('tags.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Список тегов</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('tags.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Новый тег</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Статьи
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('posts.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Список статей</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('posts.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Новая статья</p>
                </a>
              </li>
            </ul>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper pt-2 position-relative px-3">
    @if ($errors->any())
      <div class="fluid-container mt-2">
        <div class="row" style="margin: 0">
          <div class="col-12">

            <div class="alert alert-danger">
                <ul class="list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
          
          </div>
        </div>
      </div>
    @endif

    @yield('content')

    @if (session()->has('error') || session()->has('success'))
      @if (session()->has('error'))
        <div class="alerts" style="display: none">
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <img src="{{ asset('images/icons/errors_1.png') }}" alt="error" class="alerts-icon">
            <h5>
              {{-- <i class="icon fas fa-ban"></i>  --}}
              Ошибка!
            </h5>
            {{ session('error') }}.
          </div>
        </div>
      @endif
        
      @if (session()->has('success'))
        <div class="alerts" style="display: none">
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <img src="{{ asset('images/icons/success_1.png') }}" alt="success" class="alerts-icon">
            <h5>
              {{-- <i class="icon fas fa-check"></i>  --}}
              Уведомление!
            </h5>
            {{ session('success') }}.
          </div>
        </div>
      @endif

      <script>

        $(".alerts").fadeIn(700);
          
        setTimeout(() => {
          $(".alerts").fadeOut(500).hide(500);
        }, 1000 * 5);

      </script>

    @endif

  </div>
  
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
  
</div>
<!-- ./wrapper -->


<script type="module">

  [...document.querySelectorAll('.nav-sidebar a')].forEach(element => {
    let location = window.location.protocol + '//' + window.location.host + window.location.pathname;
    let link = element.href;

    if (link == location) {
      element.classList.add('active');

      if (element.closest('.has-treeview')) {
        element.closest('.has-treeview').classList.add('menu-open');
        element.closest('.has-treeview').childNodes[1].classList.add('active');
        element.childNodes[1].classList.add('fa-dot-circle');
      }
    }
  });


  [...document.querySelectorAll('.table_actions')].forEach(elem => {
    elem.addEventListener('click', (event) => {
      event.stopPropagation();
    })
  });


  $(function() {
    $('#refresh').on('click', function() {

      $.ajax({

        url: "/refresh",
        type: "GET",
        headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
          console.log(data)
        },
        error: function (msg) {
          alert('Ошибка');
        }

      });
    });

    return false;
  });

</script>

@yield('countUp')

</body>
</html>
