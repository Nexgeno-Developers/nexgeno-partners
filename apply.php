<?php
require_once __DIR__ . '/mail_helper.php';

$partnershipTypes = [
    'affiliate' => 'Affiliate Partner',
    'business' => 'Business Partner',
    'acp' => 'Authorized Channel Partner (ACP)',
];

$serviceOptions = [
    'website' => 'Website Development',
    'ecommerce' => 'Ecommerce Solutions',
    'seo' => 'SEO Services',
    'digital_marketing' => 'Digital Marketing',
    'custom_software' => 'Custom Software',
    'hosting_cloud' => 'Hosting & Cloud',
    'mobile_apps' => 'Mobile Apps',
    'amc' => 'AMC & Maintenance',
];

$applyDefaults = [
    'full_name' => '',
    'email' => '',
    'phone' => '',
    'city' => '',
    'company' => '',
    'experience' => '',
    'partnership_type' => '',
    'services' => [],
    'additional_message' => '',
    'agree_terms' => '',
    'website' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedServices = [];
    foreach ((array) ($_POST['services'] ?? []) as $serviceKey) {
        $serviceKey = (string) $serviceKey;
        if (isset($serviceOptions[$serviceKey])) {
            $selectedServices[] = $serviceKey;
        }
    }

    $applyValues = [
        'full_name' => trim((string) ($_POST['full_name'] ?? '')),
        'email' => trim((string) ($_POST['email'] ?? '')),
        'phone' => trim((string) ($_POST['phone'] ?? '')),
        'city' => trim((string) ($_POST['city'] ?? '')),
        'company' => trim((string) ($_POST['company'] ?? '')),
        'experience' => trim((string) ($_POST['experience'] ?? '')),
        'partnership_type' => trim((string) ($_POST['partnership_type'] ?? '')),
        'services' => $selectedServices,
        'additional_message' => trim((string) ($_POST['additional_message'] ?? '')),
        'agree_terms' => isset($_POST['agree_terms']) ? '1' : '',
        'website' => trim((string) ($_POST['website'] ?? '')),
    ];

    $fieldErrors = [];

    if ($applyValues['website'] !== '') {
        nx_form_flash_redirect('apply_form_flash', 'apply.php', [
            'status' => 'success',
            'message' => 'Thanks, your application has been received.',
            'values' => $applyDefaults,
            'errors' => [],
            'field_errors' => [],
        ]);
    }

    if ($applyValues['full_name'] === '') {
        $fieldErrors['full_name'] = 'Please enter your full name.';
    }

    if ($applyValues['email'] === '') {
        $fieldErrors['email'] = 'Please enter your email address.';
    } elseif (!filter_var($applyValues['email'], FILTER_VALIDATE_EMAIL)) {
        $fieldErrors['email'] = 'Please enter a valid email address.';
    }

    if ($applyValues['phone'] === '') {
        $fieldErrors['phone'] = 'Please enter your phone number.';
    }

    if ($applyValues['city'] === '') {
        $fieldErrors['city'] = 'Please enter your city.';
    }

    if (!isset($partnershipTypes[$applyValues['partnership_type']])) {
        $fieldErrors['partnership_type'] = 'Please choose a partnership type.';
    }

    if ($applyValues['agree_terms'] !== '1') {
        $fieldErrors['agree_terms'] = 'You must agree to the Terms & Conditions and Privacy Policy.';
    }

    if ($fieldErrors === []) {
        $selectedServiceLabels = [];
        foreach ($applyValues['services'] as $serviceKey) {
            $selectedServiceLabels[] = $serviceOptions[$serviceKey];
        }

        $bodies = nx_build_email_bodies(
            'New Partnership Application',
            'A new partner application was submitted from the Nexgeno Partners website.',
            [
                'Full Name' => $applyValues['full_name'],
                'Email Address' => $applyValues['email'],
                'Phone Number' => $applyValues['phone'],
                'City' => $applyValues['city'],
                'Company Name' => $applyValues['company'] !== '' ? $applyValues['company'] : 'Not provided',
                'Years of Experience' => $applyValues['experience'] !== '' ? $applyValues['experience'] : 'Not provided',
                'Partnership Type' => $partnershipTypes[$applyValues['partnership_type']],
                'Services Interested In' => $selectedServiceLabels !== [] ? implode(', ', $selectedServiceLabels) : 'Not selected',
                'Additional Message' => $applyValues['additional_message'] !== '' ? $applyValues['additional_message'] : 'Not provided',
                'Agreed To Terms' => 'Yes',
                'Submitted At' => date('d M Y h:i A T'),
            ]
        );

        $mailResult = nx_send_smtp_mail([
            'subject' => 'New partnership application: ' . $applyValues['full_name'],
            'text_body' => $bodies['text'],
            'html_body' => $bodies['html'],
            'reply_to' => [
                'email' => $applyValues['email'],
                'name' => $applyValues['full_name'],
            ],
        ]);

        if ($mailResult['success']) {
            nx_form_flash_redirect('apply_form_flash', 'apply.php', [
                'status' => 'success',
                'message' => 'Your partnership application was sent successfully. Our team will contact you soon.',
                'values' => $applyDefaults,
                'errors' => [],
                'field_errors' => [],
            ]);
        }

        nx_form_flash_redirect('apply_form_flash', 'apply.php', [
            'status' => 'error',
            'message' => 'We could not send your application right now.',
            'values' => $applyValues,
            'errors' => [$mailResult['error']],
            'field_errors' => [],
        ]);
    }

    nx_form_flash_redirect('apply_form_flash', 'apply.php', [
        'status' => 'error',
        'message' => 'Please correct the highlighted fields and try again.',
        'values' => $applyValues,
        'errors' => array_values($fieldErrors),
        'field_errors' => $fieldErrors,
    ]);
}

$applyForm = nx_form_flash_boot('apply_form_flash', $applyDefaults);
$applyValues = $applyForm['values'];
$applyFieldErrors = $applyForm['field_errors'];
$applyHasError = static function ($field) use ($applyFieldErrors) {
    return isset($applyFieldErrors[$field]);
};
$applyErrorText = static function ($field) use ($applyFieldErrors) {
    return $applyFieldErrors[$field] ?? '';
};

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
          and get back to you within 24-48 hours.
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
            <?php if ($applyForm['message'] !== ''): ?>
              <div class="alert alert-<?php echo $applyForm['status'] === 'success' ? 'success' : 'danger'; ?> mb-4" role="alert">
                <?php echo nx_h($applyForm['message']); ?>
                <?php if ($applyForm['errors'] !== []): ?>
                  <ul class="mb-0 mt-2 ps-3">
                    <?php foreach ($applyForm['errors'] as $error): ?>
                      <li><?php echo nx_h($error); ?></li>
                    <?php endforeach; ?>
                  </ul>
                <?php endif; ?>
              </div>
            <?php endif; ?>

            <form class="apply-form" action="apply.php" method="post" novalidate data-loading-form>
              <div class="d-none" aria-hidden="true">
                <label for="apply-website">Website</label>
                <input type="text" id="apply-website" name="website" tabindex="-1" autocomplete="off">
              </div>

              <div class="apply-form-block">
                <h3 class="apply-section-heading"><i class="bi bi-person" aria-hidden="true"></i> Personal Information</h3>
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="apply-form-label" for="apply-name">Full Name <span class="apply-form-req">*</span></label>
                    <div class="apply-input-wrap">
                      <i class="bi bi-person apply-input-icon" aria-hidden="true"></i>
                      <input type="text" class="apply-form-control apply-form-control--icon<?php echo $applyHasError('full_name') ? ' is-invalid' : ''; ?>" id="apply-name" name="full_name" placeholder="Enter your full name" required autocomplete="name" value="<?php echo nx_h($applyValues['full_name']); ?>">
                    </div>
                    <?php if ($applyHasError('full_name')): ?>
                      <div class="invalid-feedback d-block"><?php echo nx_h($applyErrorText('full_name')); ?></div>
                    <?php endif; ?>
                  </div>
                  <div class="col-md-6">
                    <label class="apply-form-label" for="apply-email">Email Address <span class="apply-form-req">*</span></label>
                    <div class="apply-input-wrap">
                      <i class="bi bi-envelope apply-input-icon" aria-hidden="true"></i>
                      <input type="email" class="apply-form-control apply-form-control--icon<?php echo $applyHasError('email') ? ' is-invalid' : ''; ?>" id="apply-email" name="email" placeholder="your@email.com" required autocomplete="email" value="<?php echo nx_h($applyValues['email']); ?>">
                    </div>
                    <?php if ($applyHasError('email')): ?>
                      <div class="invalid-feedback d-block"><?php echo nx_h($applyErrorText('email')); ?></div>
                    <?php endif; ?>
                  </div>
                  <div class="col-md-6">
                    <label class="apply-form-label" for="apply-phone">Phone Number <span class="apply-form-req">*</span></label>
                    <div class="apply-input-wrap">
                      <i class="bi bi-telephone apply-input-icon" aria-hidden="true"></i>
                      <input type="tel" class="apply-form-control apply-form-control--icon<?php echo $applyHasError('phone') ? ' is-invalid' : ''; ?>" id="apply-phone" name="phone" placeholder="+91 98765 43210" required autocomplete="tel" value="<?php echo nx_h($applyValues['phone']); ?>">
                    </div>
                    <?php if ($applyHasError('phone')): ?>
                      <div class="invalid-feedback d-block"><?php echo nx_h($applyErrorText('phone')); ?></div>
                    <?php endif; ?>
                  </div>
                  <div class="col-md-6">
                    <label class="apply-form-label" for="apply-city">City <span class="apply-form-req">*</span></label>
                    <div class="apply-input-wrap">
                      <i class="bi bi-geo-alt apply-input-icon" aria-hidden="true"></i>
                      <input type="text" class="apply-form-control apply-form-control--icon<?php echo $applyHasError('city') ? ' is-invalid' : ''; ?>" id="apply-city" name="city" placeholder="Your city" required autocomplete="address-level2" value="<?php echo nx_h($applyValues['city']); ?>">
                    </div>
                    <?php if ($applyHasError('city')): ?>
                      <div class="invalid-feedback d-block"><?php echo nx_h($applyErrorText('city')); ?></div>
                    <?php endif; ?>
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
                      <input type="text" class="apply-form-control apply-form-control--icon" id="apply-company" name="company" placeholder="Your company name" autocomplete="organization" value="<?php echo nx_h($applyValues['company']); ?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label class="apply-form-label" for="apply-experience">Years of Experience</label>
                    <div class="apply-input-wrap">
                      <i class="bi bi-briefcase apply-input-icon" aria-hidden="true"></i>
                      <input type="text" class="apply-form-control apply-form-control--icon" id="apply-experience" name="experience" placeholder="e.g., 5 years" value="<?php echo nx_h($applyValues['experience']); ?>">
                    </div>
                  </div>
                </div>
              </div>

              <div class="apply-form-block">
                <h3 class="apply-section-heading"><i class="bi bi-briefcase" aria-hidden="true"></i> Partnership Type <span class="apply-form-req">*</span></h3>
                <div class="apply-choice-stack" role="radiogroup" aria-label="Partnership type">
                  <label class="apply-radio-card">
                    <input type="radio" name="partnership_type" value="affiliate" class="apply-radio-input" required<?php echo $applyValues['partnership_type'] === 'affiliate' ? ' checked' : ''; ?>>
                    <span class="apply-radio-dot" aria-hidden="true"></span>
                    <span class="apply-radio-body">
                      <strong>Affiliate Partner</strong>
                      <span class="apply-radio-desc">Just refer leads - Nexgeno handles everything</span>
                    </span>
                  </label>
                  <label class="apply-radio-card">
                    <input type="radio" name="partnership_type" value="business" class="apply-radio-input"<?php echo $applyValues['partnership_type'] === 'business' ? ' checked' : ''; ?>>
                    <span class="apply-radio-dot" aria-hidden="true"></span>
                    <span class="apply-radio-body">
                      <strong>Business Partner</strong>
                      <span class="apply-radio-desc">Actively sell with monthly/quarterly targets</span>
                    </span>
                  </label>
                  <label class="apply-radio-card">
                    <input type="radio" name="partnership_type" value="acp" class="apply-radio-input"<?php echo $applyValues['partnership_type'] === 'acp' ? ' checked' : ''; ?>>
                    <span class="apply-radio-dot" aria-hidden="true"></span>
                    <span class="apply-radio-body">
                      <strong>Authorized Channel Partner (ACP)</strong>
                      <span class="apply-radio-desc">Territory focus, co-branding &amp; priority support</span>
                    </span>
                  </label>
                </div>
                <?php if ($applyHasError('partnership_type')): ?>
                  <div class="invalid-feedback d-block"><?php echo nx_h($applyErrorText('partnership_type')); ?></div>
                <?php endif; ?>
              </div>

              <div class="apply-form-block">
                <h3 class="apply-section-heading apply-section-heading--plain">Services You&apos;d Like to Sell</h3>
                <div class="row g-3">
                  <div class="col-6 col-lg-3">
                    <label class="apply-service-card">
                      <input type="checkbox" name="services[]" value="website" class="apply-service-input"<?php echo in_array('website', $applyValues['services'], true) ? ' checked' : ''; ?>>
                      <span class="apply-service-marker" aria-hidden="true"></span>
                      <span class="apply-service-label">Website Development</span>
                    </label>
                  </div>
                  <div class="col-6 col-lg-3">
                    <label class="apply-service-card">
                      <input type="checkbox" name="services[]" value="ecommerce" class="apply-service-input"<?php echo in_array('ecommerce', $applyValues['services'], true) ? ' checked' : ''; ?>>
                      <span class="apply-service-marker" aria-hidden="true"></span>
                      <span class="apply-service-label">Ecommerce Solutions</span>
                    </label>
                  </div>
                  <div class="col-6 col-lg-3">
                    <label class="apply-service-card">
                      <input type="checkbox" name="services[]" value="seo" class="apply-service-input"<?php echo in_array('seo', $applyValues['services'], true) ? ' checked' : ''; ?>>
                      <span class="apply-service-marker" aria-hidden="true"></span>
                      <span class="apply-service-label">SEO Services</span>
                    </label>
                  </div>
                  <div class="col-6 col-lg-3">
                    <label class="apply-service-card">
                      <input type="checkbox" name="services[]" value="digital_marketing" class="apply-service-input"<?php echo in_array('digital_marketing', $applyValues['services'], true) ? ' checked' : ''; ?>>
                      <span class="apply-service-marker" aria-hidden="true"></span>
                      <span class="apply-service-label">Digital Marketing</span>
                    </label>
                  </div>
                  <div class="col-6 col-lg-3">
                    <label class="apply-service-card">
                      <input type="checkbox" name="services[]" value="custom_software" class="apply-service-input"<?php echo in_array('custom_software', $applyValues['services'], true) ? ' checked' : ''; ?>>
                      <span class="apply-service-marker" aria-hidden="true"></span>
                      <span class="apply-service-label">Custom Software</span>
                    </label>
                  </div>
                  <div class="col-6 col-lg-3">
                    <label class="apply-service-card">
                      <input type="checkbox" name="services[]" value="hosting_cloud" class="apply-service-input"<?php echo in_array('hosting_cloud', $applyValues['services'], true) ? ' checked' : ''; ?>>
                      <span class="apply-service-marker" aria-hidden="true"></span>
                      <span class="apply-service-label">Hosting &amp; Cloud</span>
                    </label>
                  </div>
                  <div class="col-6 col-lg-3">
                    <label class="apply-service-card">
                      <input type="checkbox" name="services[]" value="mobile_apps" class="apply-service-input"<?php echo in_array('mobile_apps', $applyValues['services'], true) ? ' checked' : ''; ?>>
                      <span class="apply-service-marker" aria-hidden="true"></span>
                      <span class="apply-service-label">Mobile Apps</span>
                    </label>
                  </div>
                  <div class="col-6 col-lg-3">
                    <label class="apply-service-card">
                      <input type="checkbox" name="services[]" value="amc" class="apply-service-input"<?php echo in_array('amc', $applyValues['services'], true) ? ' checked' : ''; ?>>
                      <span class="apply-service-marker" aria-hidden="true"></span>
                      <span class="apply-service-label">AMC &amp; Maintenance</span>
                    </label>
                  </div>
                </div>
              </div>

              <div class="apply-form-block">
                <label class="apply-form-label" for="apply-message">Additional Message (Optional)</label>
                <textarea class="apply-form-control apply-form-textarea" id="apply-message" name="additional_message" rows="5" placeholder="Tell us about your background, network, and why you want to partner with Nexgeno..."><?php echo nx_h($applyValues['additional_message']); ?></textarea>
              </div>

              <div class="apply-form-block apply-form-block--tight">
                <label class="apply-agree-label">
                  <input type="checkbox" name="agree_terms" value="1" class="apply-agree-input" required<?php echo $applyValues['agree_terms'] === '1' ? ' checked' : ''; ?>>
                  <span class="apply-agree-box" aria-hidden="true"></span>
                  <span class="apply-agree-text">
                    I agree to the
                    <a href="terms.html" target="_blank" rel="noopener noreferrer">Terms &amp; Conditions</a>
                    and
                    <a href="privacy.html" target="_blank" rel="noopener noreferrer">Privacy Policy</a>
                  </span>
                </label>
                <?php if ($applyHasError('agree_terms')): ?>
                  <div class="invalid-feedback d-block"><?php echo nx_h($applyErrorText('agree_terms')); ?></div>
                <?php endif; ?>
              </div>

              <button type="submit" class="apply-form-submit w-100" data-loading-button>
                <span class="form-submit-label">Submit Application</span>
                <span class="form-submit-icon" aria-hidden="true">&rarr;</span>
                <span class="form-submit-spinner spinner-border spinner-border-sm d-none" aria-hidden="true"></span>
                <span class="form-submit-loading-label d-none">Submitting Application...</span>
              </button>

              <p class="apply-form-security"><i class="bi bi-shield-check" aria-hidden="true"></i> Your information is secure and will not be shared with third parties.</p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

<?php include 'footer.php'; ?>
