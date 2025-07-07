<?php $user = session()->get('user'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= $title ?? 'Dashboard' ?> | Sistem Arsip Surat</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet" />

  <style>
    :root {
      --primary: #0073b7;
      --sidebar-width: 240px;
      --navbar-height: 56px;
    }

    body {
      margin: 0;
      background-color: #f4f6f9;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .wrapper {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .main-header {
      height: var(--navbar-height);
      background-color: var(--primary);
    }

    .navbar-brand {
      font-weight: 600;
      color: #fff !important;
    }

    .main-sidebar {
      position: fixed;
      top: var(--navbar-height);
      left: 0;
      bottom: 0;
      width: var(--sidebar-width);
      background-color: #2d3238;
      padding-top: 1rem;
      overflow-y: auto;
      z-index: 1040;
      transition: left 0.3s ease-in-out;
    }

    .sidebar .nav-link {
      color: #c2c7d0;
      padding: 10px 20px;
      display: flex;
      align-items: center;
      border-radius: 4px;
      margin: 4px 10px;
      transition: background-color 0.2s;
    }

    .sidebar .nav-link:hover {
      background-color: #3c4148;
      color: #fff;
    }

    .sidebar .nav-link.active {
      background-color: var(--primary);
      color: #fff;
    }

    .sidebar .nav-link i {
      margin-right: 12px;
      font-size: 1.1rem;
    }

    .user-panel {
      color: #fff;
      padding: 0 20px 1rem 20px;
      margin-bottom: 1rem;
      border-bottom: 1px solid #444;
    }

    .content-wrapper {
      margin-top: var(--navbar-height);
      margin-left: var(--sidebar-width);
      padding: 20px;
    }

    .main-footer {
      margin-left: var(--sidebar-width);
      padding: 1rem;
      font-size: 0.875rem;
      background-color: #fff;
      border-top: 1px solid #dee2e6;
    }

    /* Responsive */
    @media (max-width: 992px) {
      .main-sidebar {
        left: -100%;
      }

      .main-sidebar.show {
        left: 0;
      }

      .content-wrapper {
        margin-left: 0;
      }

      .main-footer {
        margin-left: 0;
      }
    }

    .footer-links a {
      color: #6c757d;
      margin-left: 15px;
      text-decoration: none;
    }

    .footer-links a:hover {
      color: var(--primary);
    }
  </style>
</head>
<body>
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid px-4">
      <!-- Toggle Sidebar Button -->
      <button class="btn btn-sm btn-light d-lg-none me-3" id="toggleSidebar">
        <i class="bi bi-list"></i>
      </button>

      <a href="/operator/dashboard" class="navbar-brand">Sistem Arsip Surat</a>

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
    <div class="sidebar">
      <div class="user-panel d-flex align-items-center">
        <i class="bi bi-person-circle me-2" style="font-size: 2rem;"></i>
        <div>
          <div><?= esc($user['full_name'] ?? 'Guest') ?></div>
          <small><?= esc(ucfirst($user['role'] ?? '')) ?></small>
        </div>
      </div>
      <nav>
        <ul class="nav flex-column">
          <li>
            <a href="/operator/dashboard" class="nav-link <?= current_url() == site_url('/operator/dashboard') ? 'active' : '' ?>">
              <i class="bi bi-speedometer2"></i> Dashboard
            </a>
          </li>
          <li>
            <a href="/operator/surat-masuk" class="nav-link <?= strpos(current_url(), 'surat-masuk') !== false ? 'active' : '' ?>">
              <i class="bi bi-envelope"></i> Surat Masuk
            </a>
          </li>
          <li>
            <a href="/operator/surat-keluar" class="nav-link <?= strpos(current_url(), 'surat-keluar') !== false ? 'active' : '' ?>">
              <i class="bi bi-envelope-open"></i> Surat Keluar
            </a>
          </li>
          <li>
            <a href="/operator/users" class="nav-link <?= strpos(current_url(), 'users') !== false ? 'active' : '' ?>">
              <i class="bi bi-people"></i> Kelola User Biasa
            </a>
          </li>
        </ul>
      </nav>
    </div>
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
        <div class="col-md-6 text-md-end text-center footer-links">
          <a href="/about">Tentang</a>
          <a href="/privacy">Privasi</a>
          <a href="/terms">Syarat</a>
          <a href="/contact">Kontak</a>
        </div>
      </div>
    </div>
  </footer>

</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Sidebar Toggle Script -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const toggleSidebar = document.getElementById("toggleSidebar");
    const sidebar = document.getElementById("sidebarMenu");

    toggleSidebar?.addEventListener("click", function () {
      sidebar.classList.toggle("show");
    });

    // Klik di luar sidebar untuk menutup (hanya di mobile)
    document.addEventListener("click", function (e) {
      if (window.innerWidth < 992 &&
          !sidebar.contains(e.target) &&
          !toggleSidebar.contains(e.target)) {
        sidebar.classList.remove("show");
      }
    });
  });
</script>

<?= $this->renderSection('scripts') ?>
</body>
</html>
