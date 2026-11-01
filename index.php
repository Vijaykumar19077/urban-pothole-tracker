<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$stats = $pdo->query("SELECT COUNT(*) total, SUM(status='Resolved') resolved, SUM(status<>'Resolved') active FROM reports")->fetch();
$latest = $pdo->query("SELECT r.*, u.name citizen FROM reports r JOIN users u ON u.id=r.user_id ORDER BY r.created_at DESC LIMIT 5")->fetchAll();
$pageTitle = "Home";
require __DIR__ . '/includes/header.php';
?>
<section class="hero">
  <div class="hero-copy">
    <span class="eyebrow">SMARTER STREETS. SAFER COMMUNITIES.</span>
    <h1>Report road damage.<br><span>Make every journey safer.</span></h1>
    <p>Help your community flag potholes, damaged roads and broken streetlights. Track reports and see repair progress in one place.</p>
    <div class="hero-actions">
      <a class="btn btn-primary" href="<?= is_logged_in() ? 'citizen/report.php' : 'register.php' ?>">Report a problem <span>→</span></a>
      <a class="btn btn-light" href="dashboard.php">Explore public reports</a>
    </div>
    <div class="hero-note"><span class="pulse"></span> Community-powered road safety tracker</div>
  </div>
  <div class="hero-visual">
    <div class="road-card">
      <div class="road-top"><span class="live-dot"></span> CITY ROAD WATCH <span class="road-menu">•••</span></div>
      <div class="road-art"><div class="road-line"></div><div class="pin pin-one">!</div><div class="pin pin-two">!</div><div class="road-label">ROAD SAFETY ZONE</div></div>
      <div class="road-bottom"><div><small>REPORTED ISSUES</small><strong><?= (int)$stats['total'] ?></strong></div><div><small>RESOLVED</small><strong><?= (int)$stats['resolved'] ?></strong></div></div>
    </div>
    <div class="floating-tag"><span>✓</span> Your report makes a difference</div>
  </div>
</section>
<section class="stats-grid">
  <div class="stat-card"><span class="stat-icon">◎</span><div><strong><?= (int)$stats['total'] ?></strong><small>Total reports</small></div></div>
  <div class="stat-card"><span class="stat-icon orange">◷</span><div><strong><?= (int)$stats['active'] ?></strong><small>Active issues</small></div></div>
  <div class="stat-card"><span class="stat-icon green">✓</span><div><strong><?= (int)$stats['resolved'] ?></strong><small>Resolved issues</small></div></div>
</section>
<section class="section">
  <div class="section-heading"><div><span class="eyebrow">HOW IT WORKS</span><h2>From report to repair</h2></div><a class="text-link" href="dashboard.php">View all reports →</a></div>
  <div class="steps-grid">
    <article class="step-card"><span class="step-number">01</span><div class="step-icon">📍</div><h3>Spot an issue</h3><p>Notice a pothole, damaged road or broken streetlight? Share its location.</p></article>
    <article class="step-card"><span class="step-number">02</span><div class="step-icon">📷</div><h3>Submit a report</h3><p>Add a description, choose severity and upload a photo as evidence.</p></article>
    <article class="step-card"><span class="step-number">03</span><div class="step-icon">🛠️</div><h3>Track the repair</h3><p>Follow the status as the municipal team reviews and resolves the issue.</p></article>
  </div>
</section>
<section class="section recent-section">
  <div class="section-heading"><div><span class="eyebrow">COMMUNITY UPDATES</span><h2>Recently reported issues</h2></div><a class="text-link" href="dashboard.php">See public dashboard →</a></div>
  <?php if (!$latest): ?><div class="empty-state">No reports yet. Be the first to report a road issue.</div><?php else: ?>
  <div class="report-list"><?php foreach ($latest as $r): ?>
    <article class="report-row"><div class="report-symbol">⚑</div><div class="report-main"><strong><?= e($r['title']) ?></strong><span><?= e($r['location']) ?> · <?= e($r['issue_type']) ?></span></div><span class="severity severity-<?= strtolower($r['severity']) ?>"><?= e($r['severity']) ?></span><span class="status status-<?= status_class($r['status']) ?>"><?= e($r['status']) ?></span></article>
  <?php endforeach; ?></div><?php endif; ?>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
