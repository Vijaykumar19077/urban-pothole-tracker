<?php
function e($value): string { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function is_logged_in(): bool { return isset($_SESSION['user_id']); }
function is_admin(): bool { return is_logged_in() && ($_SESSION['role'] ?? '') === 'admin'; }
function require_login(): void {
    if (!is_logged_in()) { header('Location: /urban-pothole-tracker/login.php'); exit; }
}
function require_admin(): void {
    if (!is_admin()) { header('Location: /urban-pothole-tracker/login.php'); exit; }
}
function status_class(string $status): string {
    return match ($status) { 'Under Repair' => 'repair', 'Resolved' => 'resolved', default => 'reported' };
}
function set_flash(string $message, string $type='success'): void { $_SESSION['flash'] = ['message'=>$message, 'type'=>$type]; }
function show_flash(): void {
    if (!empty($_SESSION['flash'])) {
        $f = $_SESSION['flash']; unset($_SESSION['flash']);
        echo '<div class="flash flash-'.e($f['type']).'">'.e($f['message']).'</div>';
    }
}
