<?php
$activePage = $activePage ?? '';
$compactHeroWrap = $compactHeroWrap ?? false;
$pageTitle = $pageTitle ?? 'Nexgeno Partners';
$bodyPageClass = $bodyPageClass ?? '';
$heroWrapExtraClass = $heroWrapExtraClass ?? '';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="styles.css?v=1.4" rel="stylesheet">
</head>
<body class="hero-page<?php echo $bodyPageClass !== '' ? ' ' . htmlspecialchars($bodyPageClass, ENT_QUOTES, 'UTF-8') : ''; ?>">
  <div class="hero-wrap<?php echo $compactHeroWrap ? ' hero-wrap-compact' : ''; ?><?php echo $heroWrapExtraClass !== '' ? ' ' . htmlspecialchars($heroWrapExtraClass, ENT_QUOTES, 'UTF-8') : ''; ?>">
    <nav class="navbar navbar-expand-lg navbar-dark hero-navbar">
      <div class="container">
        <a class="navbar-brand d-flex align-items-center py-1" href="index.php">
          <img src="images/logo.avif" alt="Nexgeno" class="site-logo site-logo--header" width="200" height="48">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
          <ul class="navbar-nav mx-auto gap-lg-2">
            <li class="nav-item"><a class="nav-link <?php echo $activePage === 'home' ? 'active' : ''; ?>" href="index.php">Home</a></li>
            <li class="nav-item"><a class="nav-link <?php echo $activePage === 'services' ? 'active' : ''; ?>" href="services.php">Services</a></li>
            <li class="nav-item"><a class="nav-link <?php echo $activePage === 'commission' ? 'active' : ''; ?>" href="commission.php">Commission</a></li>
            <li class="nav-item"><a class="nav-link <?php echo $activePage === 'partner-types' ? 'active' : ''; ?>" href="partner-types.php">Partner Types</a></li>
            <li class="nav-item"><a class="nav-link <?php echo $activePage === 'onboarding' ? 'active' : ''; ?>" href="onboarding.php">Onboarding</a></li>
            <li class="nav-item"><a class="nav-link <?php echo $activePage === 'about' ? 'active' : ''; ?>" href="about.php">About</a></li>
            <li class="nav-item"><a class="nav-link <?php echo $activePage === 'contact' ? 'active' : ''; ?>" href="contact.php">Contact</a></li>
          </ul>
          <a class="btn btn-sm hero-top-btn" href="apply.php">Become a Seller</a>
        </div>
      </div>
    </nav>
