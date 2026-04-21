<?php $activePage = $activePage ?? ''; ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Nexgeno Partner Hero</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="styles.css" rel="stylesheet">
</head>
<body class="hero-page">
  <div class="hero-wrap">
    <nav class="navbar navbar-expand-lg navbar-dark hero-navbar">
      <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
          <span class="logo-box">N</span>
          <span class="fw-semibold">Nexgeno</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
          <ul class="navbar-nav mx-auto gap-lg-2">
            <li class="nav-item"><a class="nav-link <?php echo $activePage === 'home' ? 'active' : ''; ?>" href="index.php">Home</a></li>
            <li class="nav-item"><a class="nav-link <?php echo $activePage === 'services' ? 'active' : ''; ?>" href="services.php">Services</a></li>
            <li class="nav-item"><a class="nav-link" href="commission.html">Commission</a></li>
            <li class="nav-item"><a class="nav-link" href="partner-types.html">Partner Types</a></li>
            <li class="nav-item"><a class="nav-link" href="onboarding.html">Onboarding</a></li>
            <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
            <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
          </ul>
          <a class="btn btn-sm hero-top-btn" href="apply.html">Become a Partner</a>
        </div>
      </div>
    </nav>
