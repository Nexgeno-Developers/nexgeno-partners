<?php
$pageTitle = 'Contact Us | Nexgeno Partners';
$activePage = 'contact';
$compactHeroWrap = true;
$bodyPageClass = 'page-contact';
$heroWrapExtraClass = 'hero-wrap-contact';
include 'header.php';
?>

  <section class="contact-page-hero">
    <div class="container">
      <div class="contact-hero-inner text-center">
        <h1 id="contact-hero-heading">Contact <span>Us</span></h1>
        <p>
          Have questions about the partner program? Want to discuss a potential collaboration?
          We&apos;d love to hear from you.
        </p>
      </div>
    </div>
  </section>
  </div>

  <section class="contact-main-section" aria-label="Contact form and details">
    <div class="container">
      <div class="row g-4 g-xl-5 align-items-start">
        <div class="col-lg-5">
          <h2 class="contact-aside-title">Get in Touch</h2>

          <div class="contact-info-stack">
            <a href="mailto:info@nexgeno.in" class="contact-info-card contact-info-card--link">
              <span class="contact-info-icon" aria-hidden="true"><i class="bi bi-envelope"></i></span>
              <div>
                <span class="contact-info-label">Email</span>
                <span class="contact-info-value">info@nexgeno.in</span>
              </div>
            </a>
            <a href="tel:+919876543210" class="contact-info-card contact-info-card--link">
              <span class="contact-info-icon" aria-hidden="true"><i class="bi bi-telephone"></i></span>
              <div>
                <span class="contact-info-label">Phone</span>
                <span class="contact-info-value">+91 98765 43210</span>
              </div>
            </a>
            <a href="https://wa.me/919876543210" class="contact-info-card contact-info-card--link" target="_blank" rel="noopener noreferrer">
              <span class="contact-info-icon" aria-hidden="true"><i class="bi bi-whatsapp"></i></span>
              <div>
                <span class="contact-info-label">WhatsApp</span>
                <span class="contact-info-value">Chat with us</span>
              </div>
            </a>
            <div class="contact-info-card">
              <span class="contact-info-icon" aria-hidden="true"><i class="bi bi-geo-alt"></i></span>
              <div>
                <span class="contact-info-label">Address</span>
                <span class="contact-info-value">Mumbai, Maharashtra, India</span>
              </div>
            </div>
          </div>

          <div class="contact-hours-card">
            <div class="contact-hours-head">
              <span class="contact-hours-icon" aria-hidden="true"><i class="bi bi-clock"></i></span>
              <span class="contact-hours-title">Business Hours</span>
            </div>
            <ul class="contact-hours-list">
              <li><span>Monday - Friday</span><span>9:00 AM - 7:00 PM IST</span></li>
              <li><span>Saturday</span><span>10:00 AM - 4:00 PM IST</span></li>
              <li class="contact-hours-list--closed"><span>Sunday</span><span>Closed</span></li>
            </ul>
          </div>
        </div>

        <div class="col-lg-7">
          <div class="contact-form-card">
            <div class="contact-form-head">
              <span class="contact-form-head-icon" aria-hidden="true"><i class="bi bi-send"></i></span>
              <h3 class="contact-form-title">Send us a Message</h3>
            </div>
            <form class="contact-form" action="#" method="post" novalidate>
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="contact-form-label" for="contact-name">Your Name <span class="contact-form-req">*</span></label>
                  <input type="text" class="contact-form-control" id="contact-name" name="name" placeholder="John Doe" required autocomplete="name">
                </div>
                <div class="col-md-6">
                  <label class="contact-form-label" for="contact-email">Email Address <span class="contact-form-req">*</span></label>
                  <input type="email" class="contact-form-control" id="contact-email" name="email" placeholder="john@example.com" required autocomplete="email">
                </div>
                <div class="col-md-6">
                  <label class="contact-form-label" for="contact-phone">Phone Number</label>
                  <input type="tel" class="contact-form-control" id="contact-phone" name="phone" placeholder="+91 98765 43210" autocomplete="tel">
                </div>
                <div class="col-md-6">
                  <label class="contact-form-label" for="contact-subject">Subject <span class="contact-form-req">*</span></label>
                  <input type="text" class="contact-form-control" id="contact-subject" name="subject" placeholder="Partnership Inquiry" required>
                </div>
                <div class="col-12">
                  <label class="contact-form-label" for="contact-message">Your Message <span class="contact-form-req">*</span></label>
                  <textarea class="contact-form-control contact-form-textarea" id="contact-message" name="message" rows="5" placeholder="Tell us about your inquiry..." required></textarea>
                </div>
                <div class="col-12">
                  <button type="submit" class="contact-form-submit">Send Message <i class="bi bi-send-fill" aria-hidden="true"></i></button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="contact-office-section" aria-labelledby="contact-office-heading">
    <div class="container">
      <div class="contact-office-card text-center">
        <span class="contact-office-icon" aria-hidden="true"><i class="bi bi-building"></i></span>
        <h2 id="contact-office-heading" class="contact-office-title">Visit Our Office</h2>
        <p class="contact-office-line">Nexgeno Technology Pvt. Ltd.</p>
        <p class="contact-office-line">Mumbai, Maharashtra, India</p>
      </div>
    </div>
  </section>

<?php include 'footer.php'; ?>
