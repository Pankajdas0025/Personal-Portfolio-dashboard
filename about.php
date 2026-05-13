<?php
session_start();
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

$admin = getAdmin();
$skills = getSkills();
?>
<?php require_once __DIR__ . '/includes/header.php'; ?>
<script>window.SITE_URL = '<?= SITE_URL ?>';</script>

<!-- Page Header -->
<div class="page-header">
  <div class="container">
    <span class="page-header-tag">Get to know me</span>
    <h1 data-aos="fade-up">About <span style="color:var(--accent)">Me</span></h1>
    <p data-aos="fade-up" data-aos-delay="100">Passionate developer, lifelong learner, and coffee enthusiast.</p>
  </div>
</div>

<!-- About Content -->
<section class="about-hero">
  <div class="container">
    <div class="row gy-5 align-items-center">
      <div class="col-lg-4 text-center" data-aos="fade-right">
        <div class="profile-img-wrap">
          <?php if(!empty($admin['profile_image']) && file_exists(UPLOAD_PATH . $admin['profile_image'])): ?>
          <img src="<?= UPLOAD_URL . sanitize($admin['profile_image']) ?>" class="profile-img" alt="Profile" />
          <?php else: ?>
          <div class="profile-img d-flex align-items-center justify-content-center" style="background:var(--bg-secondary);">
            <i class="fas fa-user" style="font-size:4rem;color:var(--accent);opacity:.4;"></i>
          </div>
          <?php endif; ?>
        </div>
        <div class="mt-4">
          <h3 style="font-family:var(--font-display)"><?= sanitize($admin['name'] ?? '') ?></h3>
          <p style="color:var(--accent);font-family:var(--font-mono);font-size:.85rem"><?= sanitize($admin['title'] ?? '') ?></p>
          <?php if(!empty($admin['location'])): ?>
          <p style="color:var(--text-muted);font-size:.85rem"><i class="fas fa-map-marker-alt me-1"></i><?= sanitize($admin['location']) ?></p>
          <?php endif; ?>
          <div class="d-flex gap-2 justify-content-center mt-3">
            <?php if(!empty($admin['github_url'])): ?>
            <a href="<?= sanitize($admin['github_url']) ?>" target="_blank" class="btn-outline-custom" style="padding:8px 16px;font-size:.75rem;"><i class="fab fa-github me-1"></i>GitHub</a>
            <?php endif; ?>
            <?php if(!empty($admin['linkedin_url'])): ?>
            <a href="<?= sanitize($admin['linkedin_url']) ?>" target="_blank" class="btn-outline-custom" style="padding:8px 16px;font-size:.75rem;"><i class="fab fa-linkedin me-1"></i>LinkedIn</a>
            <?php endif; ?>
          </div>
          <?php if(!empty($admin['resume_file'])): ?>
          <div class="mt-3">
            <a href="<?= UPLOAD_URL . sanitize($admin['resume_file']) ?>" download class="btn-primary-custom" style="font-size:.8rem;">
              <i class="fas fa-download"></i> Download Resume
            </a>
          </div>
          <?php endif; ?>
        </div>
      </div>
      <div class="col-lg-8" data-aos="fade-left">
        <span class="section-tag">My Story</span>
        <h2 class="section-title" style="font-size:2rem">Who am I?</h2>
        <div class="section-divider"></div>
        <p style="color:var(--text-secondary);font-size:1.05rem;line-height:1.8"><?= nl2br(sanitize($admin['bio'] ?? '')) ?></p>

        <div class="row g-3 mt-4">
          <?php if(!empty($admin['email'])): ?>
          <div class="col-sm-6">
            <div style="padding:12px 16px;background:var(--bg-card);border:1px solid var(--border);border-radius:8px;">
              <span style="font-family:var(--font-mono);font-size:.72rem;color:var(--text-muted)">EMAIL</span>
              <p style="color:var(--text-primary);margin:0"><?= sanitize($admin['email']) ?></p>
            </div>
          </div>
          <?php endif; ?>
          <?php if(!empty($admin['location'])): ?>
          <div class="col-sm-6">
            <div style="padding:12px 16px;background:var(--bg-card);border:1px solid var(--border);border-radius:8px;">
              <span style="font-family:var(--font-mono);font-size:.72rem;color:var(--text-muted)">LOCATION</span>
              <p style="color:var(--text-primary);margin:0"><?= sanitize($admin['location']) ?></p>
            </div>
          </div>
          <?php endif; ?>
          <?php if(!empty($admin['phone'])): ?>
          <div class="col-sm-6">
            <div style="padding:12px 16px;background:var(--bg-card);border:1px solid var(--border);border-radius:8px;">
              <span style="font-family:var(--font-mono);font-size:.72rem;color:var(--text-muted)">PHONE</span>
              <p style="color:var(--text-primary);margin:0"><?= sanitize($admin['phone']) ?></p>
            </div>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Skills -->
<section class="skills-section">
  <div class="container">
    <div data-aos="fade-up">
      <span class="section-tag">Capabilities</span>
      <h2 class="section-title">Skills & Proficiency</h2>
      <div class="section-divider"></div>
    </div>
    <div class="row g-3">
      <?php foreach($skills as $i => $skill): ?>
      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?= min($i*60,300) ?>">
        <div class="skill-card">
          <div class="skill-header">
            <span class="skill-name"><i class="<?= sanitize($skill['icon'] ?? 'fas fa-code') ?>"></i><?= sanitize($skill['name']) ?></span>
            <span class="skill-pct"><?= (int)$skill['percentage'] ?>%</span>
          </div>
          <div class="skill-bar"><div class="skill-fill" data-pct="<?= (int)$skill['percentage'] ?>"></div></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Tools & Tech -->
<section>
  <div class="container">
    <div data-aos="fade-up">
      <span class="section-tag">Toolkit</span>
      <h2 class="section-title">Tools & Technologies</h2>
      <div class="section-divider"></div>
    </div>
    <div data-aos="fade-up" data-aos-delay="100">
      <?php
      $tools = [
        ['icon'=>'fab fa-php','name'=>'PHP 8+'],['icon'=>'fas fa-database','name'=>'MySQL'],
        ['icon'=>'fab fa-js','name'=>'JavaScript ES6+'],['icon'=>'fab fa-html5','name'=>'HTML5'],
        ['icon'=>'fab fa-css3-alt','name'=>'CSS3'],['icon'=>'fab fa-bootstrap','name'=>'Bootstrap 5'],
        ['icon'=>'fab fa-react','name'=>'React.js'],['icon'=>'fab fa-git-alt','name'=>'Git'],
        ['icon'=>'fab fa-docker','name'=>'Docker'],['icon'=>'fab fa-linux','name'=>'Linux'],
        ['icon'=>'fas fa-server','name'=>'Apache/Nginx'],['icon'=>'fas fa-terminal','name'=>'Bash/Shell'],
        ['icon'=>'fab fa-npm','name'=>'npm'],['icon'=>'fas fa-plug','name'=>'REST APIs'],
        ['icon'=>'fas fa-code-branch','name'=>'GitHub Actions'],['icon'=>'fas fa-cloud','name'=>'AWS Basics'],
      ];
      foreach($tools as $t):
      ?>
      <span class="tool-badge"><i class="<?= $t['icon'] ?>"></i><?= $t['name'] ?></span>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
