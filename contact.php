<?php
session_start();
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

// Handle AJAX form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax'])) {
    header('Content-Type: application/json');
    $name    = sanitize($_POST['name'] ?? '');
    $email   = sanitize($_POST['email'] ?? '');
    $subject = sanitize($_POST['subject'] ?? '');
    $message = sanitize($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
        exit;
    }
    if (!isValidEmail($email)) {
        echo json_encode(['success' => false, 'message' => 'Please enter a valid email address.']);
        exit;
    }
    if (strlen($message) < 10) {
        echo json_encode(['success' => false, 'message' => 'Message too short. Please provide more details.']);
        exit;
    }

$ip = $_SERVER['REMOTE_ADDR'] ?? null;

$stmt = getDB()->prepare(
    "INSERT INTO messages (name, email, subject, message, ip_address)
     VALUES (?, ?, ?, ?, ?)"
);

$stmt->execute([
    $name,
    $email,
    $subject,
    $message,
    $ip
]);

echo json_encode([
    'success' => true,
    'message' => 'Message sent! I\'ll get back to you shortly.'
]);

exit;
}
$admin = getAdmin();
?>
<?php require_once __DIR__ . '/includes/header.php'; ?>
<script>window.SITE_URL = '<?= SITE_URL ?>';</script>

<div class="page-header">
  <div class="container">
    <span class="page-header-tag">Say Hello</span>
    <h1 data-aos="fade-up">Get In <span style="color:var(--accent)">Touch</span></h1>
    <p data-aos="fade-up" data-aos-delay="100">Have a project, question, or just want to say hi? I'm all ears.</p>
  </div>
</div>

<section class="contact-section">
  <div class="container">
    <div class="row gy-5">

      <!-- Contact Form -->
      <div class="col-lg-7" data-aos="fade-right">
        <div class="contact-card">
          <h3 style="font-family:var(--font-display);margin-bottom:8px">Send a Message</h3>
          <p style="color:var(--text-muted);font-size:.9rem;margin-bottom:28px;font-family:var(--font-mono)">I typically respond within 24 hours.</p>
          <div id="formMsg"></div>
          <form id="contactForm" novalidate>
            <div class="row g-3">
              <div class="col-sm-6">
                <label class="form-label-custom">Your Name *</label>
                <input type="text" name="name" class="form-control-custom" placeholder="John Doe" required />
              </div>
              <div class="col-sm-6">
                <label class="form-label-custom">Email Address *</label>
                <input type="email" name="email" class="form-control-custom" placeholder="john@example.com" required />
              </div>
              <div class="col-12">
                <label class="form-label-custom">Subject</label>
                <input type="text" name="subject" class="form-control-custom" placeholder="Project Inquiry" />
              </div>
              <div class="col-12">
                <label class="form-label-custom">Message *</label>
                <textarea name="message" class="form-control-custom" rows="6" placeholder="Tell me about your project..." required></textarea>
              </div>
              <div class="col-12">
                <button type="submit" class="btn-primary-custom">
                  <i class="fas fa-paper-plane"></i> Send Message
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Contact Info -->
      <div class="col-lg-5" data-aos="fade-left">
        <span class="section-tag">Contact Info</span>
        <h3 style="font-family:var(--font-display);margin-bottom:24px">Let's connect</h3>

        <?php if(!empty($admin['email'])): ?>
        <div class="contact-info-item">
          <div class="contact-info-icon"><i class="fas fa-envelope"></i></div>
          <div>
            <p class="contact-info-label">Email</p>
            <p class="contact-info-value"><?= sanitize($admin['email']) ?></p>
          </div>
        </div>
        <?php endif; ?>

        <?php if(!empty($admin['phone'])): ?>
        <div class="contact-info-item">
          <div class="contact-info-icon"><i class="fas fa-phone"></i></div>
          <div>
            <p class="contact-info-label">Phone</p>
            <p class="contact-info-value"><?= sanitize($admin['phone']) ?></p>
          </div>
        </div>
        <?php endif; ?>

        <?php if(!empty($admin['location'])): ?>
        <div class="contact-info-item">
          <div class="contact-info-icon"><i class="fas fa-map-marker-alt"></i></div>
          <div>
            <p class="contact-info-label">Location</p>
            <p class="contact-info-value"><?= sanitize($admin['location']) ?></p>
          </div>
        </div>
        <?php endif; ?>

        <div class="contact-info-item">
          <div class="contact-info-icon"><i class="fas fa-clock"></i></div>
          <div>
            <p class="contact-info-label">Response Time</p>
            <p class="contact-info-value">Within 24 hours</p>
          </div>
        </div>

        <!-- Social Links -->
        <div class="mt-4">
          <p style="font-family:var(--font-mono);font-size:.78rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:2px;margin-bottom:12px">Follow Me</p>
          <div class="d-flex gap-2 flex-wrap">
            <?php if(!empty($admin['github_url'])): ?>
            <a href="<?= sanitize($admin['github_url']) ?>" target="_blank" class="btn-outline-custom" style="padding:8px 16px;font-size:.8rem"><i class="fab fa-github me-1"></i>GitHub</a>
            <?php endif; ?>
            <?php if(!empty($admin['linkedin_url'])): ?>
            <a href="<?= sanitize($admin['linkedin_url']) ?>" target="_blank" class="btn-outline-custom" style="padding:8px 16px;font-size:.8rem"><i class="fab fa-linkedin me-1"></i>LinkedIn</a>
            <?php endif; ?>
            <?php if(!empty($admin['twitter_url'])): ?>
            <a href="<?= sanitize($admin['twitter_url']) ?>" target="_blank" class="btn-outline-custom" style="padding:8px 16px;font-size:.8rem"><i class="fab fa-twitter me-1"></i>Twitter</a>
            <?php endif; ?>
          </div>
        </div>

        <!-- Map -->
        <div class="map-wrap mt-4">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d224345.8395799!2d77.06890!3d28.52758!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cfd5b347eb62d%3A0x52c2b7494e204dce!2sNew%20Delhi%2C%20Delhi!5e0!3m2!1sen!2sin!4v1700000000000" allowfullscreen loading="lazy"></iframe>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
