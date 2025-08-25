<?php $user = session()->get('user'); ?>
<?php if ($user && $user['role'] === 'admin') : ?>
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
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Custom CSS -->
  <style>
    :root {
      --primary: #4361ee;
      --primary-dark: #3a0ca3;
      --primary-light: #f0f5ff;
      --secondary: #6c757d;
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

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
      background-color: var(--content-bg);
      color: #334155;
      min-height: 100vh;
      padding-left: var(--sidebar-width);
      padding-top: var(--navbar-height);
      transition: var(--transition);
    }

    .wrapper {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
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
      transform: translateX(5px);
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

    /* User Panel */
    .user-panel {
      padding: 1.5rem;
      margin-bottom: 1rem;
      position: relative;
      z-index: 1;
    }

    .user-panel>div {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .user-panel i {
      font-size: 1.5rem;
      color: white;
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      width: 48px;
      height: 48px;
      border-radius: 12px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 6px rgba(67, 97, 238, 0.2);
    }

    .user-panel small {
      color: #94a3b8;
      font-size: 0.8rem;
      display: block;
      margin-top: 4px;
    }

    .user-info {
      overflow: hidden;
    }

    .user-name {
      white-space: nowrap;
      text-overflow: ellipsis;
      overflow: hidden;
      font-weight: 600;
      color: #1e293b;
    }

    /* Content */
    .content-wrapper {
      flex: 1;
      padding: 2rem;
      transition: var(--transition);
    }

    /* Dropdown Menu */
    .dropdown-menu {
      border: 1px solid var(--border-color);
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.03);
      border-radius: 8px;
      padding: 0.5rem;
      margin-top: 8px;
    }

    .dropdown-item {
      padding: 0.5rem 1rem;
      border-radius: 6px;
      font-weight: 500;
      transition: var(--transition);
    }

    .dropdown-item i {
      width: 20px;
      display: inline-flex;
      justify-content: center;
      margin-right: 8px;
    }

    .dropdown-item:hover {
      background-color: var(--primary-light);
      color: var(--primary);
    }

    /* Navbar avatar */
    .nav-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: 600;
      font-size: 36px;
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
  </style>
</head>

<body>
  <div class="wrapper">

    <!-- Sidebar -->
    <aside class="main-sidebar" id="sidebarMenu">
    

      <nav class="nav flex-column">
        <a href="/admin/dashboard" class="nav-link <?= current_url() == site_url('/admin/dashboard') ? 'active' : '' ?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard">
          <i class="bi bi-speedometer2"></i>
          <span>Dashboard</span>
        </a>
        <a href="/admin/users" class="nav-link <?= strpos(current_url(), 'users') !== false ? 'active' : '' ?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Kelola User">
          <i class="bi bi-people"></i>
          <span>Kelola User</span>
        </a>
        <a href="/admin/activity" class="nav-link <?= strpos(current_url(), 'activity') !== false ? 'active' : '' ?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Activities User">
          <i class="bi bi-journal-text"></i>
          <span>Aktivitas User</span>
        </a>
        <a href="/admin/surat-masuk" class="nav-link <?= strpos(current_url(), 'surat-masuk') !== false ? 'active' : '' ?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Surat Masuk">
          <i class="bi bi-envelope"></i>
          <span>Surat Masuk</span>
        </a>
        <a href="/admin/surat-keluar" class="nav-link <?= strpos(current_url(), 'surat-keluar') !== false ? 'active' : '' ?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Surat Keluar">
          <i class="bi bi-envelope-open"></i>
          <span>Surat Keluar</span>
        </a>
        <a href="/admin/ajukan" class="nav-link <?= strpos(current_url(), 'ajukan') !== false ? 'active' : '' ?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Pengajuan Surat">
          <i class="bi bi-envelope-open"></i>
          <span>Pengajuan Surat</span>
        </a>
        <a href="/admin/disposisi" class="nav-link <?= strpos(current_url(), 'disposisi') !== false ? 'active' : '' ?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Histori Disposisi">
          <i class="bi bi-share"></i>
          <span>Histori Disposisi</span>
        </a>

        <div class="sidebar-divider"></div>

        <a href="/admin/tanda-tangan" class="nav-link <?= strpos(current_url(), 'tanda-tangan') !== false ? 'active' : '' ?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Tanda Tangan">
          <i class="bi bi-pen"></i>
          <span>Tanda Tangan</span>
        </a>
        <a href="/admin/perusahaan" class="nav-link <?= strpos(current_url(), 'perusahaan') !== false ? 'active' : '' ?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Perusahaan">
          <i class="bi bi-building"></i>
          <span>Perusahaan</span>
        </a>
        <a href="/admin/jenis-surat" class="nav-link <?= strpos(current_url(), 'jenis-surat') !== false ? 'active' : '' ?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Jenis Surat">
          <i class="bi bi-file-earmark-text"></i>
          <span>Jenis Surat</span>
        </a>
      </nav>
    </aside>

    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand-lg navbar-light">
      <div class="container-fluid px-4">
        <a href="/admin/dashboard" class="navbar-brand" id="sidebarToggle">
          <img src="/uploads/logo.png" alt="Logo Gonet" class="brand-logo">
          <span class="arsip-surat">Arsip Surat <span class="brand-name">GONET</span></span>
        </a>

        <div class="d-flex align-items-center ms-auto">
          <!-- Theme Toggle Button -->
          <button class="theme-toggle" id="themeToggle" title="Toggle dark/light mode">
            <i class="bi bi-sun-fill" id="themeIcon"></i>
          </button>
          
          <div class="dropdown">
            <a class="dropdown-toggle d-flex align-items-center text-decoration-none" href="#" data-bs-toggle="dropdown">
              <?php if ($user['photo'] ?? false) : ?>
                <!-- Foto Profil -->
                <img src="/uploads/profiles/<?= esc($user['photo']) ?>" 
                    alt="Foto Profil" 
                    class="rounded-circle me-2" 
                    width="42" height="42"
                    style="object-fit: cover;">
              <?php else : ?>
                <!-- Avatar fallback seperti sidebar -->
                <div class="nav-avatar me-2">
                  <i class="bi bi-person-circle"></i>
                </div>
              <?php endif; ?>

              <div class="d-none d-md-block">
                <div class="fw-semibold user-name"><?= esc($user['full_name'] ?? 'Guest') ?></div>
                <small class="text-muted" style="font-size: 0.75rem;"><?= esc($user['role'] ?? '') ?></small>
              </div>
            </a>

            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a class="dropdown-item d-flex align-items-center" href="/admin/profile">
                  <i class="bi bi-person me-2"></i>
                  <span>Profil Saya</span>
                </a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <a class="dropdown-item d-flex align-items-center" href="/logout">
                  <i class="bi bi-box-arrow-right me-2"></i>
                  <span>Logout</span>
                </a>
              </li>
            </ul>
          </div>
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
    // Theme Toggle Functionality
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = document.getElementById('themeIcon');
    const htmlElement = document.documentElement;

    // Buat kunci unik untuk setiap pengguna dengan menggabungkan ID
    const userId = '<?= $user["id"] ?? "guest" ?>'; // Pastikan user ID tersedia di session
    const themeKey = `theme_admin_${userId}`; // Kunci unik per pengguna
    const sidebarKey = `sidebarCollapsed_${userId}`; // Kunci unik untuk sidebar state

    // Check for saved theme preference - default to light mode for new users
    const savedTheme = localStorage.getItem(themeKey);
    
    // Set initial theme - default to light mode if no preference saved
    if (savedTheme === 'light' || (!savedTheme && prefersDark)) {
      htmlElement.setAttribute('data-theme', 'light');
      themeIcon.classList.remove('bi-sun-fill');
      themeIcon.classList.add('bi-moon-stars-fill');
    } else {
      // Default to light mode for new users
      htmlElement.removeAttribute('data-theme');
      localStorage.setItem(themeKey, 'light'); // Set default to light
      themeIcon.classList.remove('bi-moon-stars-fill');
      themeIcon.classList.add('bi-sun-fill');
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
  </script>
  <?= $this->renderSection('scripts') ?>
</body>

</html>
<?php else : ?>
  <h1 style="text-align: center; margin-top: 50px;">Akses Ditolak</h1>
  <p style="text-align: center;">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
<?php endif; ?>