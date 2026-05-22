<?php
/*
 * history.php
 *
 * Purpose:
 *   Exposes the list of saved historical API JSON files and serves
 *   individual file contents. The dashboard front-end uses this to
 *   present recent files and to display the contents of a selected
 *   historical snapshot.
 *
 * Interconnections:
 *   - Reads files from `dashboard/storage` which is populated by
 *     `api_fetch.php` (automatic saves) or `store_data.php` (manual
 *     saves from other clients).
 *   - Returns JSON in two forms:
 *       - `GET history.php` -> `{ files: [ {name, timestamp}, ... ] }`
 *       - `GET history.php?file=NAME` -> file contents (application/json)
 */

session_start();
if (!isset($_SESSION['username'])) {
    http_response_code(401);
    echo json_encode(['error' => 'authentication required']);
    exit;
}

$storagePath = __DIR__ . '/storage';
// Ensure storage folder exists
if (!is_dir($storagePath)) {
    mkdir($storagePath, 0755, true);
}

// If a specific file was requested, validate and return it
if (isset($_GET['file'])) {
    $file = basename($_GET['file']);
    $path = $storagePath . '/' . $file;
    if (!file_exists($path)) {
        http_response_code(404);
        echo json_encode(['error' => 'file not found']);
        exit;
    }

    header('Content-Type: application/json');
    echo file_get_contents($path);
    exit;
}

// Otherwise enumerate JSON files and return their names + timestamps
$files = [];
foreach (scandir($storagePath) as $entry) {
    if ($entry === '.' || $entry === '..') {
        continue;
    }
    if (substr($entry, -5) !== '.json') {
        continue;
    }
    $path = $storagePath . '/' . $entry;
    $files[] = [
        'name' => $entry,
        'timestamp' => date('c', filemtime($path)),
    ];
}

// Sort newest-first by filename (timestamp-based filename format)
usort($files, fn($a, $b) => strcmp($b['name'], $a['name']));

header('Content-Type: application/json');
echo json_encode(['files' => $files]);
