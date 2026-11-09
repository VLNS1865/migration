<?php
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

require_once __DIR__ . '/config.php';

function respond(int $status, array $payload): void {
    http_response_code($status);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') respond(405, ['success' => false, 'message' => 'Method not allowed.']);

$raw = file_get_contents('php://input');
$input = json_decode($raw, true);
if (!is_array($input)) respond(400, ['success' => false, 'message' => 'Invalid submission.']);

$playerName = trim((string)($input['playerName'] ?? ''));
$currentServer = trim((string)($input['currentServer'] ?? ''));
$heroesPower = filter_var($input['heroesPower'] ?? null, FILTER_VALIDATE_INT);
$hqLevel = filter_var($input['hqLevel'] ?? null, FILTER_VALIDATE_INT);
$mainSquadPower = filter_var($input['mainSquadPower'] ?? null, FILTER_VALIDATE_INT);
$alliance = trim((string)($input['alliance'] ?? ''));
$additionalInfo = trim((string)($input['additionalInfo'] ?? ''));

if ($playerName === '' || $currentServer === '' || $heroesPower === false || $heroesPower === null ||
    $hqLevel === false || $hqLevel === null || $mainSquadPower === false || $mainSquadPower === null) {
    respond(422, ['success' => false, 'message' => 'Please check the required fields.']);
}
if (mb_strlen($playerName) > 50 || mb_strlen($currentServer) > 12 || mb_strlen($alliance) > 60 || mb_strlen($additionalInfo) > 1200 ||
    $heroesPower < 0 || $mainSquadPower < 0 || $hqLevel < 1 || $hqLevel > 40) {
    respond(422, ['success' => false, 'message' => 'One or more values are outside the allowed limits.']);
}

$record = [
    'submittedAt' => gmdate('c'),
    'playerName' => $playerName,
    'currentServer' => $currentServer,
    'heroesPower' => $heroesPower,
    'hqLevel' => $hqLevel,
    'mainSquadPower' => $mainSquadPower,
    'alliance' => $alliance,
    'additionalInfo' => $additionalInfo
];

$dir = dirname(DATA_FILE);
if (!is_dir($dir) && !mkdir($dir, 0750, true)) respond(500, ['success' => false, 'message' => 'Server storage is unavailable.']);
$file = fopen(DATA_FILE, 'c+');
if (!$file) respond(500, ['success' => false, 'message' => 'Could not save the application.']);
if (!flock($file, LOCK_EX)) { fclose($file); respond(500, ['success' => false, 'message' => 'Could not save the application.']); }

$contents = stream_get_contents($file);
$rows = $contents ? json_decode($contents, true) : [];
if (!is_array($rows)) $rows = [];
$record['id'] = bin2hex(random_bytes(8));
$rows[] = $record;

rewind($file);
ftruncate($file, 0);
$written = fwrite($file, json_encode($rows, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
fflush($file);
flock($file, LOCK_UN);
fclose($file);

if ($written === false) respond(500, ['success' => false, 'message' => 'Could not save the application.']);
respond(200, ['success' => true]);
