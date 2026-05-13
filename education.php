<?php
session_start();
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

$education = getEducation();
?>
<?php require_once __DIR__ . '/includes/header.php'; ?>
<script>window.SITE_URL = '<?= SITE_URL ?>';</script>

<div class="page-header">
  <div class="container">
    <span class="page-header-tag">Academic Background</span>
    <h1 data-aos="fade-up">My <span style="color:var(--accent)">Education</span></h1>
    <p data-aos="fade-up" data-aos-delay="100">The academic foundation that shaped my technical thinking.</p>
  </div>
</div>

<section>
  <div class="container">
    <?php if(empty($education)): ?>
    <div class="text-center py-5">
      <i class="fas fa-graduation-cap" style="font-size:3rem;color:var(--text-muted)"></i>
      <p class="mt-3" style="color:var(--text-muted)">No education entries yet.</p>
    </div>
    <?php else: ?>
    <div class="timeline-wrap">
      <?php foreach($education as $i => $edu): ?>
      <div class="timeline-item" data-aos="<?= $i%2==0 ? 'fade-right' : 'fade-left' ?>" data-aos-delay="<?= $i*100 ?>">
        <div class="timeline-content">
          <span class="timeline-period"><i class="fas fa-calendar-alt"></i><?= sanitize($edu['start_year']) ?> – <?= sanitize($edu['end_year']) ?></span>
          <?php if(!empty($edu['grade'])): ?>
          <span class="timeline-badge"><?= sanitize($edu['grade']) ?></span>
          <?php endif; ?>
          <h3 class="timeline-title"><?= sanitize($edu['course_name']) ?></h3>
          <p class="timeline-sub"><i class="fas fa-university me-1"></i><?= sanitize($edu['institution']) ?></p>
          <?php if(!empty($edu['description'])): ?>
          <p class="timeline-desc"><?= sanitize($edu['description']) ?></p>
          <?php endif; ?>
        </div>
        <div class="timeline-dot"></div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
