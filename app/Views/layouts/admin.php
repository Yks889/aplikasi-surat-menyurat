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

  <!-- Custom CSS -->
  <style>
    :root {
      --primary: #0073b7;
      --secondary: #6c757d;
      --sidebar-width: 250px;
      --navbar-height: 56px;
    }

    html, body {
      height: 100%;
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f4f6f9;
    }

    .wrapper {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .main-header {
      height: var(--navbar-height);
      background-color: var(--primary);
      z-index: 1040;
    }

    .navbar-brand {
      font-weight: 600;
      color: #fff !important;
    }

    .main-sidebar {
      width: var(--sidebar-width);
      position: fixed;
      top: var(--navbar-height);
      left: 0;
      bottom: 0;
      background-color: #343a40;
      color: #c2c7d0;
      overflow-y: auto;
      padding-top: 1rem;
      z-index: 1030;
      transition: transform 0.3s ease-in-out;
    }

    .main-sidebar .nav-link {
      color: #c2c7d0;
    }

    .main-sidebar .nav-link.active {
      background-color: #0073b7;
      color: #fff;
    }

    .content-wrapper {
      flex: 1;
      margin-top: var(--navbar-height);
      margin-left: var(--sidebar-width);
      padding: 20px;
    }

    .main-footer {
      background-color: #fff;
      border-top: 1px solid #dee2e6;
      padding: 1rem 0;
      font-size: 0.875rem;
      width: 100%;
    }

    .footer-links a {
      color: var(--secondary);
      text-decoration: none;
      transition: color 0.2s ease-in-out;
    }

    .footer-links a:hover {
      color: var(--primary);
      text-decoration: underline;
    }

    @media (max-width: 992px) {
      .main-sidebar {
        transform: translateX(-100%);
      }

      .main-sidebar.show {
        transform: translateX(0);
      }

      .content-wrapper {
        margin-left: 0;
      }

      .main-footer {
        padding-left: 0;
      }
    }

    @media (min-width: 993px) {
      .main-footer {
        padding-left: var(--sidebar-width);
      }
    }
  </style>
</head>
<body>
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid px-4">
      <button class="btn btn-light d-lg-none me-2" id="sidebarToggle">
        <i class="bi bi-list"></i>
      </button>
      <a href="/admin/dashboard" class="navbar-brand">Sistem Arsip Surat</a>

      <ul class="navbar-nav ms-auto d-flex align-items-center">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-person-circle me-2"></i>
            <span><?= esc($user['full_name'] ?? 'Guest') ?></span>
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

  <!-- Sidebar -->
  <aside class="main-sidebar" id="sidebarMenu">
    <nav class="nav flex-column px-3">
      <div class="user-panel mb-3 text-white">
        <div><i class="bi bi-person-circle" style="font-size: 2rem;"></i></div>
        <div><?= esc($user['full_name'] ?? 'Guest') ?> <br> <small><?= esc(ucfirst($user['role'] ?? '')) ?></small></div>
      </div>
      <a href="/admin/dashboard" class="nav-link <?= current_url() == site_url('/admin/dashboard') ? 'active' : '' ?>"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
      <a href="/admin/surat-masuk" class="nav-link <?= strpos(current_url(), 'surat-masuk') !== false ? 'active' : '' ?>"><i class="bi bi-envelope me-2"></i> Surat Masuk</a>
      <a href="/admin/surat-keluar" class="nav-link <?= strpos(current_url(), 'surat-keluar') !== false ? 'active' : '' ?>"><i class="bi bi-envelope-open me-2"></i> Surat Keluar</a>
      <a href="/admin/users" class="nav-link <?= strpos(current_url(), 'users') !== false ? 'active' : '' ?>"><i class="bi bi-people me-2"></i> Kelola User</a>
      <a href="/admin/tanda-tangan" class="nav-link <?= strpos(current_url(), 'tanda-tangan') !== false ? 'active' : '' ?>"><i class="bi bi-pen me-2"></i> Tanda Tangan</a>
      <a href="/admin/perusahaan" class="nav-link <?= strpos(current_url(), 'perusahaan') !== false ? 'active' : '' ?>"><i class="bi bi-building me-2"></i> Perusahaan</a>
      <a href="/admin/jenis-surat" class="nav-link <?= strpos(current_url(), 'jenis-surat') !== false ? 'active' : '' ?>"><i class="bi bi-file-earmark-text me-2"></i> Jenis Surat</a>
    </nav>
  </aside>

  <!-- Content -->
  <div class="content-wrapper">
    <div class="container-fluid">
      <?= $this->renderSection('content') ?>
    </div>
  </div>

  <!-- Footer -->
  <footer class="main-footer mt-auto">
    <div class="container-fluid">
      <div class="row align-items-center">
        <div class="col-md-6 text-md-start text-center mb-2 mb-md-0">
          <strong>&copy; <?= date('Y') ?> Sistem Arsip Surat</strong>
        </div>
        <div class="col-md-6 text-md-end text-center">
          <div class="footer-links d-inline-flex gap-3">
            <a href="/about">Tentang</a>
            <a href="/privacy">Privasi</a>
            <a href="/terms">Syarat</a>
            <a href="/contact">Kontak</a>
          </div>
        </div>
      </div>
    </div>
  </footer>

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
