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
        <div class="col-lg-10 col-xl-9">
          <div class="apply-form-card">
            <h2 id="apply-form-heading" class="visually-hidden">Partnership application form</h2>
            <form class="apply-form" action="#" method="post" novalidate>
              <div class="apply-form-block">
                <h3 class="apply-section-heading"><i class="bi bi-person" aria-hidden="true"></i> Personal Information</h3>
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="apply-form-label" for="apply-name">Full Name <span class="apply-form-req">*</span></label>
                    <div class="apply-input-wrap">
                      <i class="bi bi-person apply-input-icon" aria-hidden="true"></i>
                      <input type="text" class="apply-form-control apply-form-control--icon" id="apply-name" name="full_name" placeholder="Enter your full name" required autocomplete="name">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label class="apply-form-label" for="apply-email">Email Address <span class="apply-form-req">*</span></label>
                    <div class="apply-input-wrap">
                      <i class="bi bi-envelope apply-input-icon" aria-hidden="true"></i>
                      <input type="email" class="apply-form-control apply-form-control--icon" id="apply-email" name="email" placeholder="your@email.com" required autocomplete="email">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label class="apply-form-label" for="apply-phone">Phone Number <span class="apply-form-req">*</span></label>
                    <div class="apply-input-wrap">
                      <i class="bi bi-telephone apply-input-icon" aria-hidden="true"></i>
                      <input type="tel" class="apply-form-control apply-form-control--icon" id="apply-phone" name="phone" placeholder="+91 98765 43210" required autocomplete="tel">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label class="apply-form-label" for="apply-city">City <span class="apply-form-req">*</span></label>
                    <div class="apply-input-wrap">
                      <i class="bi bi-geo-alt apply-input-icon" aria-hidden="true"></i>
                      <input type="text" class="apply-form-control apply-form-control--icon" id="apply-city" name="city" placeholder="Your city" required autocomplete="address-level2">
                    </div>
                  </div>
                </div>
              </div>

              <div class="apply-form-block">
                <h3 class="apply-section-heading"><i class="bi bi-building" aria-hidden="true"></i> Business Information</h3>
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="apply-form-label" for="apply-company">Company Name (if applicable)</label>
                    <div class="apply-input-wrap">
                      <i class="bi bi-building apply-input-icon" aria-hidden="true"></i>
                      <input type="text" class="apply-form-control apply-form-control--icon" id="apply-company" name="company" placeholder="Your company name" autocomplete="organization">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label class="apply-form-label" for="apply-experience">Years of Experience</label>
                    <div class="apply-input-wrap">
                      <i class="bi bi-briefcase apply-input-icon" aria-hidden="true"></i>
                      <input type="text" class="apply-form-control apply-form-control--icon" id="apply-experience" name="experience" placeholder="e.g., 5 years">
                    </div>
                  </div>
                </div>
              </div>

              <div class="apply-form-block">
                <h3 class="apply-section-heading"><i class="bi bi-briefcase" aria-hidden="true"></i> Partnership Type <span class="apply-form-req">*</span></h3>
                <div class="apply-choice-stack" role="radiogroup" aria-label="Partnership type">
                  <label class="apply-radio-card">
                    <input type="radio" name="partnership_type" value="affiliate" class="apply-radio-input" required>
                    <span class="apply-radio-dot" aria-hidden="true"></span>
                    <span class="apply-radio-body">
                      <strong>Affiliate Partner</strong>
                      <span class="apply-radio-desc">Just refer leads — Nexgeno handles everything</span>
                    </span>
                  </label>
                  <label class="apply-radio-card">
                    <input type="radio" name="partnership_type" value="business" class="apply-radio-input">
                    <span class="apply-radio-dot" aria-hidden="true"></span>
                    <span class="apply-radio-body">
                      <strong>Business Partner</strong>
                      <span class="apply-radio-desc">Actively sell with monthly/quarterly targets</span>
                    </span>
                  </label>
                  <label class="apply-radio-card">
                    <input type="radio" name="partnership_type" value="acp" class="apply-radio-input">
                    <span class="apply-radio-dot" aria-hidden="true"></span>
                    <span class="apply-radio-body">
                      <strong>Authorized Channel Partner (ACP)</strong>
                      <span class="apply-radio-desc">Territory focus, co-branding &amp; priority support</span>
                    </span>
                  </label>
                </div>
              </div>

              <div class="apply-form-block">
                <h3 class="apply-section-heading apply-section-heading--plain">Services You&apos;d Like to Sell</h3>
                <div class="row g-3">
                  <div class="col-6 col-lg-3">
                    <label class="apply-service-card">
                      <input type="checkbox" name="services[]" value="website" class="apply-service-input">
                      <span class="apply-service-marker" aria-hidden="true"></span>
                      <span class="apply-service-label">Website Development</span>
                    </label>
                  </div>
                  <div class="col-6 col-lg-3">
                    <label class="apply-service-card">
                      <input type="checkbox" name="services[]" value="ecommerce" class="apply-service-input">
                      <span class="apply-service-marker" aria-hidden="true"></span>
                      <span class="apply-service-label">Ecommerce Solutions</span>
                    </label>
                  </div>
                  <div class="col-6 col-lg-3">
                    <label class="apply-service-card">
                      <input type="checkbox" name="services[]" value="seo" class="apply-service-input">
                      <span class="apply-service-marker" aria-hidden="true"></span>
                      <span class="apply-service-label">SEO Services</span>
                    </label>
                  </div>
                  <div class="col-6 col-lg-3">
                    <label class="apply-service-card">
                      <input type="checkbox" name="services[]" value="digital_marketing" class="apply-service-input">
                      <span class="apply-service-marker" aria-hidden="true"></span>
                      <span class="apply-service-label">Digital Marketing</span>
                    </label>
                  </div>
                  <div class="col-6 col-lg-3">
                    <label class="apply-service-card">
                      <input type="checkbox" name="services[]" value="custom_software" class="apply-service-input">
                      <span class="apply-service-marker" aria-hidden="true"></span>
                      <span class="apply-service-label">Custom Software</span>
                    </label>
                  </div>
                  <div class="col-6 col-lg-3">
                    <label class="apply-service-card">
                      <input type="checkbox" name="services[]" value="hosting_cloud" class="apply-service-input">
                      <span class="apply-service-marker" aria-hidden="true"></span>
                      <span class="apply-service-label">Hosting &amp; Cloud</span>
                    </label>
                  </div>
                  <div class="col-6 col-lg-3">
                    <label class="apply-service-card">
                      <input type="checkbox" name="services[]" value="mobile_apps" class="apply-service-input">
                      <span class="apply-service-marker" aria-hidden="true"></span>
                      <span class="apply-service-label">Mobile Apps</span>
                    </label>
                  </div>
                  <div class="col-6 col-lg-3">
                    <label class="apply-service-card">
                      <input type="checkbox" name="services[]" value="amc" class="apply-service-input">
                      <span class="apply-service-marker" aria-hidden="true"></span>
                      <span class="apply-service-label">AMC &amp; Maintenance</span>
                    </label>
                  </div>
                </div>
              </div>

              <div class="apply-form-block">
                <label class="apply-form-label" for="apply-message">Additional Message (Optional)</label>
                <textarea class="apply-form-control apply-form-textarea" id="apply-message" name="additional_message" rows="5" placeholder="Tell us about your background, network, and why you want to partner with Nexgeno..."></textarea>
              </div>

              <div class="apply-form-block apply-form-block--tight">
                <label class="apply-agree-label">
                  <input type="checkbox" name="agree_terms" value="1" class="apply-agree-input" required>
                  <span class="apply-agree-box" aria-hidden="true"></span>
                  <span class="apply-agree-text">
                    I agree to the
                    <a href="terms.html" target="_blank" rel="noopener noreferrer">Terms &amp; Conditions</a>
                    and
                    <a href="privacy.html" target="_blank" rel="noopener noreferrer">Privacy Policy</a>
                  </span>
                </label>
              </div>

              <button type="submit" class="apply-form-submit w-100">Submit Application <span aria-hidden="true">→</span></button>

              <p class="apply-form-security"><i class="bi bi-shield-check" aria-hidden="true"></i> Your information is secure and will not be shared with third parties.</p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

<?php include 'footer.php'; ?>
