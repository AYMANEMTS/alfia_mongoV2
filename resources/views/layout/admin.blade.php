<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <link rel="icon" href="{{ asset('assets/images/favicon.png')}} " type="image/x-icon">
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png')}} " type="image/x-icon">
        <title>Programme alfia</title>
        <!-- Google font-->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
        <!-- Font Awesome-->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/fontawesome.css') }}">
        <!-- ico-font-->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/icofont.css')}} ">
        <!-- Themify icon-->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/themify.css') }}">
        <!-- Flag icon-->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/flag-icon.css') }}">
        <!-- Feather icon-->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/feather-icon.css')}} ">
        <!-- Plugins css start-->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/date-picker.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/owlcarousel.css')}} ">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/prism.css')}} ">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/whether-icon.css')}} ">
        <!-- Plugins css Ends-->
        <!-- Bootstrap css-->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.css') }}">
        <!-- App css-->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css')}} ">
        <link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css')}} " media="screen">
        <!-- Responsive css-->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css')}} ">
        <!-- Plugins css start-->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css')}} ">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatable-extension.css')}} ">
        <!-- Plugins css Ends-->
      </head>
<body>
        <!-- Loader starts-->
        {{-- <div class="loader-wrapper">
            <div class="theme-loader">    
              <div class="loader-p"></div>
            </div>
          </div> --}}
          <!-- Loader ends-->
          <!-- page-wrapper Start-->
          <div class="page-wrapper" id="pageWrapper">
            <!-- Page Header Start-->
            <div class="page-main-header">
              <div class="main-header-right row m-0">
                <div class="main-header-left">
                  <div class="logo-wrapper"><a href="../index.php"><img class="img-fluid" src="{{ asset('assets/images/logo/logo.png')}} " alt=""></a></div>
                  <div class="dark-logo-wrapper"><a href="../index.php"><img class="img-fluid" src="{{ asset('assets/images/logo/dark-logo.png')}} " alt=""></a></div>
                  <div class="toggle-sidebar"><i class="status_toggle middle" data-feather="align-center" id="sidebar-toggle"></i></div>
                </div>
                
                <div class="nav-right col pull-right right-menu p-0">
                  <ul class="nav-menus">
                    <li><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i data-feather="maximize"></i></a></li>
                    
                    <li>
                      <div class="mode"><i class="fa fa-moon-o"></i></div>
                    </li>
      
                    <li class="onhover-dropdown p-0">
                      <button class="btn btn-primary-light" type="button"><a href="{{ route('logout') }}"><i data-feather="log-out"></i>Déconnexion</a></button>
                    </li>
                  </ul>
                </div>
                <div class="d-lg-none mobile-toggle pull-right w-auto"><i data-feather="more-horizontal"></i></div>
              </div>
            </div>
            <!-- Page Header Ends  -->
            <!-- Page Body Start-->
            <div class="page-body-wrapper horizontal-menu">
              <!-- Page Sidebar Start-->
              <header class="main-nav">
                <div class="sidebar-user text-center"><a class="setting-primary" href=""><i data-feather="settings"></i></a><img class="img-90 rounded-circle" src="{{ asset('assets/images/dashboard/1.png')}} " alt="">
                  <div class="badge-bottom"><span class="badge badge-primary">New</span></div><a href="">
                    <h6 class="mt-3 f-14 f-w-600">
                        {{-- <?php echo $_SESSION['auth_user']['user_name']; ?> --}}
                    </h6>
                  </a>
                  <p class="mb-0 font-roboto">
                    {{-- <?php echo $_SESSION['auth_user']['job']; ?> --}}
                </p>
                </div>
      
                <nav>
                  <div class="main-navbar">
                    <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
                    <div id="mainnav">           
                      <ul class="nav-menu custom-scrollbar">
                        <li class="back-btn">
                          <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                        </li>
                        <li class="dropdown"><a class="nav-link menu-title link-nav" href="/admin"><i data-feather="home"></i><span>Tableau de Bord</span></a></li>
                        
                        <li class="sidebar-main-title">
                          <div>
                            <h6> Gérer les données </h6>
                          </div>
                        </li>
                        <li class="dropdown"><a class="nav-link menu-title link-nav" href="/participant"><i data-feather="user-plus"></i><span>Data Participants</span></a></li>
                        <li class="dropdown"><a class="nav-link menu-title link-nav" href="/formation"><i data-feather="user-check"></i><span>Data Formation</span></a></li>
                        <li class="dropdown"><a class="nav-link menu-title link-nav" href="/accompagnement"><i data-feather="file-text"></i><span>Data Accompagnement</span></a></li>
                        
                        <li class="sidebar-main-title">
                          <div>
                            <h6> Gérer les utilisateurs </h6>
                          </div>
                        </li>
                        <li class="dropdown"><a class="nav-link menu-title link-nav" href="/users"><i data-feather="user"></i><span>les utilisateurs</span></a></li>
                      </ul>
                    </div>
                    <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
                  </div>
                </nav>
              </header>

              @yield('body')


              <!-- footer start-->
<footer class="footer">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6 footer-copyright">
          <p class="mb-0">Copyright 2024 © <a href="http://moongraph.co" target="_blank" rel="noopener noreferrer">MOONGRAPH</a> </p>
        </div>
      </div>
    </div>
  </footer>
</div>
</div>
<!-- latest jquery-->
<script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>

<!-- feather icon js-->
<script src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}"></script>

<!-- Sidebar jquery-->
<script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
<script src="{{ asset('assets/js/config.js') }}"></script>

<!-- Bootstrap js-->
<script src="{{ asset('assets/js/bootstrap/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap/bootstrap.min.js') }}"></script>

<!-- Plugins JS start-->
<script src="{{ asset('assets/js/prism/prism.min.js') }}"></script>
<script src="{{ asset('assets/js/clipboard/clipboard.min.js') }}"></script>
<script src="{{ asset('assets/js/counter/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('assets/js/counter/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('assets/js/counter/counter-custom.js') }}"></script>
<script src="{{ asset('assets/js/custom-card/custom-card.js') }}"></script>
<script src="{{ asset('assets/js/datepicker/date-picker/datepicker.js') }}"></script>
<script src="{{ asset('assets/js/datepicker/date-picker/datepicker.en.js') }}"></script>
<script src="{{ asset('assets/js/datepicker/date-picker/datepicker.custom.js') }}"></script>
<script src="{{ asset('assets/js/owlcarousel/owl.carousel.js') }}"></script>
<script src="{{ asset('assets/js/general-widget.js') }}"></script>
<script src="{{ asset('assets/js/height-equal.js') }}"></script>

<!-- Plugins JS start-->
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/jszip.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/dataTablesautoFill.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.select.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.keyTable.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.colReorder.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.fixedHeader.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.rowReorder.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.scroller.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/custom.js') }}"></script>

<script src="{{ asset('assets/js/tooltip-init.js') }}"></script>

<!-- Plugins JS Ends-->
<script src="{{ asset('assets/js/script.js') }}"></script>

</body>
</html>

              
</body>
</html>