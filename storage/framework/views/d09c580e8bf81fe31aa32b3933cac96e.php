<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $__env->yieldContent('title'); ?> - SIPOSYANDU</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('favicon.ico')); ?>">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Custom CSS -->
    <style>
        :root {
            --dark-bg: #222831;
            --dark-secondary: #393E46;
            --accent-cyan: #00ADB5;
            --light-gray: #EEEEEE;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-gray);
            overflow-x: hidden;
            min-height: 100vh;
            padding-top: 70px; /* Untuk fixed navbar */
        }
        
        /* Fixed Navbar */
        .navbar-custom {
            background: linear-gradient(135deg, var(--dark-bg) 0%, var(--dark-secondary) 100%);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            padding: 0.75rem 0;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1050;
            height: 70px;
            transition: all 0.3s ease;
        }
        
        .navbar-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
            transition: all 0.3s ease;
            white-space: nowrap;
        }
        
        .navbar-brand:hover {
            color: var(--accent-cyan) !important;
        }
        
        .navbar-brand i {
            color: var(--accent-cyan);
            margin-right: 0.5rem;
        }
        
        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            background: transparent;
            border: none;
            color: white;
            font-size: 1.5rem;
            padding: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .mobile-menu-toggle:hover {
            color: var(--accent-cyan);
        }
        
        /* User Profile in Navbar */
        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .user-profile i {
            font-size: 1.5rem;
        }
        
        /* Badge */
        .role-badge {
            background: var(--accent-cyan);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: 0.5rem;
        }
        
        /* Sidebar */
        .sidebar-wrapper {
            position: fixed;
            left: 0;
            top: 70px; /* Di bawah navbar */
            height: calc(100vh - 70px);
            width: 260px;
            background: linear-gradient(180deg, var(--dark-bg) 0%, var(--dark-secondary) 100%);
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1040;
            overflow-y: auto;
            overflow-x: hidden;
        }
        
        .sidebar-wrapper::-webkit-scrollbar {
            width: 6px;
        }
        
        .sidebar-wrapper::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }
        
        .sidebar-wrapper::-webkit-scrollbar-thumb {
            background: var(--accent-cyan);
            border-radius: 10px;
        }
        
        /* Sidebar state for desktop */
        .sidebar-wrapper.hidden-desktop {
            left: -260px;
        }
        
        /* Sidebar state for mobile */
        .sidebar-wrapper.hidden-mobile {
            left: -260px;
        }
        
        .sidebar-wrapper.show-mobile {
            left: 0;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.3);
        }
        
        .sidebar-header {
            padding: 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-header h5 {
            color: white;
            margin: 0;
            font-weight: 600;
            font-size: 1.1rem;
        }
        
        .sidebar-header i {
            color: var(--accent-cyan);
            margin-right: 0.5rem;
        }
        
        .sidebar-menu {
            padding: 1rem 0.5rem;
        }
        
        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 0.85rem 1.25rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: 10px;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .sidebar-menu a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: var(--accent-cyan);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }
        
        .sidebar-menu a:hover {
            background: rgba(0, 173, 181, 0.15);
            color: white;
            padding-left: 1.5rem;
        }
        
        .sidebar-menu a:hover::before {
            transform: scaleY(1);
        }
        
        .sidebar-menu a.active {
            background: var(--accent-cyan);
            color: white;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0, 173, 181, 0.3);
        }
        
        .sidebar-menu a.active::before {
            transform: scaleY(1);
            background: white;
        }
        
        .sidebar-menu a i {
            width: 25px;
            text-align: center;
            margin-right: 0.75rem;
            font-size: 1.1rem;
        }
        
        /* Main Content */
        .main-content-wrapper {
            margin-left: 260px;
            padding: 2rem;
            min-height: calc(100vh - 70px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .main-content-wrapper.expanded {
            margin-left: 0;
        }
        
        /* Overlay for mobile sidebar */
        .sidebar-overlay {
            position: fixed;
            top: 70px;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1035;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            backdrop-filter: blur(2px);
        }
        
        .sidebar-overlay.show {
            opacity: 1;
            visibility: visible;
        }
        
        /* Responsive Design */
        @media (max-width: 992px) {
            body {
                padding-top: 70px;
            }
            
            .mobile-menu-toggle {
                display: block;
            }
            
            .sidebar-wrapper {
                left: -260px;
                top: 70px;
                height: calc(100vh - 70px);
            }
            
            .sidebar-wrapper.show-mobile {
                left: 0;
            }
            
            .main-content-wrapper {
                margin-left: 0;
                padding: 1.5rem;
            }
            
            /* Hide desktop user profile dropdown on mobile */
            .nav-item.dropdown {
                display: none;
            }
            
            /* Mobile user info in sidebar */
            .mobile-user-info {
                display: block !important;
                padding: 1rem 1.5rem;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
                margin-bottom: 1rem;
            }
        }
        
        @media (max-width: 576px) {
            .main-content-wrapper {
                padding: 1rem;
            }
            
            .navbar-brand {
                font-size: 1.2rem;
            }
            
            body {
                padding-top: 60px;
            }
            
            .navbar-custom {
                height: 60px;
                padding: 0.5rem 0;
            }
            
            .sidebar-wrapper {
                top: 60px;
                height: calc(100vh - 60px);
                width: 280px; /* Lebih lebar di mobile */
            }
        }
        
        /* Mobile user info - hidden by default */
        .mobile-user-info {
            display: none;
            color: white;
        }
        
        .mobile-user-info .user-name {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 0.25rem;
        }
        
        .mobile-user-info .user-role {
            font-size: 0.85rem;
            opacity: 0.9;
        }
        
        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .page-loading {
            animation: fadeIn 0.5s ease forwards;
        }
        
        /* Ensure content doesn't get hidden under fixed elements */
        @media (min-width: 993px) {
            .main-content-wrapper {
                padding-top: 1rem;
            }
        }

        /* Submenu styling */
.sidebar-submenu {
    padding-left: 2.5rem;
    margin: 0.5rem 0;
}

.sidebar-submenu a {
    padding: 0.6rem 1rem;
    margin-bottom: 0.3rem;
    font-size: 0.9rem;
    background: rgba(255, 255, 255, 0.05);
}

.sidebar-submenu a:hover {
    background: rgba(0, 173, 181, 0.1);
}

.sidebar-collapse-toggle {
    display: flex;
    align-items: center;
    cursor: pointer;
}

.sidebar-collapse-toggle .fa-chevron-down {
    transition: transform 0.3s ease;
    font-size: 0.8rem;
}

.sidebar-collapse-toggle[aria-expanded="true"] .fa-chevron-down {
    transform: rotate(180deg);
}

/* Ensure active state works for nested routes */
.sidebar-menu a.active,
.sidebar-submenu a.active {
    background: var(--accent-cyan);
    color: white;
    font-weight: 600;
}
    </style>
    
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <?php if(auth()->check()): ?>
    <!-- Fixed Navbar -->
    <nav class="navbar navbar-custom">
        <div class="container-fluid">
            <div class="navbar-content">
                <!-- Mobile Menu Toggle -->
                <button class="mobile-menu-toggle" id="mobileMenuToggle">
                    <i class="fas fa-bars"></i>
                </button>
                
                <!-- Brand -->
                <a class="navbar-brand" href="<?php echo e(route('home')); ?>">
                    <i class="fas fa-hospital"></i> SIPOSYANDU
                </a>
                
                <!-- Desktop User Profile -->
                <div class="d-none d-lg-block">
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle user-profile" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i> 
                            <span><?php echo e(auth()->user()->nama); ?></span>
                            <span class="role-badge"><?php echo e(strtoupper(auth()->user()->role)); ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form action="<?php echo e(route('logout')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar Overlay (Mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <div class="sidebar-wrapper" id="sidebar">
        <!-- Mobile User Info -->
        <div class="mobile-user-info">
            <div class="user-name"><?php echo e(auth()->user()->nama); ?></div>
            <div class="user-role"><?php echo e(strtoupper(auth()->user()->role)); ?></div>
        </div>
        
        <!-- Sidebar Menu -->
        <div class="sidebar-menu">
            <?php if(auth()->user()->isAdmin()): ?>
                <?php echo $__env->make('partials.sidebar.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php elseif(auth()->user()->isBidan()): ?>
                <?php echo $__env->make('partials.sidebar.bidan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php elseif(auth()->user()->isKader()): ?>
                <?php echo $__env->make('partials.sidebar.sidebar-kader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php else: ?>
                <?php echo $__env->make('partials.sidebar.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endif; ?>
            
            <!-- Mobile Logout -->
            <div class="d-lg-none mt-3 px-3">
                <form action="<?php echo e(route('logout')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content-wrapper page-loading" id="mainContent">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
    <?php else: ?>
        <?php echo $__env->yieldContent('content'); ?>
    <?php endif; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        // SweetAlert2 Toast Configuration
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // Show flash messages
        <?php if(session('success')): ?>
            Toast.fire({
                icon: 'success',
                title: '<?php echo e(session('success')); ?>'
            });
        <?php endif; ?>
        
        <?php if(session('error')): ?>
            Toast.fire({
                icon: 'error',
                title: '<?php echo e(session('error')); ?>'
            });
        <?php endif; ?>
        
        <?php if(session('warning')): ?>
            Toast.fire({
                icon: 'warning',
                title: '<?php echo e(session('warning')); ?>'
            });
        <?php endif; ?>

        <?php if(session('info')): ?>
            Toast.fire({
                icon: 'info',
                title: '<?php echo e(session('info')); ?>'
            });
        <?php endif; ?>

        // Confirm delete function
        function confirmDelete(formId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#95a5a6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }

        // Sidebar Management
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const mobileToggleIcon = mobileMenuToggle.querySelector('i');
            let isMobile = window.innerWidth <= 992;

            // Initialize sidebar state
            function initSidebar() {
                isMobile = window.innerWidth <= 992;
                
                if (isMobile) {
                    // Mobile: sidebar hidden by default
                    sidebar.classList.remove('hidden-desktop', 'show-mobile');
                    sidebar.classList.add('hidden-mobile');
                    mainContent.classList.remove('expanded');
                } else {
                    // Desktop: sidebar visible by default
                    sidebar.classList.remove('hidden-mobile', 'show-mobile');
                    sidebar.classList.remove('hidden-desktop');
                    mainContent.classList.remove('expanded');
                }
            }

            // Toggle sidebar function
            function toggleSidebar() {
                if (isMobile) {
                    // Mobile toggle
                    sidebar.classList.toggle('show-mobile');
                    sidebar.classList.toggle('hidden-mobile');
                    sidebarOverlay.classList.toggle('show');
                    
                    // Toggle hamburger icon
                    if (mobileToggleIcon.classList.contains('fa-bars')) {
                        mobileToggleIcon.classList.remove('fa-bars');
                        mobileToggleIcon.classList.add('fa-times');
                    } else {
                        mobileToggleIcon.classList.remove('fa-times');
                        mobileToggleIcon.classList.add('fa-bars');
                    }
                } else {
                    // Desktop toggle
                    sidebar.classList.toggle('hidden-desktop');
                    mainContent.classList.toggle('expanded');
                    
                    // Toggle hamburger icon
                    if (mobileToggleIcon.classList.contains('fa-bars')) {
                        mobileToggleIcon.classList.remove('fa-bars');
                        mobileToggleIcon.classList.add('fa-times');
                    } else {
                        mobileToggleIcon.classList.remove('fa-times');
                        mobileToggleIcon.classList.add('fa-bars');
                    }
                }
            }

            // Close sidebar on mobile
            function closeMobileSidebar() {
                if (isMobile) {
                    sidebar.classList.remove('show-mobile');
                    sidebar.classList.add('hidden-mobile');
                    sidebarOverlay.classList.remove('show');
                    mobileToggleIcon.classList.remove('fa-times');
                    mobileToggleIcon.classList.add('fa-bars');
                }
            }

            // Event Listeners
            mobileMenuToggle.addEventListener('click', toggleSidebar);
            
            sidebarOverlay.addEventListener('click', closeMobileSidebar);
            
            // Close sidebar when clicking a link (mobile only)
            const sidebarLinks = document.querySelectorAll('.sidebar-menu a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (isMobile) {
                        closeMobileSidebar();
                    }
                });
            });

            // Handle window resize
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    const wasMobile = isMobile;
                    initSidebar();
                    
                    // If switching between mobile/desktop, reset icons
                    if (wasMobile !== isMobile) {
                        mobileToggleIcon.classList.remove('fa-times');
                        mobileToggleIcon.classList.add('fa-bars');
                        sidebarOverlay.classList.remove('show');
                    }
                }, 250);
            });

            // Initialize on load
            initSidebar();
            
            // Prevent body scroll when sidebar is open on mobile
            function preventBodyScroll(prevent) {
                if (isMobile && prevent) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            }
            
            // Observe sidebar state changes for mobile
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === 'class') {
                        if (sidebar.classList.contains('show-mobile')) {
                            preventBodyScroll(true);
                        } else {
                            preventBodyScroll(false);
                        }
                    }
                });
            });
            
            observer.observe(sidebar, { attributes: true });
        });
    </script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\xampp\htdocs\POSYANDU\posyandu-management-system\resources\views/layouts/app.blade.php ENDPATH**/ ?>