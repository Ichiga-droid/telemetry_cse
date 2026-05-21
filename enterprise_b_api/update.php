<?php
// Update override state used by the API (no auth for simplicity)
header('Content-Type: application/json');

$stateFile = __DIR__ . '/state.json';

$body = file_get_contents('php://input');
if (trim($body) === '') {
    http_response_code(400);
    echo json_encode(['error' => 'empty payload']);
    exit;
}

$data = json_decode($body, true);
if ($data === null) {
    http_response_code(400);
    echo json_encode(['error' => 'invalid json']);
    exit;
}

// Save override state
file_put_contents($stateFile, json_encode($data, JSON_PRETTY_PRINT));

echo json_encode(['success' => true, 'saved' => $data]);
