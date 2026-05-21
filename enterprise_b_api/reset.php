<?php
// Reset the override state (delete state.json)
header('Content-Type: application/json');

$stateFile = __DIR__ . '/state.json';
if (file_exists($stateFile)) {
    unlink($stateFile);
}

echo json_encode(['success' => true]);
