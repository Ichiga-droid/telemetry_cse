<?php
/*
 * enterprise_b_api/update.php
 *
 * Purpose:
 *   Accepts a JSON payload and saves it to `state.json` as an override
 *   for the mock API. The saved JSON will be merged onto generated
 *   payloads by `index.php`, allowing operators to simulate specific
 *   sensor conditions.
 *
 * Notes:
 *   - This endpoint intentionally does not implement authentication
 *     to keep the mock API simple for local development. Do NOT use
 *     this pattern in production.
 */

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

// Persist override state for the API to use on subsequent requests
file_put_contents($stateFile, json_encode($data, JSON_PRETTY_PRINT));

echo json_encode(['success' => true, 'saved' => $data]);
