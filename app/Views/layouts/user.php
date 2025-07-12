<?php $user = session()->get('user'); ?>
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
      --sidebar-bg: #1e293b;
      --sidebar-text: #e2e8f0;
      --sidebar-active: rgba(67, 97, 238, 0.2);
      --content-bg: #f8fafc;
      --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
      background-color: var(--content-bg);
      color: #334155;
      min-height: 100vh;
      padding-left: var(--sidebar-width);
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
      box-shadow: var(--card-shadow);
      z-index: 1040;
      border-bottom: 1px solid #e2e8f0;
      position: fixed;
      top: 0;
      left: var(--sidebar-width);
      right: 0;
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
      background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
      color: var(--sidebar-text);
      overflow-y: auto;
      padding: 1.5rem 0;
      z-index: 1050;
      transition: var(--transition);
      border-right: none;
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
    }

    .main-sidebar .nav-link:hover {
      background: rgba(67, 97, 238, 0.15);
      color: white;
    }

    .main-sidebar .nav-link.active {
      background: linear-gradient(90deg, rgba(67, 97, 238, 0.3) 0%, rgba(67, 97, 238, 0.1) 100%);
      color: white;
      border-left: 3px solid var(--primary);
    }

    .main-sidebar .nav-link i {
      font-size: 1.1rem;
      width: 24px;
      display: inline-flex;
      justify-content: center;
    }

    /* User Panel */
    .user-panel {
      padding: 1.5rem;
      margin-bottom: 1rem;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .user-panel > div {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .user-panel i {
      font-size: 2rem;
      color: var(--primary-light);
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      width: 48px;
      height: 48px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }

    .user-panel small {
      color: #94a3b8;
      font-size: 0.8rem;
      display: block;
      margin-top: 4px;
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
    }

    /* Dropdown Menu */
    .dropdown-menu {
      border: none;
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
      border-radius: 8px;
      padding: 0.5rem;
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
      }

      .main-header {
        left: 0;
      }
    }

    @media (min-width: 993px) {
      .main-sidebar:hover {
        width: var(--sidebar-width);
      }
    }
  </style>
</head>
<body>
<div class="wrapper">

  <!-- Sidebar -->
  <aside class="main-sidebar" id="sidebarMenu">
    <div class="user-panel">
      <div>
        <i class="bi bi-person-circle"></i>
        <div>
          <?= esc($user['full_name'] ?? 'Guest') ?>
          <small><?= esc(ucfirst($user['role'] ?? '')) ?></small>
        </div>
      </div>
    </div>
    <nav class="nav flex-column">
      <a href="/user/dashboard" class="nav-link <?= current_url() == site_url('/user/dashboard') ? 'active' : '' ?>">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>
      </a>
      <a href="/user/kirim-surat" class="nav-link <?= strpos(current_url(), 'kirim-surat') !== false ? 'active' : '' ?>">
        <i class="bi bi-send"></i>
        <span>Form Surat Masuk</span>
      </a>
      <a href="/user/history-surat-masuk" class="nav-link <?= strpos(current_url(), 'history-surat-masuk') !== false ? 'active' : '' ?>">
        <i class="bi bi-clock-history"></i>
        <span>History Surat Masuk</span>
      </a>
    </nav>
  </aside>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-lg navbar-light">
    <div class="container-fluid px-4">
      <button class="btn d-lg-none me-2" id="sidebarToggle">
        <i class="bi bi-list"></i>
      </button>
      <a href="/user/dashboard" class="navbar-brand">
        <i class="bi bi-archive"></i>
        <span>Sistem Arsip Surat</span>
      </a>

      <ul class="navbar-nav ms-auto d-flex align-items-center">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown">
            <div class="d-flex align-items-center">
              <i class="bi bi-person-circle me-2" style="font-size: 1.5rem;"></i>
              <div class="d-none d-md-block">
                <div><?= esc($user['full_name'] ?? 'Guest') ?></div>
                <small class="text-muted" style="font-size: 0.75rem;"><?= esc(ucfirst($user['role'] ?? '')) ?></small>
              </div>
            </div>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i> Profil</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="/logout"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
          </ul>
        </li>
      </ul>
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
<script>
  // Toggle sidebar on small screen
  document.getElementById('sidebarToggle').addEventListener('click', function () {
    document.getElementById('sidebarMenu').classList.toggle('show');
  });
</script>
<?= $this->renderSection('scripts') ?>
</body>
</html>