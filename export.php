<?php
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate');
require_once __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$password = is_array($input) ? (string)($input['password'] ?? '') : '';
if (!hash_equals(ADMIN_PASSWORD, $password)) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Incorrect admin password.']);
    exit;
}

$rows = [];
if (is_file(DATA_FILE)) {
    $decoded = json_decode((string)file_get_contents(DATA_FILE), true);
    if (is_array($decoded)) $rows = $decoded;
}
usort($rows, static function ($a, $b) {
    return ((int)($b['heroesPower'] ?? 0)) <=> ((int)($a['heroesPower'] ?? 0));
});
echo json_encode(['success' => true, 'applications' => $rows], JSON_UNESCAPED_UNICODE);
