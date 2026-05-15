<?php
/**
 * Portfolio Pro - Site Footer
 */
$admin = getAdmin();
?>

<!-- Footer -->
<footer class="site-footer">
  <div class="container">
    <div class="row gy-4 align-items-center">
      <div class="col-md-4">
        <a class="navbar-brand" href="<?= SITE_URL ?>">
          <span class="brand-bracket">&lt;</span><?= sanitize($admin['name'] ?? 'Portfolio') ?><span class="brand-bracket">/&gt;</span>
        </a>
        <p class="footer-tagline mt-2"><?= sanitize($admin['tagline'] ?? '') ?></p>
      </div>
      <div class="col-md-4 text-center">
        <div class="footer-links">
          <a href="<?= SITE_URL ?>">Home</a>
          <a href="<?= SITE_URL ?>/about.php">About</a>
          <a href="<?= SITE_URL ?>/projects.php">Projects</a>
          <a href="<?= SITE_URL ?>/contact.php">Contact</a>
        </div>
      </div>
      <div class="col-md-4 text-md-end">
        <div class="social-links">
          <?php if(!empty($admin['github_url'])): ?>
          <a href="<?= sanitize($admin['github_url']) ?>" target="_blank" rel="noopener"><i class="fab fa-github"></i></a>
          <?php endif; ?>
          <?php if(!empty($admin['linkedin_url'])): ?>
          <a href="<?= sanitize($admin['linkedin_url']) ?>" target="_blank" rel="noopener" style="color: #0077B5;"><i class="fab fa-linkedin"></i></a>
          <?php endif; ?>
          <?php if(!empty($admin['twitter_url'])): ?>
          <a href="<?= sanitize($admin['twitter_url']) ?>" target="_blank" rel="noopener" style="color: #1DA1F2;"><i class="fab fa-twitter"></i></a>
          <?php endif; ?>
          <?php if(!empty($admin['instagram_url'])): ?>
          <a href="<?= sanitize($admin['instagram_url']) ?>" target="_blank" rel="noopener" style="color: #E1306C;"><i class="fab fa-instagram"></i></a>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <hr class="footer-hr" />
    <p class="footer-copy">&copy; <?= date('Y') ?> <?= sanitize($admin['name'] ?? 'Portfolio') ?>. Crafted with <i class="fas fa-heart text-danger"></i>
    <?php if(!empty($admin['instagram_url'])): ?>
          <a href="<?= sanitize($admin['instagram_url']) ?>" target="_blank" rel="noopener">campusxchange services.</a>
    <?php endif; ?>
    </p>
  </div>
</footer>

<!-- Scroll to Top -->
<button id="scrollTop" title="Back to top"><i class="fas fa-arrow-up"></i></button>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- AOS -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<!-- Typed.js -->
<script src="https://cdn.jsdelivr.net/npm/typed.js@2.1.0/dist/typed.umd.js"></script>
<!-- Custom JS -->
<script src="<?= SITE_URL ?>/assets/js/main.js"></script>
</body>
</html>
