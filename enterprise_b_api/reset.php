<?php
/*
 * enterprise_b_api/reset.php
 *
 * Purpose:
 *   Remove the override file (`state.json`) so `index.php` will
 *   resume returning generated sensor data. This is a convenience
 *   endpoint for testing and development.
 *
 * Notes:
 *   - No authentication is implemented; this is acceptable for the
 *     local mock environment but would be unsafe in production.
 */

header('Content-Type: application/json');

$stateFile = __DIR__ . '/state.json';
if (file_exists($stateFile)) {
    unlink($stateFile);
}

echo json_encode(['success' => true]);
