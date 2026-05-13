<?php
session_start();
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

$experience = getExperience();
?>
<?php require_once __DIR__ . '/includes/header.php'; ?>
<script>window.SITE_URL = '<?= SITE_URL ?>';</script>

<div class="page-header">
  <div class="container">
    <span class="page-header-tag">Professional Journey</span>
    <h1 data-aos="fade-up">Work <span style="color:var(--accent)">Experience</span></h1>
    <p data-aos="fade-up" data-aos-delay="100">A timeline of my professional adventures in the tech world.</p>
  </div>
</div>

<section>
  <div class="container">
    <?php if(empty($experience)): ?>
    <div class="text-center py-5">
      <i class="fas fa-briefcase" style="font-size:3rem;color:var(--text-muted)"></i>
      <p class="mt-3" style="color:var(--text-muted)">No experience entries yet.</p>
    </div>
    <?php else: ?>
    <div class="timeline-wrap">
      <?php foreach($experience as $i => $exp): ?>
      <div class="timeline-item" data-aos="<?= $i%2==0 ? 'fade-right' : 'fade-left' ?>" data-aos-delay="<?= $i*100 ?>">
        <div class="timeline-content">
          <span class="timeline-period"><i class="fas fa-calendar-alt"></i><?= sanitize($exp['start_date']) ?> – <?= sanitize($exp['end_date']) ?></span>
          <?php if($exp['is_current']): ?>
          <span class="timeline-badge current-badge">Current</span>
          <?php endif; ?>
          <h3 class="timeline-title"><?= sanitize($exp['role']) ?></h3>
          <p class="timeline-sub"><i class="fas fa-building me-1"></i><?= sanitize($exp['company']) ?>
            <?php if(!empty($exp['location'])): ?> &nbsp;<i class="fas fa-map-marker-alt me-1"></i><?= sanitize($exp['location']) ?><?php endif; ?></p>
          <?php if(!empty($exp['responsibilities'])): ?>
          <p class="timeline-desc"><?= nl2br(sanitize($exp['responsibilities'])) ?></p>
          <?php endif; ?>
        </div>
        <div class="timeline-dot" style="background:<?= $exp['is_current'] ? 'var(--accent-2)' : 'var(--accent)' ?>;box-shadow:0 0 12px <?= $exp['is_current'] ? 'var(--accent-2)' : 'var(--accent)' ?>"></div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
