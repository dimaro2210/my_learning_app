<div class="app-sidebar">
    <!-- Sidebar Toggle Arrow -->
    <div class="sidebar-toggle-btn" id="sidebarToggle">
        <i data-lucide="chevron-left" style="width:14px;height:14px;"></i>
    </div>

    <div class="app-sidebar__inner">
        <div class="app-header__logo">
            <a href="home.php" style="display:flex;align-items:center;text-decoration:none;gap:10px;">
                <img src="assets/images/logo-new.png" alt="My Learning" style="height:26px;width:auto;">
                <span class="sidebar-logo-full" style="font-weight:700;font-size:16px;color:var(--text-dark);">My Learning</span>
            </a>
        </div>

        <div class="sidebar-nav">
            <ul class="vertical-nav-menu">
                <li class="app-sidebar__heading">Menu</li>
                <li>
                    <a href="home.php" class="<?php echo (!isset($_GET['page'])) ? 'mm-active' : ''; ?>">
                        <i class="metismenu-icon" data-lucide="layout-grid"></i>
                        <span class="sidebar-nav-label">Overview</span>
                    </a>
                </li>
                <li>
                    <a href="home.php?page=result" class="<?php echo (isset($_GET['page']) && $_GET['page']=='result') ? 'mm-active' : ''; ?>">
                        <i class="metismenu-icon" data-lucide="bar-chart-3"></i>
                        <span class="sidebar-nav-label">Results</span>
                    </a>
                </li>

                <li class="app-sidebar__heading">Exams</li>
                <li>
                    <a href="home.php?page=take-exam" class="<?php echo (isset($_GET['page']) && $_GET['page']=='take-exam') ? 'mm-active' : ''; ?>">
                        <i class="metismenu-icon" data-lucide="file-text"></i>
                        <span class="sidebar-nav-label">Take Exam</span>
                    </a>
                </li>
                <li>
                    <a href="home.php?page=feedback" class="<?php echo (isset($_GET['page']) && $_GET['page']=='feedback') ? 'mm-active' : ''; ?>">
                        <i class="metismenu-icon" data-lucide="message-circle"></i>
                        <span class="sidebar-nav-label">Feedback</span>
                    </a>
                </li>

                <li class="app-sidebar__heading">General</li>
                <li>
                    <a href="home.php?page=profile" class="<?php echo (isset($_GET['page']) && $_GET['page']=='profile') ? 'mm-active' : ''; ?>">
                        <i class="metismenu-icon" data-lucide="user"></i>
                        <span class="sidebar-nav-label">Profile</span>
                    </a>
                </li>
                <li>
                    <a href="query/logoutExe.php">
                        <i class="metismenu-icon" data-lucide="log-out" style="color:var(--danger);"></i>
                        <span class="sidebar-nav-label">Log out</span>
                    </a>
                </li>
            </ul>
        </div>


    </div>
</div>

<script>
    lucide.createIcons();
</script>