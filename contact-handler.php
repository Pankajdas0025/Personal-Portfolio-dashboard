<?php
/**
 * Contact Form Handler – AJAX endpoint
 * Returns JSON response
 */
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    exit;
}

$name    = sanitize($_POST['name'] ?? '');
$email   = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$subject = sanitize($_POST['subject'] ?? '');
$message = sanitize($_POST['message'] ?? '');

// Validation
$errors = [];
if (empty($name) || strlen($name) < 2)    $errors[] = 'Name must be at least 2 characters.';
if (!$email)                               $errors[] = 'Please enter a valid email address.';
if (empty($message) || strlen($message) < 10) $errors[] = 'Message must be at least 10 characters.';

if (!empty($errors)) {
    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    exit;
}

// Rate limiting (simple: 1 message per IP per 60 seconds)
$ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
$db = getDB();
$stmt = $db->prepare('SELECT COUNT(*) FROM messages WHERE ip_address = ? AND created_at > NOW() - INTERVAL 60 SECOND');
$stmt->execute([$ip]);
if ($stmt->fetchColumn() >= 3) {
    echo json_encode(['success' => false, 'message' => 'Too many requests. Please wait a moment.']);
    exit;
}

// Insert
try {
    $stmt = $db->prepare('INSERT INTO messages (name, email, subject, message, ip_address) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$name, $email, $subject, $message, $ip]);
    echo json_encode(['success' => true, 'message' => 'Message sent successfully! I\'ll get back to you soon.']);
} catch (PDOException $e) {
    error_log('Contact form error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Server error. Please try again later.']);
}
