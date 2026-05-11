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

                <li class="app-sidebar__heading">Subjects</li>
                <li>
                    <a href="#" data-toggle="modal" data-target="#modalForAddCourse">
                        <i class="metismenu-icon" data-lucide="plus-circle"></i>
                        <span class="sidebar-nav-label">Add Subject</span>
                    </a>
                </li>
                <li>
                    <a href="home.php?page=manage-course" class="<?php echo (isset($_GET['page']) && $_GET['page']=='manage-course') ? 'mm-active' : ''; ?>">
                        <i class="metismenu-icon" data-lucide="book-open"></i>
                        <span class="sidebar-nav-label">Manage Subjects</span>
                    </a>
                </li>

                <li class="app-sidebar__heading">Exams</li>
                <li>
                    <a href="home.php?page=add-exam" class="<?php echo (isset($_GET['page']) && $_GET['page']=='add-exam') ? 'mm-active' : ''; ?>">
                        <i class="metismenu-icon" data-lucide="file-plus"></i>
                        <span class="sidebar-nav-label">Add Exam</span>
                    </a>
                </li>
                <li>
                    <a href="home.php?page=manage-exam" class="<?php echo (isset($_GET['page']) && $_GET['page']=='manage-exam') ? 'mm-active' : ''; ?>">
                        <i class="metismenu-icon" data-lucide="clipboard-list"></i>
                        <span class="sidebar-nav-label">Manage Exams</span>
                    </a>
                </li>

                <li class="app-sidebar__heading">Students</li>
                <li>
                    <a href="#" data-toggle="modal" data-target="#modalForAddExaminee">
                        <i class="metismenu-icon" data-lucide="user-plus"></i>
                        <span class="sidebar-nav-label">Add Student</span>
                    </a>
                </li>
                <li>
                    <a href="home.php?page=manage-examinee" class="<?php echo (isset($_GET['page']) && $_GET['page']=='manage-examinee') ? 'mm-active' : ''; ?>">
                        <i class="metismenu-icon" data-lucide="users"></i>
                        <span class="sidebar-nav-label">Manage Students</span>
                    </a>
                </li>
                <li>
                    <a href="home.php?page=add-result" class="<?php echo (isset($_GET['page']) && $_GET['page']=='add-result') ? 'mm-active' : ''; ?>">
                        <i class="metismenu-icon" data-lucide="file-plus-2"></i>
                        <span class="sidebar-nav-label">Add Result</span>
                    </a>
                </li>
                <li>
                    <a href="home.php?page=examinee-result" class="<?php echo (isset($_GET['page']) && $_GET['page']=='examinee-result') ? 'mm-active' : ''; ?>">
                        <i class="metismenu-icon" data-lucide="trending-up"></i>
                        <span class="sidebar-nav-label">Exam Results</span>
                    </a>
                </li>
                <li>
                    <a href="home.php?page=submitted-results" class="<?php echo (isset($_GET['page']) && $_GET['page']=='submitted-results') ? 'mm-active' : ''; ?>">
                        <i class="metismenu-icon" data-lucide="file-check-2"></i>
                        <span class="sidebar-nav-label">Submitted Results</span>
                    </a>
                </li>
                <li>
                    <a href="home.php?page=feedbacks" class="<?php echo (isset($_GET['page']) && $_GET['page']=='feedbacks') ? 'mm-active' : ''; ?>">
                        <i class="metismenu-icon" data-lucide="messages-square"></i>
                        <span class="sidebar-nav-label">Feedbacks</span>
                    </a>
                </li>

                <li class="app-sidebar__heading">General</li>
                <li>
                    <a href="home.php?page=settings" class="<?php echo (isset($_GET['page']) && $_GET['page']=='settings') ? 'mm-active' : ''; ?>">
                        <i class="metismenu-icon" data-lucide="settings"></i>
                        <span class="sidebar-nav-label">Settings</span>
                    </a>
                </li>
                <li>
                    <a href="../../index.php">
                        <i class="metismenu-icon" data-lucide="external-link"></i>
                        <span class="sidebar-nav-label">Student Panel</span>
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