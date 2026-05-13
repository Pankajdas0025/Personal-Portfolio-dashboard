<?php
/**
 * Global Helper Functions
 * Requires config/database.php to be included first (for getDB, UPLOAD_PATH, etc.)
 */

// ── Security ──────────────────────────────────────────────────
function e(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

function sanitize(string $str): string {
    return trim(strip_tags($str));
}

function isLoggedIn(): bool {
    return isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id']);
}

function requireLogin(): void {
    if (!isLoggedIn()) {
        redirect(SITE_URL . '/admin/index.php');
    }
}

function redirect(string $url): void {
    header('Location: ' . $url);
    exit;
}



// ── Utilities ─────────────────────────────────────────────────
function slugify(string $text): string {
    $text = mb_strtolower($text, 'UTF-8');
    $text = preg_replace('/[^\w\s-]/', '', $text);
    $text = preg_replace('/[\s_-]+/', '-', $text);
    return trim($text, '-');
}

function timeAgo(string $datetime): string {
    $diff = time() - strtotime($datetime);
    if ($diff < 60)     return $diff . 's ago';
    if ($diff < 3600)   return floor($diff / 60) . 'm ago';
    if ($diff < 86400)  return floor($diff / 3600) . 'h ago';
    if ($diff < 604800) return floor($diff / 86400) . 'd ago';
    return date('M j, Y', strtotime($datetime));
}

function formatDate(string $date, string $format = 'M Y'): string {
    return date($format, strtotime($date));
}

// ── Image Upload ──────────────────────────────────────────────
function uploadImage(array $file, string $prefix = 'img'): string|false {
    $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    if (!in_array($file['type'], $allowed, true)) return false;
    if ($file['size'] > 5 * 1024 * 1024) return false;

    $ext      = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $filename = $prefix . '_' . uniqid() . '.' . $ext;
    $dest     = UPLOAD_PATH . $filename;

    if (!is_dir(UPLOAD_PATH)) {
        mkdir(UPLOAD_PATH, 0755, true);
    }
    return move_uploaded_file($file['tmp_name'], $dest) ? $filename : false;
}

// ── Data Fetchers ─────────────────────────────────────────────
function fetchAdmin(): array {
    return getDB()->query('SELECT * FROM admin_users LIMIT 1')->fetch() ?: [];
}

function fetchProjects(bool $featuredOnly = false): array {
    $sql = $featuredOnly
        ? 'SELECT * FROM projects WHERE is_featured = 1 ORDER BY sort_order ASC'
        : 'SELECT * FROM projects ORDER BY sort_order ASC';
    return getDB()->query($sql)->fetchAll();
}

function fetchSkills(): array {
    return getDB()->query('SELECT * FROM skills ORDER BY sort_order ASC')->fetchAll();
}

function fetchEducation(): array {
    return getDB()->query('SELECT * FROM education ORDER BY sort_order ASC')->fetchAll();
}

function fetchExperience(): array {
    return getDB()->query('SELECT * FROM experience ORDER BY sort_order ASC')->fetchAll();
}

function unreadMessageCount(): int {
    return (int) getDB()->query('SELECT COUNT(*) FROM messages WHERE is_read = 0')->fetchColumn();
}


/**
 * Portfolio Pro - Helper Functions
 */



// Get admin profile
function getAdmin() {
     return getDB()->query("SELECT * FROM admin_users LIMIT 1")->fetch();
}

// Get all skills by category
function getSkills() {
   return getDB()->query("SELECT * FROM skills ORDER BY category, sort_order, id")->fetchAll();
}


// Get featured projects
function getFeaturedProjects($limit = 3) {
$stmt = getDB()->prepare("SELECT * FROM projects WHERE is_featured=1 ORDER BY sort_order, id DESC LIMIT ?"); $stmt->execute([$limit]); return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get all projects
function getAllProjects() {
    return getDB()->query("SELECT * FROM projects ORDER BY sort_order, id DESC")->fetchAll()    ;
}

// Get education
function getEducation() {
    return getDB()->query("SELECT * FROM education ORDER BY sort_order, id")->fetchAll();
}

// Get experience
function getExperience() {
    return getDB()->query("SELECT * FROM experience ORDER BY sort_order, id")->fetchAll();
}

// Validate email
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Flash message helper
function setFlash($type, $msg) {
    $_SESSION['flash'] = ['type' => $type, 'msg' => $msg];
}

function getFlash() {
    if (isset($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $f;
    }
    return null;
}

// Handle file upload
function uploadFile($file, $dir = 'projects') {
    $allowed = ['jpg','jpeg','png','gif','webp'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) return false;
    if ($file['size'] > 5 * 1024 * 1024) return false;
    $filename = uniqid($dir . '_') . '.' . $ext;
    $dest = UPLOAD_PATH . $filename;
    if (!is_dir(UPLOAD_PATH)) mkdir(UPLOAD_PATH, 0755, true);
    if (move_uploaded_file($file['tmp_name'], $dest)) return $filename;
    return false;
}

// Format date
function fdate($d) {
    return date('M d, Y', strtotime($d));
}

// Check admin login
function requireAdmin() {
    if (!isset($_SESSION['admin_id'])) {
        header('Location: ' . SITE_URL . '/admin/login.php');
        exit;
    }
}

// Get unread messages count
function unreadMessages() {
    $r = getDB()->query("SELECT COUNT(*) as c FROM messages WHERE is_read=0")->fetch();
    return $r['c'] ?? 0;
}


?>