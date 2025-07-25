<?php $user = session()->get('user'); ?>
<?php if ($user && $user['role'] === 'admin') : ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= $title ?? 'Dashboard' ?> | Sistem Arsip Surat</title>

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
      --navbar-height: 70px;
      --sidebar-bg: #0f172a;
      --sidebar-text: #e2e8f0;
      --sidebar-active: rgba(67, 97, 238, 0.2);
      --content-bg: #f8fafc;
      --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      --sidebar-hover: rgba(100, 116, 139, 0.2);
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
      background-color: var(--content-bg);
      color: #334155;
      min-height: 100vh;
      padding-left: var(--sidebar-width);
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
      box-shadow: 0 1px 15px rgba(0, 0, 0, 0.04), 0 1px 6px rgba(0, 0, 0, 0.04);
      z-index: 1040;
      position: fixed;
      top: 0;
      left: var(--sidebar-width);
      right: 0;
      transition: var(--transition);
      backdrop-filter: blur(8px);
      background-color: rgba(255, 255, 255, 0.8);
    }

    .navbar-brand {
      font-weight: 700;
      color: var(--primary) !important;
      font-size: 1.25rem;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .navbar-brand i {
      color: var(--primary);
      font-size: 1.5rem;
    }

    /* Sidebar */
    .main-sidebar {
      width: var(--sidebar-width);
      position: fixed;
      top: 0;
      left: 0;
      bottom: 0;
      background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
      color: var(--sidebar-text);
      overflow-y: auto;
      padding: 1.5rem 0;
      z-index: 1050;
      transition: var(--transition);
      border-right: 1px solid rgba(255, 255, 255, 0.1);
    }

    .main-sidebar::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 120px;
      background: linear-gradient(180deg, rgba(67, 97, 238, 0.2) 0%, rgba(0, 0, 0, 0) 100%);
      pointer-events: none;
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
      opacity: 0.9;
    }

    .main-sidebar .nav-link:hover {
      background: var(--sidebar-hover);
      color: white;
      opacity: 1;
      transform: translateX(5px);
    }

    .main-sidebar .nav-link.active {
      background: linear-gradient(90deg, rgba(67, 97, 238, 0.3) 0%, rgba(67, 97, 238, 0.1) 100%);
      color: white;
      border-left: 3px solid var(--primary);
      opacity: 1;
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
      color: var(--primary-light);
    }

    /* User Panel */
    .user-panel {
      padding: 1.5rem;
      margin-bottom: 1rem;
      position: relative;
      z-index: 1;
    }

    .user-panel > div {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .user-panel i {
      font-size: 1.5rem;
      color: var(--primary-light);
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      width: 48px;
      height: 48px;
      border-radius: 12px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 6px rgba(67, 97, 238, 0.3);
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
      color: white;
    }

    /* Content */
    .content-wrapper {
      flex: 1;
      margin-top: var(--navbar-height);
      padding: 2rem;
      transition: var(--transition);
    }

    /* Footer */
    .main-footer {
      background-color: white;
      border-top: 1px solid #e2e8f0;
      padding: 1.25rem 0;
      font-size: 0.875rem;
      transition: var(--transition);
    }

    .footer-links a {
      color: var(--secondary);
      text-decoration: none;
      transition: color 0.2s ease;
      font-weight: 500;
    }

    .footer-links a:hover {
      color: var(--primary);
    }

    /* Sidebar Toggle Button */
    #sidebarToggle {
      border: none;
      background-color: var(--primary-light);
      color: var(--primary);
      width: 40px;
      height: 40px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: var(--transition);
    }

    #sidebarToggle:hover {
      background-color: var(--primary);
      color: white;
      transform: rotate(90deg);
    }

    /* Dropdown Menu */
    .dropdown-menu {
      border: none;
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
      border-radius: 8px;
      padding: 0.5rem;
      margin-top: 8px;
      border: 1px solid rgba(0, 0, 0, 0.05);
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
      width: 36px;
      height: 36px;
      border-radius: 8px;
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: 600;
      font-size: 0.9rem;
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
        box-shadow: 10px 0 30px rgba(0, 0, 0, 0.2);
      }

      .main-header {
        left: 0;
      }
    }

    /* Gonet Branding */
    .brand-logo {
      height: 30px;
      margin-right: 10px;
    }

    .brand-name {
      background: linear-gradient(135deg, #4cc9f0, #4361ee, #3f37c9);
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
      background: rgba(255, 255, 255, 0.1);
      margin: 1rem 1.5rem;
    }
  </style>
</head>
<body>
<div class="wrapper">

  <!-- Sidebar -->
  <aside class="main-sidebar" id="sidebarMenu">
    <div class="user-panel">
      <div>
        <?php if ($user['photo'] ?? false) : ?>
          <img src="/uploads/profiles/<?= $user['photo'] ?>" class="rounded-circle" width="48" height="48" alt="Foto Profil">
        <?php else : ?>
          <i class="bi bi-person-circle"></i>
        <?php endif; ?>
        <div class="user-info">
          <div class="user-name"><?= esc($user['full_name'] ?? 'Guest') ?></div>
          <small><?= esc(ucfirst($user['role'] ?? '')) ?></small>
        </div>
      </div>
    </div>

    <div class="sidebar-divider"></div>

    <nav class="nav flex-column">
      <a href="/admin/dashboard" class="nav-link <?= current_url() == site_url('/admin/dashboard') ? 'active' : '' ?>">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>
      </a>
      <a href="/admin/users" class="nav-link <?= strpos(current_url(), 'users') !== false ? 'active' : '' ?>">
        <i class="bi bi-people"></i>
        <span>Kelola User</span>
      </a>
      <a href="/admin/surat-masuk" class="nav-link <?= strpos(current_url(), 'surat-masuk') !== false ? 'active' : '' ?>">
        <i class="bi bi-envelope"></i>
        <span>Surat Masuk</span>
      </a>
      <a href="/admin/surat-keluar" class="nav-link <?= strpos(current_url(), 'surat-keluar') !== false ? 'active' : '' ?>">
        <i class="bi bi-envelope-open"></i>
        <span>Surat Keluar</span>
      </a>
      <a href="/admin/disposisi" class="nav-link <?= strpos(current_url(), 'disposisi') !== false ? 'active' : '' ?>">
        <i class="bi bi-share"></i>
        <span>Histori Disposisi</span>
      </a>

      
      <div class="sidebar-divider"></div>

      <a href="/admin/tanda-tangan" class="nav-link <?= strpos(current_url(), 'tanda-tangan') !== false ? 'active' : '' ?>">
        <i class="bi bi-pen"></i>
        <span>Tanda Tangan</span>
      </a>
      <a href="/admin/perusahaan" class="nav-link <?= strpos(current_url(), 'perusahaan') !== false ? 'active' : '' ?>">
        <i class="bi bi-building"></i>
        <span>Perusahaan</span>
      </a>
      <a href="/admin/jenis-surat" class="nav-link <?= strpos(current_url(), 'jenis-surat') !== false ? 'active' : '' ?>">
        <i class="bi bi-file-earmark-text"></i>
        <span>Jenis Surat</span>
      </a>
    </nav>
  </aside>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-lg navbar-light">
    <div class="container-fluid px-4">
      <button class="btn d-lg-none me-2" id="sidebarToggle">
        <i class="bi bi-list"></i>
      </button>
      <a href="/admin/dashboard" class="navbar-brand">
        <img src="/uploads/logo.png" alt="Logo Gonet" class="brand-logo">
        <span class="arsip-surat">Arsip Surat <span class="brand-name">Gonet</span></span>
      </a>

      <div class="d-flex align-items-center ms-auto">
        <div class="dropdown">
          <a class="dropdown-toggle d-flex align-items-center text-decoration-none" href="#" data-bs-toggle="dropdown">
            <div class="nav-avatar me-2">
              <?= substr(esc($user['full_name'] ?? 'G'), 0, 1) ?>
            </div>
            <div class="d-none d-md-block">
              <div class="fw-semibold"><?= esc($user['full_name'] ?? 'Guest') ?></div>
              <small class="text-muted" style="font-size: 0.75rem;"><?= esc(ucfirst($user['role'] ?? '')) ?></small>
            </div>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li>
              <a class="dropdown-item d-flex align-items-center" href="/admin/profile">
                <i class="bi bi-person me-2"></i> 
                <span>Profil Saya</span>
              </a>
            </li>
            <li><hr class="dropdown-divider"></li>
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
  // Toggle sidebar on small screen
  document.getElementById('sidebarToggle').addEventListener('click', function () {
    document.getElementById('sidebarMenu').classList.toggle('show');
  });
</script>
<?= $this->renderSection('scripts') ?>
</body>
</html>
<?php else : ?>
  <h1 style="text-align: center; margin-top: 50px;">Akses Ditolak</h1>
  <p style="text-align: center;">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
<?php endif; ?>