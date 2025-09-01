<?php $user = session()->get('user'); ?>
<?php if ($user && $user['role'] === 'operator') : ?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $title ?? 'Dashboard' ?> | Sistem Arsip Surat</title>
  <link rel="icon" href="<?= base_url('/public/uploads/logo.png') ?>" type="image/png">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet" />
  <!-- font -->
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <!-- Animate.css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

  <!-- Custom CSS -->
  <style>
    :root {
      --primary: #4361ee;
      --primary-dark: #3a0ca3;
      --primary-light: #f0f5ff;
      --sidebar-width: 280px;
      --sidebar-collapsed-width: 80px;
      --navbar-height: 75px;
      --sidebar-bg: #ffffff;
      --sidebar-text: #64748b;
      --sidebar-active: rgba(67, 97, 238, 0.1);
      --sidebar-hover: rgba(67, 97, 238, 0.05);
      --content-bg: #f8fafc;
      --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      --border-color: #e2e8f0;
    }

    .main-sidebar nav {
      display: flex;
      flex-direction: column;
      height: 100%;
    }

    /* Dark Mode Variables */
    [data-theme="dark"] {
      --primary: #5e72e4;
      --primary-dark: #4a5fc9;
      --primary-light: rgba(94, 114, 228, 0.1);
      --sidebar-bg: #1a2236;
      --sidebar-text: #a0aec0;
      --sidebar-active: rgba(94, 114, 228, 0.2);
      --sidebar-hover: rgba(94, 114, 228, 0.1);
      --content-bg: #121726;
      --border-color: #2d3748;
      --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.2);
    }

    [data-theme="dark"] body {
      color: #e2e8f0;
      background-color: var(--content-bg);
    }

    [data-theme="dark"] .main-header {
      background: #1a2236;
      border-bottom: 1px solid var(--border-color);
    }

    [data-theme="dark"] .content-wrapper {
      background-color: var(--content-bg);
    }

    [data-theme="dark"] .dropdown-menu {
      background-color: #1a2236;
      border-color: var(--border-color);
      color: #e2e8f0;
    }

    [data-theme="dark"] .dropdown-item {
      color: #e2e8f0;
    }

    [data-theme="dark"] .dropdown-item:hover {
      background-color: var(--primary-light);
      color: var(--primary);
    }

    [data-theme="dark"] .user-name {
      color: #e2e8f0 !important;
    }

    [data-theme="dark"] .user-panel small {
      color: #a0aec0;
    }

    [data-theme="dark"] .sidebar-divider {
      background: var(--border-color);
    }

    [data-theme="dark"] .arsip-surat {
      color: #ffffff !important;
    }

    [data-theme="dark"] .navbar .text-muted,
    [data-theme="dark"] .user-panel small {
      color: #e2e8f0 !important;
    }

    [data-theme="dark"] .sidebar-profile {
      background: rgba(94, 114, 228, 0.1);
      border-color: var(--border-color);
    }

    [data-theme="dark"] .sidebar-profile:hover {
      background: rgba(94, 114, 228, 0.2);
    }

    body {
      font-family: 'Outfit', sans-serif;
      background-color: var(--content-bg);
      color: #334155;
      min-height: 100vh;
      padding-left: var(--sidebar-width);
      padding-top: var(--navbar-height);
      transition: var(--transition);
    }

    /* Navbar */
    .main-header {
      height: var(--navbar-height);
      background: white;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
      z-index: 1060;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      transition: var(--transition);
      border-bottom: 1px solid var(--border-color);
    }

    .navbar-brand {
      font-weight: 700;
      color: var(--primary) !important;
      font-size: 1.25rem;
      display: flex;
      align-items: center;
      gap: 10px;
      cursor: pointer;
    }

    .navbar-brand i {
      color: var(--primary);
      font-size: 1.5rem;
    }

    /* Sidebar */
    .main-sidebar {
      width: var(--sidebar-width);
      position: fixed;
      top: var(--navbar-height);;
      left: 0;
      bottom: 0;
      background: var(--sidebar-bg);
      color: var(--sidebar-text);
      overflow-y: auto;
      padding: 1.5rem 0;
      z-index: 1050;
      transition: var(--transition);
      border-right: 1px solid var(--border-color);
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.03);
    }

    .main-sidebar .nav-link {
      color: var(--sidebar-text);
      padding: 0.75rem 1.5rem;
      margin: 0.25rem 1rem;
      border-radius: 8px;
      display: flex;
      align-items: center;
      gap: 12px;
      font-weight: 500;
      transition: var(--transition);
      position: relative;
    }

    .main-sidebar .nav-link:hover {
      background: var(--sidebar-hover);
      color: var(--primary);
      transform: translateY(-5px);
    }

    .main-sidebar .nav-link.active {
      background: var(--sidebar-active);
      color: var(--primary);
      font-weight: 600;
    }

    .main-sidebar .nav-link i {
      font-size: 1.1rem;
      width: 24px;
      display: inline-flex;
      justify-content: center;
      transition: var(--transition);
    }

    .main-sidebar .nav-link.active i {
      color: var(--primary);
    }

    /* Theme Toggle Button */
    .theme-toggle {
      background: none;
      border: none;
      color: var(--sidebar-text);
      font-size: 1.25rem;
      cursor: pointer;
      padding: 0.5rem;
      border-radius: 50%;
      transition: var(--transition);
      margin-right: 0.75rem;
    }

    .theme-toggle:hover {
      color: var(--primary);
      background-color: var(--sidebar-hover);
    }

    /* Sidebar Profile Section */
    .sidebar-profile {
      padding: 1rem 1.5rem;
      margin: 1rem;
      border-radius: 8px;
      background: var(--primary-light);
      border: 1px solid var(--border-color);
      transition: var(--transition);
    }

    .sidebar-profile:hover {
      background: rgba(67, 97, 238, 0.15);
      transform: translateY(-5px);
    }

    .sidebar-profile a {
      display: flex;
      align-items: center;
      gap: 12px;
      text-decoration: none;
      color: var(--sidebar-text);
    }

    .sidebar-profile .profile-info {
      overflow: hidden;
    }

    .sidebar-profile .profile-name {
      font-weight: 600;
      color: var(--primary-dark);
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .sidebar-profile .profile-role {
      font-size: 0.8rem;
      color: var(--sidebar-text);
    }

    .sidebar-profile img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
    }

    .sidebar-profile .nav-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: 600;
      font-size: 1.2rem;
    }

    /* Collapsed Sidebar State */
    body.sidebar-collapsed {
      padding-left: var(--sidebar-collapsed-width);
    }

    .sidebar-collapsed .main-sidebar {
      width: var(--sidebar-collapsed-width);
      overflow: hidden;
    }

    .sidebar-collapsed .main-sidebar .nav-link {
      padding: 0.75rem;
      justify-content: center;
      margin: 0.25rem 0.5rem;
    }

    .sidebar-collapsed .main-sidebar .nav-link span {
      display: none;
    }

    .sidebar-collapsed .main-sidebar .nav-link i {
      font-size: 1.3rem;
    }

    .sidebar-collapsed .main-sidebar .user-panel>div {
      justify-content: center;
    }

    .sidebar-collapsed .main-sidebar .user-info,
    .sidebar-collapsed .main-sidebar .sidebar-divider {
      display: none;
    }

    .sidebar-collapsed .main-sidebar .nav-link:hover {
      transform: none;
    }

    .sidebar-collapsed .main-sidebar .nav-link.active {
      border-radius: 8px;
      background: rgba(67, 97, 238, 0.15);
    }

    /* Sidebar Profile and Logout in Collapsed State */
    .sidebar-collapsed .sidebar-profile,
    .sidebar-collapsed .sidebar-logout {
      display: flex !important;
      justify-content: center;
      padding: 0.75rem;
      margin: 0.25rem 0.5rem;
    }

    .sidebar-collapsed .sidebar-profile a,
    .sidebar-collapsed .sidebar-logout {
      justify-content: center;
    }

    .sidebar-collapsed .sidebar-profile .profile-info,
    .sidebar-collapsed .sidebar-logout span {
      display: none;
    }

    .sidebar-collapsed .sidebar-profile {
      padding: 0.75rem;
    }

    .sidebar-collapsed .sidebar-profile a {
      gap: 0;
    }

    /* Sidebar Overlay for Mobile */
    .sidebar-overlay {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0, 0.5);
      z-index: 1040;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s ease, visibility 0.3s ease;
    }

    .sidebar-overlay.show {
      opacity: 1;
      visibility: visible;
    }

    @media (min-width: 993px) {
      .sidebar-overlay {
        display: none;
      }
    }

    /* Responsive */
    @media (max-width: 992px) {
      body {
        padding-left: 0;
      }

      .main-sidebar {
        transform: translateX(-100%);
      }

      .main-sidebar.show {
        transform: translateX(0);
        box-shadow: 10px 0 30px rgba(0, 0, 0, 0.1);
      }

      .main-header {
        left: 0;
      }

      /* Collapsed state on mobile */
      body.sidebar-collapsed {
        padding-left: 0;
      }
      
      .sidebar-collapsed .main-sidebar {
        transform: translateX(-100%);
        width: var(--sidebar-width);
      }
      
      .sidebar-collapsed .main-sidebar.show {
        transform: translateX(0);
      }
      
      .sidebar-collapsed .main-header {
        left: 0;
      }
    }

    /* Gonet Branding */
    .brand-logo {
      height: 42px;
      margin-right: 10px;
      transition: transform 1s ease;
      transform-origin: center center;
    }

    /* Animation for logo rotation */
    @keyframes rotateLogo {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    /* Animation for logo rotation back */
    @keyframes rotateLogoBack {
      0% { transform: rotate(360deg); }
      100% { transform: rotate(0deg); }
    }

    .brand-name {
      background: linear-gradient(135deg, #3f37c9, #4361ee, #4cc9f0);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      text-fill-color: transparent;
      font-weight: 800;
    }

    .arsip-surat {
      color: #1e293b;
      font-weight: 600;
    }

    /* Sidebar divider */
    .sidebar-divider {
      height: 1px;
      background: var(--border-color);
      margin: 1rem 1.5rem;
    }

    /* Animation for logout button */
    .sidebar-logout {
      transition: all 0.3s ease;
    }

    .sidebar-logout:hover {
      background-color: rgba(220, 53, 69, 0.1) !important;
      color: #dc3545 !important;
    }

    .sidebar-logout:hover i {
      color: #dc3545 !important;
      transform: translateY(-3px);
      transition: transform 0.3s ease;
    }

    /* Custom styles for SweetAlert2 */
    .swal2-popup {
      border-radius: 12px !important;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
      overflow: hidden;
    }

    .swal2-title {
      font-size: 1.5rem !important;
      font-weight: 600 !important;
      color: #1e293b !important;
    }

    .swal2-html-container {
      font-size: 1rem !important;
      color: #64748b !important;
    }

    .btn-logout-confirm {
      background-color: #dc3545 !important;
      border-color: #dc3545 !important;
      border-radius: 8px !important;
      padding: 0.5rem 1.5rem !important;
      font-weight: 500 !important;
      transition: all 0.2s ease !important;
    }

    .btn-logout-confirm:hover {
      background-color: #bb2d3b !important;
      border-color: #bb2d3b !important;
      transform: translateY(-2px);
    }

    .btn-logout-cancel {
      background-color: #6c757d !important;
      border-color: #6c757d !important;
      border-radius: 8px !important;
      padding: 0.5rem 1.5rem !important;
      font-weight: 500 !important;
      transition: all 0.2s ease !important;
    }

    .btn-logout-cancel:hover {
      background-color: #5c636a !important;
      border-color: #5c636a !important;
      transform: translateY(-2px);
    }

    [data-theme="dark"] .swal2-popup {
      background-color: #1a2236 !important;
      border: 1px solid var(--border-color) !important;
    }

    [data-theme="dark"] .swal2-title {
      color: #e2e8f0 !important;
    }

    [data-theme="dark"] .swal2-html-container {
      color: #a0aec0 !important;
    }
  </style>
</head>

<body>
  <div class="wrapper">

    <!-- Sidebar -->
    <aside class="main-sidebar" id="sidebarMenu">
      <nav class="nav flex-column">
        <a href="/operator/dashboard" class="nav-link <?= current_url() == site_url('/operator/dashboard') ? 'active' : '' ?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard">
          <i class="bi bi-speedometer2"></i>
          <span>Dashboard</span>
        </a>
        <a href="/operator/users" class="nav-link <?= strpos(current_url(), 'users') !== false ? 'active' : '' ?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Kelola User Biasa">
          <i class="bi bi-people"></i>
          <span>Kelola User Biasa</span>
        </a>
        <a href="/operator/surat-masuk" class="nav-link <?= strpos(current_url(), 'surat-masuk') !== false ? 'active' : '' ?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Surat Masuk">
          <i class="bi bi-envelope"></i>
          <span>Surat Masuk</span>
        </a>
        <a href="/operator/surat-keluar" class="nav-link <?= strpos(current_url(), 'surat-keluar') !== false ? 'active' : '' ?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Surat Keluar">
          <i class="bi bi-envelope-open"></i>
          <span>Surat Keluar</span>
        </a>
        <a href="/operator/disposisi" class="nav-link <?= strpos(current_url(), 'disposisi') !== false ? 'active' : '' ?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Histori Disposisi">
          <i class="bi bi-share"></i>
          <span>Histori Disposisi</span>
        </a>


        <!-- Bagian bawah (profil + logout) -->
        <div class="mt-auto">
          <div class="sidebar-divider"></div>
          <div class="sidebar-profile">
            <a href="/operator/profile">
              <?php if ($user['photo'] ?? false) : ?>
                <img src="/uploads/profiles/<?= esc($user['photo']) ?>" alt="Foto Profil">
              <?php else : ?>
                <div class="nav-avatar">
                  <i class="bi bi-person-circle"></i>
                </div>
              <?php endif; ?>
              <div class="profile-info">
                <div class="profile-name"><?= esc($user['full_name'] ?? 'Guest') ?></div>
                <div class="profile-role"><?= esc($user['role'] ?? '') ?></div>
              </div>
            </a>
          </div>
          <a href="#" class="nav-link sidebar-logout" id="logoutButton">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
          </a>
        </div>
      </nav>
    </aside>

    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand-lg navbar-light">
      <div class="container-fluid px-4">
        <a href="/operator/dashboard" class="navbar-brand" id="sidebarToggle">
          <img src="/uploads/logo.png" alt="Logo Gonet" class="brand-logo">
          <span class="arsip-surat">Arsip Surat <span class="brand-name">GONET</span></span>
        </a>

        <div class="d-flex align-items-center ms-auto">
          <!-- Theme Toggle Button -->
          <button class="theme-toggle" id="themeToggle" title="Toggle dark/light mode">
            <i class="bi bi-sun-fill" id="themeIcon"></i>
          </button>
        </div>
      </div>
    </nav>

    <!-- Content -->
    <div class="content-wrapper">
      <div class="container-fluid">
        <?= $this->renderSection('content') ?>
      </div>
    </div>

  </div>

  <!-- JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    // Theme Toggle Functionality - FIXED VERSION
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = document.getElementById('themeIcon');
    const htmlElement = document.documentElement;

    // Buat kunci unik untuk setiap pengguna
    const userId = '<?= $user["id"] ?? "guest" ?>';
    const themeKey = `theme_operator_${userId}`;
    const sidebarKey = `sidebarCollapsed_${userId}`; // Kunci unik untuk sidebar state

    // Check for saved theme preference
    const savedTheme = localStorage.getItem(themeKey);
    
    // Set initial theme berdasarkan preferensi yang disimpan
    if (savedTheme === 'dark') {
      htmlElement.setAttribute('data-theme', 'dark');
      themeIcon.classList.remove('bi-sun-fill');
      themeIcon.classList.add('bi-moon-stars-fill');
    } else {
      // Default ke light mode jika tidak ada preferensi tersimpan
      htmlElement.removeAttribute('data-theme');
      themeIcon.classList.remove('bi-moon-stars-fill');
      themeIcon.classList.add('bi-sun-fill');
      
      // Simpan default theme jika belum ada
      if (!savedTheme) {
        localStorage.setItem(themeKey, 'light');
      }
    }

    // Toggle theme
    themeToggle.addEventListener('click', () => {
      if (htmlElement.getAttribute('data-theme') === 'dark') {
        htmlElement.removeAttribute('data-theme');
        localStorage.setItem(themeKey, 'light');
        themeIcon.classList.remove('bi-moon-stars-fill');
        themeIcon.classList.add('bi-sun-fill');
      } else {
        htmlElement.setAttribute('data-theme', 'dark');
        localStorage.setItem(themeKey, 'dark');
        themeIcon.classList.remove('bi-sun-fill');
        themeIcon.classList.add('bi-moon-stars-fill');
      }
    });

    // Add mouse events for logo animation
    const logo = document.querySelector('.brand-logo');
    const navbarBrand = document.querySelector('.navbar-brand');
    
    navbarBrand.addEventListener('mouseenter', function() {
      logo.style.animation = 'rotateLogo 0.7s forwards';
    });
    
    navbarBrand.addEventListener('mouseleave', function() {
      logo.style.animation = 'rotateLogoBack 0.7s forwards';
    });

    // Toggle sidebar when clicking the logo
    document.getElementById('sidebarToggle').addEventListener('click', function(e) {
      // On desktop (width > 992px), prevent default and toggle sidebar
      if (window.innerWidth > 992) {
        e.preventDefault();
        
        // Toggle sidebar
        document.body.classList.toggle('sidebar-collapsed');
        
        // Save state to localStorage
        const isCollapsed = document.body.classList.contains('sidebar-collapsed');
        localStorage.setItem(sidebarKey, isCollapsed);
        
        // Update tooltips
        updateTooltips(isCollapsed);
      } else {
        // On mobile, prevent default and toggle sidebar with overlay
        e.preventDefault();
        toggleMobileSidebar();
      }
    });

    // Toggle sidebar on mobile with overlay
    function toggleMobileSidebar() {
      const sidebar = document.getElementById('sidebarMenu');
      const overlay = document.getElementById('sidebarOverlay');
      
      sidebar.classList.toggle('show');
      overlay.classList.toggle('show');
      
      // If sidebar is open, add event listener to close it when clicking outside
      if (sidebar.classList.contains('show')) {
        overlay.addEventListener('click', closeSidebarOnMobile);
        document.addEventListener('keydown', handleEscapeKey);
      } else {
        overlay.removeEventListener('click', closeSidebarOnMobile);
        document.removeEventListener('keydown', handleEscapeKey);
      }
    }

    // Close sidebar when clicking outside on mobile
    function closeSidebarOnMobile() {
      const sidebar = document.getElementById('sidebarMenu');
      const overlay = document.getElementById('sidebarOverlay');
      
      sidebar.classList.remove('show');
      overlay.classList.remove('show');
      overlay.removeEventListener('click', closeSidebarOnMobile);
      document.removeEventListener('keydown', handleEscapeKey);
    }

    // Close sidebar when pressing Escape key
    function handleEscapeKey(e) {
      if (e.key === 'Escape') {
        closeSidebarOnMobile();
      }
    }

    // Update tooltips based on sidebar state
    function updateTooltips(isCollapsed) {
      const tooltipList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      tooltipList.forEach(function(tooltipTriggerEl) {
        const tooltip = bootstrap.Tooltip.getInstance(tooltipTriggerEl);
        if (tooltip) {
          tooltip.dispose();
        }
        if (isCollapsed) {
          new bootstrap.Tooltip(tooltipTriggerEl, {
            trigger: 'hover',
            placement: 'right',
            container: 'body'
          });
        }
      });
    }

    // Check saved state on page load
    document.addEventListener('DOMContentLoaded', function() {
      const isCollapsed = localStorage.getItem(sidebarKey) === 'true';
      if (isCollapsed) {
        document.body.classList.add('sidebar-collapsed');
      }
      
      // Initialize tooltips if sidebar is collapsed
      if (isCollapsed) {
        updateTooltips(true);
      }
      
      // Prevent clicks inside sidebar from closing it
      document.getElementById('sidebarMenu').addEventListener('click', function(e) {
        e.stopPropagation();
      });
      
      // Close sidebar when clicking on content area on mobile
      document.querySelector('.content-wrapper').addEventListener('click', function() {
        if (window.innerWidth <= 992 && document.getElementById('sidebarMenu').classList.contains('show')) {
          closeSidebarOnMobile();
        }
      });
    });

    // Handle window resize
    window.addEventListener('resize', function() {
      if (window.innerWidth <= 992) {
        // On mobile, ensure sidebar is hidden by default
        closeSidebarOnMobile();
        document.body.classList.remove('sidebar-collapsed');
      }
    });

    // Logout Confirmation
    document.getElementById('logoutButton').addEventListener('click', function(e) {
      e.preventDefault();
      
      // SweetAlert2 confirmation with custom animations
      Swal.fire({
        title: 'Konfirmasi Logout',
        text: 'Apakah Anda yakin ingin keluar dari sistem?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Logout',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        customClass: {
          popup: 'animate__animated animate__slideInDown',
          actions: 'swal2-actions-logout',
          confirmButton: 'btn-logout-confirm',
          cancelButton: 'btn-logout-cancel'
        },
        showClass: {
          popup: 'animate__animated animate__slideInDown animate__faster'
        },
        hideClass: {
          popup: 'animate__animated animate__slideOutUp animate__faster'
        },
        didOpen: () => {
          // Tambahkan efek smooth setelah popup terbuka
          const popup = Swal.getPopup();
          popup.style.transform = 'translateY(0)';
          popup.style.opacity = '1';
          popup.style.transition = 'transform 0.3s ease-out, opacity 0.3s ease-out';
        },
        willClose: () => {
          // Tambahkan efek smooth saat popup akan ditutup
          const popup = Swal.getPopup();
          popup.style.transform = 'translateY(-50px)';
          popup.style.opacity = '0';
        }
      }).then((result) => {
        if (result.isConfirmed) {
          // Show loading animation
          Swal.fire({
            title: 'Logging out...',
            text: 'Sedang memproses logout',
            icon: 'info',
            showConfirmButton: false,
            allowOutsideClick: false,
            didOpen: () => {
              Swal.showLoading()
            },
            showClass: {
              popup: 'animate__animated animate__fadeIn animate__faster'
            },
            hideClass: {
              popup: 'animate__animated animate__fadeOut animate__faster'
            }
          });
          
          // Redirect to logout after a short delay
          setTimeout(() => {
            window.location.href = '/logout';
          }, 1000);
        }
      });
    });
  </script>
  <?= $this->renderSection('scripts') ?>
</body>

</html>
<?php else : ?>
  <h1 style="text-align: center; margin-top: 50px;">Akses Ditolak</h1>
  <p style="text-align: center;">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
<?php endif; ?>