<?php
session_start();
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

$projects = getAllProjects();
$categories = array_unique(array_column($projects, 'category'));
?>
<?php require_once __DIR__ . '/includes/header.php'; ?>
<script>window.SITE_URL = '<?= SITE_URL ?>';</script>

<div class="page-header">
  <div class="container">
    <span class="page-header-tag">My Work</span>
    <h1 data-aos="fade-up">All <span style="color:var(--accent)">Projects</span></h1>
    <p data-aos="fade-up" data-aos-delay="100">A showcase of things I've built and the problems I've solved.</p>
  </div>
</div>

<section>
  <div class="container">
    <!-- Filter Buttons -->
    <div class="d-flex gap-2 flex-wrap mb-5" data-aos="fade-up">
      <button class="filter-btn active" data-filter="all">All Projects</button>
      <?php foreach($categories as $cat): ?>
      <button class="filter-btn" data-filter="<?= sanitize($cat) ?>"><?= sanitize($cat) ?></button>
      <?php endforeach; ?>
    </div>

    <?php if(empty($projects)): ?>
    <div class="text-center py-5">
      <i class="fas fa-folder-open" style="font-size:3rem;color:var(--text-muted)"></i>
      <p class="mt-3" style="color:var(--text-muted)">No projects yet. Check back soon!</p>
    </div>
    <?php else: ?>
    <div class="row g-4">
      <?php foreach($projects as $i => $p): ?>
      <div class="col-md-6 col-lg-4 project-item" data-cat="<?= sanitize($p['category']) ?>" data-aos="fade-up" data-aos-delay="<?= min($i*80,400) ?>">
        <div class="project-card">
          <div class="project-img-wrap">
            <?php if(!empty($p['image']) && file_exists(UPLOAD_PATH . $p['image'])): ?>
            <img data-src="<?= UPLOAD_URL . sanitize($p['image']) ?>" src="" alt="<?= sanitize($p['title']) ?>" class="project-img h-250" />
            <?php else: ?>
            <div class="project-placeholder"><i class="fas fa-laptop-code"></i></div>
            <?php endif; ?>
            <div class="project-overlay">
              <?php if(!empty($p['live_url'])): ?>
              <a href="<?= sanitize($p['live_url']) ?>" target="_blank" rel="noopener" title="Live Demo"><i class="fas fa-external-link-alt"></i></a>
              <?php endif; ?>
              <?php if(!empty($p['github_url'])): ?>
              <a href="<?= sanitize($p['github_url']) ?>" target="_blank" rel="noopener" title="GitHub Repo"><i class="fab fa-github"></i></a>
              <?php endif; ?>
            </div>
            <?php if($p['is_featured']): ?>
            <div style="position:absolute;top:12px;left:12px;">
              <span style="font-family:var(--font-mono);font-size:.68rem;background:var(--accent);color:#0a0a0f;padding:3px 10px;border-radius:10px;font-weight:700;">Featured</span>
            </div>
            <?php endif; ?>
          </div>
          <div class="project-body">
            <span class="project-category"><?= sanitize($p['category']) ?></span>
            <h3 class="project-title"><?= sanitize($p['title']) ?></h3>
            <p class="project-desc"><?= sanitize($p['description']) ?></p>
            <div class="tech-tags">
              <?php foreach(array_slice(explode(',', $p['tech_stack']), 0, 5) as $tech): ?>
              <span class="tech-tag"><?= sanitize(trim($tech)) ?></span>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>


<!-- I Build Fast, Scalable & Modern Web Applications
Building Modern, Scalable & High-Performance Web Solutions -->
