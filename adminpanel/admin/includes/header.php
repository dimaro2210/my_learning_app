<?php 
  include("../../conn.php");
  include("query/countData.php");
 ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <title>My Learning - Admin Dashboard</title>
    <link href="./main.css" rel="stylesheet">
    <link href="css/sweetalert.css" rel="stylesheet">
    <link href="css/facebox.css" rel="stylesheet">
    <link href="css/custom-theme.css?v=3" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body id="body">


    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <div class="app-header header-shadow">
            <div class="app-header__logo">
                <a href="home.php" style="display:flex;align-items:center;">
                    <img src="assets/images/logo-new.png" alt="My Learning" style="height:32px;width:auto;">
                </a>
                <div class="header__pane ml-auto">
                    <div>
                        <button type="button" class="hamburger hamburger--elastic sidebar-toggle-btn-mobile" id="sidebarToggleDesktop">
                            <span class="hamburger-box"><span class="hamburger-inner"></span></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="app-header__mobile-menu">
                <div>
                    <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav" id="mobileMenuToggle">
                        <span class="hamburger-box"><span class="hamburger-inner"></span></span>
                    </button>
                </div>
            </div>
            <div class="app-header__menu">
                <span>
                    <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                        <span class="btn-icon-wrapper"><i class="fa fa-ellipsis-v fa-w-6"></i></span>
                    </button>
                </span>
            </div>
            <div class="app-header__content">
                <div class="app-header-left"></div>
                <div class="app-header-right">
                    <!-- Dark Mode Toggle -->
                    <div class="theme-toggle" id="themeToggle" title="Toggle dark/light mode">
                        <span id="lightBtn" class="active">☀️</span>
                        <span id="darkBtn">🌙</span>
                    </div>
                    <div class="header-btn-lg pr-0">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                    <div class="btn-group">
                                        <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn" style="font-weight:600;color:var(--text-dark);">
                                            <i class="fa fa-shield" style="color:var(--primary);margin-right:6px;"></i> Admin
                                            <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                        </a>
                                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                            <a rel="facebox" href="facebox_modal/updateAdmin.php?id=<?php echo $_SESSION['admin']['admin_id']; ?>" class="dropdown-item">Admin Account</a>
                                            <div tabindex="-1" class="dropdown-divider"></div>
                                            <a href="../../index.php" class="dropdown-item"><i class="fa fa-users" style="margin-right:6px;"></i> Student Panel</a>
                                            <div tabindex="-1" class="dropdown-divider"></div>
                                            <a href="query/logoutExe.php" class="dropdown-item" style="color:#ef4444;"><i class="fa fa-sign-out" style="margin-right:6px;"></i> LOG OUT</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Mobile sidebar overlay -->
    <div class="sidebar-mobile-overlay" id="sidebarOverlay"></div>

    <script>
    // Preloader removed from header, only used on login page
    // Dark Mode
    (function(){
        var saved=localStorage.getItem('ml_theme');
        if(saved==='dark'){document.body.classList.add('dark-mode');
            document.getElementById('darkBtn').classList.add('active');document.getElementById('lightBtn').classList.remove('active');}
    })();
    document.getElementById('themeToggle').addEventListener('click',function(){
        document.body.classList.toggle('dark-mode');
        var isDark=document.body.classList.contains('dark-mode');
        localStorage.setItem('ml_theme',isDark?'dark':'light');
        document.getElementById('darkBtn').classList.toggle('active',isDark);
        document.getElementById('lightBtn').classList.toggle('active',!isDark);
    });
    // Sidebar toggle (desktop)
    const toggleSidebar = () => {
        document.body.classList.toggle('sidebar-collapsed');
        localStorage.setItem('ml_sidebar', document.body.classList.contains('sidebar-collapsed') ? 'collapsed' : 'expanded');
    };

    const sidebarBtn1 = document.getElementById('sidebarToggle'); // Sidebar arrow
    const sidebarBtn2 = document.getElementById('sidebarToggleDesktop'); // Header hamburger

    if(sidebarBtn1) sidebarBtn1.addEventListener('click', toggleSidebar);
    if(sidebarBtn2) sidebarBtn2.addEventListener('click', toggleSidebar);

    (function(){if(localStorage.getItem('ml_sidebar')==='collapsed')document.body.classList.add('sidebar-collapsed');})();
    // Mobile sidebar
    var mobileBtn=document.getElementById('mobileMenuToggle');
    var overlay=document.getElementById('sidebarOverlay');
    if(mobileBtn){mobileBtn.addEventListener('click',function(){
        document.querySelector('.app-sidebar').classList.toggle('sidebar-mobile-open');
        overlay.classList.toggle('active');
    });}
    if(overlay){overlay.addEventListener('click',function(){
        document.querySelector('.app-sidebar').classList.remove('sidebar-mobile-open');
        overlay.classList.remove('active');
    });}
    </script>