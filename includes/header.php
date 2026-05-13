<?php
/**
 * Portfolio Pro - Site Header
 */
$admin = getAdmin();
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="<?= sanitize($admin['name'] ?? 'Developer') ?> - <?= sanitize($admin['title'] ?? 'Full Stack Developer') ?> Portfolio" />
  <title><?= sanitize($admin['name'] ?? 'Portfolio') ?> | <?= sanitize($admin['title'] ?? 'Full Stack Developer') ?></title>

  <!-- Bootstrap 5 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"/>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <!-- AOS Animation -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css"/>
  <!-- Google Fonts: Space Mono + DM Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400&family=DM+Sans:wght@300;400;500;600;700&family=Syne:wght@700;800&display=swap" rel="stylesheet"/>
  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css"/>
</head>
<body>

<!-- Loader -->
<div id="page-loader">
  <div class="loader-inner">
    <span class="loader-dot"></span>
    <span class="loader-dot"></span>
    <span class="loader-dot"></span>
  </div>
</div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
  <div class="container">
    <a class="navbar-brand" href="<?= SITE_URL ?>">
      <span class="brand-bracket">&lt;</span><?= sanitize($admin['name'] ?? 'Portfolio') ?><span class="brand-bracket">/&gt;</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span><i class="fas fa-bars"></i></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto align-items-center gap-1">
        <li class="nav-item"><a class="nav-link <?= $currentPage==='index'?'active':'' ?>" href="<?= SITE_URL ?>">Home</a></li>
        <li class="nav-item"><a class="nav-link <?= $currentPage==='about'?'active':'' ?>" href="<?= SITE_URL ?>/about.php">About</a></li>
        <li class="nav-item"><a class="nav-link <?= $currentPage==='education'?'active':'' ?>" href="<?= SITE_URL ?>/education.php">Education</a></li>
        <li class="nav-item"><a class="nav-link <?= $currentPage==='experience'?'active':'' ?>" href="<?= SITE_URL ?>/experience.php">Experience</a></li>
        <li class="nav-item"><a class="nav-link <?= $currentPage==='projects'?'active':'' ?>" href="<?= SITE_URL ?>/projects.php">Projects</a></li>
        <li class="nav-item"><a class="nav-link <?= $currentPage==='contact'?'active':'' ?>" href="<?= SITE_URL ?>/contact.php">Contact</a></li>
        <li class="nav-item">
          <button id="themeToggle" class="btn btn-sm theme-btn" title="Toggle Theme">
            <i class="fas fa-sun"></i>
          </button>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- End Navbar -->
