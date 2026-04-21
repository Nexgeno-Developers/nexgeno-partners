<?php
$pageTitle = 'Apply for Partnership | Nexgeno Partners';
$activePage = '';
$compactHeroWrap = true;
$bodyPageClass = 'page-apply';
$heroWrapExtraClass = 'hero-wrap-apply';
include 'header.php';
?>

  <section class="apply-page-hero">
    <div class="container">
      <div class="apply-hero-inner text-center">
        <h1 id="apply-hero-heading">Apply for <span>Partnership</span></h1>
        <p>
          Fill out the form below to start your journey as a Nexgeno Channel Partner. Our team will review your application
          and get back to you within 24–48 hours.
        </p>
      </div>
    </div>
  </section>
  </div>

  <section class="apply-main-section" aria-labelledby="apply-form-heading">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
          <div class="apply-form-card">
            <h2 id="apply-form-heading" class="apply-form-card-title">Partner application</h2>
            <p class="apply-form-card-lead">Tell us about yourself and how you&apos;d like to partner with Nexgeno.</p>
            <form class="apply-form" action="#" method="post" novalidate>
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="apply-form-label" for="apply-name">Full name <span class="apply-form-req">*</span></label>
                  <input type="text" class="apply-form-control" id="apply-name" name="name" placeholder="Your name" required autocomplete="name">
                </div>
                <div class="col-md-6">
                  <label class="apply-form-label" for="apply-email">Email <span class="apply-form-req">*</span></label>
                  <input type="email" class="apply-form-control" id="apply-email" name="email" placeholder="you@company.com" required autocomplete="email">
                </div>
                <div class="col-md-6">
                  <label class="apply-form-label" for="apply-phone">Phone</label>
                  <input type="tel" class="apply-form-control" id="apply-phone" name="phone" placeholder="+91 98765 43210" autocomplete="tel">
                </div>
                <div class="col-md-6">
                  <label class="apply-form-label" for="apply-company">Company / organization</label>
                  <input type="text" class="apply-form-control" id="apply-company" name="company" placeholder="Company name" autocomplete="organization">
                </div>
                <div class="col-12">
                  <label class="apply-form-label" for="apply-type">Partnership type <span class="apply-form-req">*</span></label>
                  <select class="apply-form-control apply-form-select" id="apply-type" name="partnership_type" required>
                    <option value="" selected disabled>Select an option</option>
                    <option value="affiliate">Affiliate Partner</option>
                    <option value="business">Business Partner</option>
                    <option value="acp">Authorized Channel Partner (ACP)</option>
                    <option value="unsure">Not sure yet</option>
                  </select>
                </div>
                <div class="col-12">
                  <label class="apply-form-label" for="apply-message">Why do you want to partner with us? <span class="apply-form-req">*</span></label>
                  <textarea class="apply-form-control apply-form-textarea" id="apply-message" name="message" rows="5" placeholder="Briefly describe your network, experience, and goals..." required></textarea>
                </div>
                <div class="col-12">
                  <button type="submit" class="apply-form-submit">Submit application</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

<?php include 'footer.php'; ?>
