  <footer class="site-footer">
    <div class="container">
      <div class="row g-4 g-lg-5">
        <div class="col-lg-3">
          <a class="footer-brand d-inline-flex align-items-center text-decoration-none py-1" href="index.php">
            <img src="images/logo.avif" alt="Nexgeno" class="site-logo site-logo--footer" width="180" height="44">
          </a>
          <p class="footer-about mt-3 mb-0">
            Nexgeno Technology Pvt. Ltd. is a full-service IT, Web &amp; Digital Marketing company helping businesses grow online.
          </p>
        </div>

        <div class="col-sm-6 col-lg-3">
          <h6 class="footer-title">Partner Program</h6>
          <ul class="footer-links">
            <li><a href="services.php">Services</a></li>
            <li><a href="commission.php">Commission</a></li>
            <li><a href="partner-types.php">Partner Types</a></li>
            <li><a href="onboarding.php">Onboarding</a></li>
            <li><a href="apply.php">Apply Now</a></li>
          </ul>
        </div>

        <div class="col-sm-6 col-lg-3">
          <h6 class="footer-title">Company</h6>
          <ul class="footer-links">
            <li><a href="about.php">About Us</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="terms.html">Terms &amp; Conditions</a></li>
            <li><a href="privacy.html">Privacy Policy</a></li>
          </ul>
        </div>

        <div class="col-lg-3">
          <h6 class="footer-title">Contact</h6>
          <ul class="footer-contact">
            <li><i class="bi bi-envelope"></i> info@nexgeno.in</li>
            <li><i class="bi bi-telephone"></i> Contact via WhatsApp</li>
            <li><i class="bi bi-geo-alt"></i> Mumbai, India<br>Serving Partners Worldwide</li>
          </ul>
        </div>
      </div>

      <hr class="footer-divider">
      <p class="footer-copy mb-0">© 2026 Nexgeno Technology Pvt. Ltd. All rights reserved.</p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    (function () {
      function resetLoadingForms() {
        document.querySelectorAll('form[data-loading-form]').forEach(function (form) {
          form.dataset.submitting = 'false';

          form.querySelectorAll('button[type="submit"][data-loading-button]').forEach(function (button) {
            button.disabled = false;
            button.classList.remove('is-loading');
            button.removeAttribute('aria-busy');

            var defaultLabel = button.querySelector('.form-submit-label');
            var loadingLabel = button.querySelector('.form-submit-loading-label');
            var icon = button.querySelector('.form-submit-icon');
            var spinner = button.querySelector('.form-submit-spinner');

            if (defaultLabel) {
              defaultLabel.classList.remove('d-none');
            }

            if (loadingLabel) {
              loadingLabel.classList.add('d-none');
            }

            if (icon) {
              icon.classList.remove('d-none');
            }

            if (spinner) {
              spinner.classList.add('d-none');
            }
          });
        });
      }

      function bindLoadingForms() {
        document.querySelectorAll('form[data-loading-form]').forEach(function (form) {
          form.addEventListener('submit', function (event) {
            if (form.dataset.submitting === 'true') {
              event.preventDefault();
              return;
            }

            form.dataset.submitting = 'true';

            var activeButton = event.submitter || form.querySelector('button[type="submit"][data-loading-button]');
            if (!activeButton) {
              return;
            }

            form.querySelectorAll('button[type="submit"][data-loading-button]').forEach(function (button) {
              button.disabled = true;
            });

            activeButton.classList.add('is-loading');
            activeButton.setAttribute('aria-busy', 'true');

            var defaultLabel = activeButton.querySelector('.form-submit-label');
            var loadingLabel = activeButton.querySelector('.form-submit-loading-label');
            var icon = activeButton.querySelector('.form-submit-icon');
            var spinner = activeButton.querySelector('.form-submit-spinner');

            if (defaultLabel) {
              defaultLabel.classList.add('d-none');
            }

            if (loadingLabel) {
              loadingLabel.classList.remove('d-none');
            }

            if (icon) {
              icon.classList.add('d-none');
            }

            if (spinner) {
              spinner.classList.remove('d-none');
            }
          });
        });
      }

      document.addEventListener('DOMContentLoaded', function () {
        resetLoadingForms();
        bindLoadingForms();
      });

      window.addEventListener('pageshow', function () {
        resetLoadingForms();
      });
    }());
  </script>
</body>
</html>
