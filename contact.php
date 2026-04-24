<?php
require_once __DIR__ . '/mail_helper.php';

$contactDefaults = [
    'name' => '',
    'email' => '',
    'phone' => '',
    'subject' => '',
    'message' => '',
    'website' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contactValues = [
        'name' => trim((string) ($_POST['name'] ?? '')),
        'email' => trim((string) ($_POST['email'] ?? '')),
        'phone' => trim((string) ($_POST['phone'] ?? '')),
        'subject' => trim((string) ($_POST['subject'] ?? '')),
        'message' => trim((string) ($_POST['message'] ?? '')),
        'website' => trim((string) ($_POST['website'] ?? '')),
    ];

    $fieldErrors = [];

    if ($contactValues['website'] !== '') {
        nx_form_flash_redirect('contact_form_flash', 'contact.php', [
            'status' => 'success',
            'message' => 'Thanks, your message has been received.',
            'values' => $contactDefaults,
            'errors' => [],
            'field_errors' => [],
        ]);
    }

    if ($contactValues['name'] === '') {
        $fieldErrors['name'] = 'Please enter your name.';
    }

    if ($contactValues['email'] === '') {
        $fieldErrors['email'] = 'Please enter your email address.';
    } elseif (!filter_var($contactValues['email'], FILTER_VALIDATE_EMAIL)) {
        $fieldErrors['email'] = 'Please enter a valid email address.';
    }

    if ($contactValues['subject'] === '') {
        $fieldErrors['subject'] = 'Please enter a subject.';
    }

    if ($contactValues['message'] === '') {
        $fieldErrors['message'] = 'Please enter your message.';
    }

    if ($fieldErrors === []) {
        $bodies = nx_build_email_bodies(
            'New Contact Form Enquiry',
            'A new contact enquiry was submitted from the Nexgeno Partners website.',
            [
                'Name' => $contactValues['name'],
                'Email Address' => $contactValues['email'],
                'Phone Number' => $contactValues['phone'] !== '' ? $contactValues['phone'] : 'Not provided',
                'Subject' => $contactValues['subject'],
                'Message' => $contactValues['message'],
                'Submitted At' => date('d M Y h:i A T'),
            ]
        );

        $mailResult = nx_send_smtp_mail([
            'subject' => 'New contact enquiry: ' . $contactValues['subject'],
            'text_body' => $bodies['text'],
            'html_body' => $bodies['html'],
            'reply_to' => [
                'email' => $contactValues['email'],
                'name' => $contactValues['name'],
            ],
        ]);

        if ($mailResult['success']) {
            nx_form_flash_redirect('contact_form_flash', 'contact.php', [
                'status' => 'success',
                'message' => 'Your message was sent successfully. We will get back to you soon.',
                'values' => $contactDefaults,
                'errors' => [],
                'field_errors' => [],
            ]);
        }

        nx_form_flash_redirect('contact_form_flash', 'contact.php', [
            'status' => 'error',
            'message' => 'We could not send your message right now.',
            'values' => $contactValues,
            'errors' => [$mailResult['error']],
            'field_errors' => [],
        ]);
    }

    nx_form_flash_redirect('contact_form_flash', 'contact.php', [
        'status' => 'error',
        'message' => 'Please correct the highlighted fields and try again.',
        'values' => $contactValues,
        'errors' => array_values($fieldErrors),
        'field_errors' => $fieldErrors,
    ]);
}

$contactForm = nx_form_flash_boot('contact_form_flash', $contactDefaults);
$contactValues = $contactForm['values'];
$contactFieldErrors = $contactForm['field_errors'];
$contactHasError = static function ($field) use ($contactFieldErrors) {
    return isset($contactFieldErrors[$field]);
};
$contactErrorText = static function ($field) use ($contactFieldErrors) {
    return $contactFieldErrors[$field] ?? '';
};

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
            <?php if ($contactForm['message'] !== ''): ?>
              <div class="alert alert-<?php echo $contactForm['status'] === 'success' ? 'success' : 'danger'; ?> mb-4" role="alert">
                <?php echo nx_h($contactForm['message']); ?>
                <?php if ($contactForm['errors'] !== []): ?>
                  <ul class="mb-0 mt-2 ps-3">
                    <?php foreach ($contactForm['errors'] as $error): ?>
                      <li><?php echo nx_h($error); ?></li>
                    <?php endforeach; ?>
                  </ul>
                <?php endif; ?>
              </div>
            <?php endif; ?>

            <form class="contact-form" action="contact.php" method="post" novalidate>
              <div class="d-none" aria-hidden="true">
                <label for="contact-website">Website</label>
                <input type="text" id="contact-website" name="website" tabindex="-1" autocomplete="off">
              </div>
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="contact-form-label" for="contact-name">Your Name <span class="contact-form-req">*</span></label>
                  <input type="text" class="contact-form-control<?php echo $contactHasError('name') ? ' is-invalid' : ''; ?>" id="contact-name" name="name" placeholder="John Doe" required autocomplete="name" value="<?php echo nx_h($contactValues['name']); ?>">
                  <?php if ($contactHasError('name')): ?>
                    <div class="invalid-feedback d-block"><?php echo nx_h($contactErrorText('name')); ?></div>
                  <?php endif; ?>
                </div>
                <div class="col-md-6">
                  <label class="contact-form-label" for="contact-email">Email Address <span class="contact-form-req">*</span></label>
                  <input type="email" class="contact-form-control<?php echo $contactHasError('email') ? ' is-invalid' : ''; ?>" id="contact-email" name="email" placeholder="john@example.com" required autocomplete="email" value="<?php echo nx_h($contactValues['email']); ?>">
                  <?php if ($contactHasError('email')): ?>
                    <div class="invalid-feedback d-block"><?php echo nx_h($contactErrorText('email')); ?></div>
                  <?php endif; ?>
                </div>
                <div class="col-md-6">
                  <label class="contact-form-label" for="contact-phone">Phone Number</label>
                  <input type="tel" class="contact-form-control" id="contact-phone" name="phone" placeholder="+91 98765 43210" autocomplete="tel" value="<?php echo nx_h($contactValues['phone']); ?>">
                </div>
                <div class="col-md-6">
                  <label class="contact-form-label" for="contact-subject">Subject <span class="contact-form-req">*</span></label>
                  <input type="text" class="contact-form-control<?php echo $contactHasError('subject') ? ' is-invalid' : ''; ?>" id="contact-subject" name="subject" placeholder="Partnership Inquiry" required value="<?php echo nx_h($contactValues['subject']); ?>">
                  <?php if ($contactHasError('subject')): ?>
                    <div class="invalid-feedback d-block"><?php echo nx_h($contactErrorText('subject')); ?></div>
                  <?php endif; ?>
                </div>
                <div class="col-12">
                  <label class="contact-form-label" for="contact-message">Your Message <span class="contact-form-req">*</span></label>
                  <textarea class="contact-form-control contact-form-textarea<?php echo $contactHasError('message') ? ' is-invalid' : ''; ?>" id="contact-message" name="message" rows="5" placeholder="Tell us about your inquiry..." required><?php echo nx_h($contactValues['message']); ?></textarea>
                  <?php if ($contactHasError('message')): ?>
                    <div class="invalid-feedback d-block"><?php echo nx_h($contactErrorText('message')); ?></div>
                  <?php endif; ?>
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
