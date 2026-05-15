<?php
/**
 * Portfolio Pro - Home Page
 */
session_start();
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

$admin = getAdmin();
$skills = getSkills();
$projects = getFeaturedProjects(3);

// Group skills by category
$skillsByCategory = [];
foreach ($skills as $s) {
    $skillsByCategory[$s['category']][] = $s;
}
?>
<?php require_once __DIR__ . '/includes/header.php'; ?>

<script>window.SITE_URL = '<?= SITE_URL ?>';</script>

<!-- HERO SECTION -->
<section class="hero-section" id="home">
  <div class="hero-bg"></div>
  <div class="hero-grid"></div>
  <div class="container position-relative">
    <div class="row align-items-center gy-5">
      <div class="col-lg-6" data-aos="fade-right">
        <span class="hero-tag"><i class="fas fa-terminal me-2"></i>Available for hire</span>
        <h1 class="hero-name"><?= sanitize($admin['username'] ?? 'Pankaj Kumar Das') ?></h1>
        <div class="hero-typed">
          <span id="heroTyped"></span>
        </div>
        <p class="hero-desc"><?= sanitize($admin['tagline'] ?? 'Crafting elegant code, one commit at a time.') ?></p>
        <div class="hero-btns">
          <a href="<?= SITE_URL ?>/projects.php" class="btn-primary-custom">
            <i class="fas fa-folder-open"></i> View Projects
          </a>
          <a href="<?= SITE_URL ?>/contact.php" class="btn-outline-custom">
            <i class="fas fa-envelope"></i> Get In Touch
          </a>
        </div>
        <div class="hero-stats">
          <div class="stat-item">
            <span class="stat-num" data-target="5" data-suffix="+">0+</span>
            <span class="stat-label">Years Exp</span>
          </div>
          <div class="stat-item">
            <span class="stat-num" data-target="30" data-suffix="+">0+</span>
            <span class="stat-label">Projects</span>
          </div>
          <div class="stat-item">
            <span class="stat-num" data-target="15" data-suffix="+">0+</span>
            <span class="stat-label">Clients</span>
          </div>
          <div class="stat-item">
            <span class="stat-num" data-target="99" data-suffix="%">0%</span>
            <span class="stat-label">Satisfaction</span>
          </div>
        </div>
      </div>
      <div class="col-lg-6 text-center" data-aos="fade-left">
        <div class="hero-image-wrap">
          <div class="hero-img-ring">
            <?php if(!empty($admin['profile_image']) && file_exists(UPLOAD_PATH . $admin['profile_image'])): ?>
            <img src="<?= UPLOAD_URL . sanitize($admin['profile_image']) ?>" alt="<?= sanitize($admin['username']) ?>" class="hero-img" />
            <?php else: ?>
            <div class="hero-img d-flex align-items-center justify-content-center" style="background:var(--bg-secondary);">
              <i class="fas fa-user" style="font-size:5rem;color:var(--accent);opacity:.4;"></i>
            </div>
            <?php endif; ?>
          </div>
          <div class="hero-badge hero-badge-1">
            <i class="fas fa-code"></i> <?= count($skills) ?>+ Technologies
          </div>
          <div class="hero-badge hero-badge-2">
            <i class="fas fa-star"></i> Open to Work
          </div>
          <div class="hero-badge hero-badge-3">
            <i class="fas fa-star"></i> FreeLancer
          </div>
          <div class="hero-badge hero-badge-4">
            <i class="fas fa-star"></i> Clients
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SKILLS SECTION -->
<section class="skills-section" id="skills">
  <div class="container">
    <div data-aos="fade-up">
      <span class="section-tag">Expertise</span>
      <h2 class="section-title">Skills & Technologies</h2>
      <p class="section-subtitle">The tools and technologies I use to bring ideas to life.</p>
      <div class="section-divider"></div>
    </div>

    <!-- Category Tabs -->
    <div class="d-flex gap-2 flex-wrap mb-4" data-aos="fade-up" data-aos-delay="100">
      <button class="category-tab active" data-cat="all">All</button>
      <?php foreach(array_keys($skillsByCategory) as $cat): ?>
      <button class="category-tab" data-cat="<?= sanitize($cat) ?>"><?= sanitize($cat) ?></button>
      <?php endforeach; ?>
    </div>

    <div class="row g-3">
      <?php foreach($skills as $i => $skill): ?>
      <div class="col-md-6 col-lg-4 skill-card-wrap" data-cat="<?= sanitize($skill['category']) ?>" data-aos="fade-up" data-aos-delay="<?= min($i * 60, 300) ?>">
        <div class="skill-card">
          <div class="skill-header">
            <span class="skill-name">
              <i class="<?= sanitize($skill['icon'] ?? 'fas fa-code') ?>"></i>
              <?= sanitize($skill['name']) ?>
            </span>
            <span class="skill-pct"><?= (int)$skill['percentage'] ?>%</span>
          </div>
          <div class="skill-bar">
            <div class="skill-fill" data-pct="<?= (int)$skill['percentage'] ?>"></div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- FEATURED PROJECTS -->
<?php if(!empty($projects)): ?>
<section id="featured-projects">
  <div class="container">
    <div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-5" data-aos="fade-up">
      <div>
        <span class="section-tag">Work</span>
        <h2 class="section-title">Featured Projects</h2>
        <div class="section-divider mb-0"></div>
      </div>
      <a href="<?= SITE_URL ?>/projects.php" class="btn-outline-custom" style="height:fit-content;">
        View All <i class="fas fa-arrow-right ms-1"></i>
      </a>
    </div>
    <div class="row g-4">
      <?php foreach($projects as $i => $p): ?>
      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
        <div class="project-card">
          <div class="project-img-wrap">
            <?php if(!empty($p['image']) && file_exists(UPLOAD_PATH . $p['image'])): ?>
            <img data-src="<?= UPLOAD_URL . sanitize($p['image']) ?>" src="" alt="<?= sanitize($p['title']) ?>" />
            <?php else: ?>
            <div class="project-placeholder"><i class="fas fa-laptop-code"></i></div>
            <?php endif; ?>
            <div class="project-overlay">
              <?php if(!empty($p['live_url'])): ?>
              <a href="<?= sanitize($p['live_url']) ?>" target="_blank" rel="noopener" title="Live Demo"><i class="fas fa-external-link-alt"></i></a>
              <?php endif; ?>
              <?php if(!empty($p['github_url'])): ?>
              <a href="<?= sanitize($p['github_url']) ?>" target="_blank" rel="noopener" title="GitHub"><i class="fab fa-github"></i></a>
              <?php endif; ?>
            </div>
          </div>
          <div class="project-body">
            <span class="project-category"><?= sanitize($p['category']) ?></span>
            <h3 class="project-title"><?= sanitize($p['title']) ?></h3>
            <p class="project-desc"><?= sanitize($p['description']) ?></p>
            <div class="tech-tags">
              <?php foreach(array_slice(explode(',', $p['tech_stack']), 0, 4) as $tech): ?>
              <span class="tech-tag"><?= sanitize(trim($tech)) ?></span>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- CTA SECTION -->
<section style="padding:80px 0;background:var(--bg-secondary);">
  <div class="container text-center" data-aos="fade-up">
    <span class="section-tag">Let's Talk</span>
    <h2 class="section-title">Have a project in mind?</h2>
    <p class="section-subtitle mx-auto mb-4">I'm always open to discussing new projects, creative ideas, or opportunities to be part of something great.</p>
    <a href="<?= SITE_URL ?>/contact.php" class="btn-primary-custom">
      <i class="fas fa-paper-plane"></i> Start a Conversation
    </a>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
