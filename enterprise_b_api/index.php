<?php
/*
 * enterprise_b_api/index.php
 *
 * Purpose:
 *   Minimal mock API that returns reactor sensor JSON. It produces
 *   generated sensor data (via generator.php) but allows an operator
 *   to override the generated values by creating an override JSON
 *   file at `enterprise_b_api/state.json`.
 *
 * Interconnections:
 *   - `generator.php` provides the `generate_data()` function used
 *     to create realistic synthetic sensor payloads.
 *   - `update.php` writes override JSON into `state.json`.
 *   - `reset.php` deletes `state.json` to resume generated output.
 *
 * Behavior:
 *   - If an override file exists, its keys are merged on top of
 *     generated data (override takes precedence) and the JSON is
 *     returned to the caller.
 *   - The optional query parameter `?mode=override` forces returning
 *     the override file directly when present.
 */

header('Content-Type: application/json');

$stateFile = __DIR__ . '/state.json';

// If caller explicitly requests the raw override file, return it
if (file_exists($stateFile) && (!empty($_GET['mode']) && $_GET['mode'] === 'override')) {
    echo file_get_contents($stateFile);
    exit;
}

// Load the generator that produces default, synthetic sensor data
require __DIR__ . '/generator.php';

// If an override file exists, decode it so we can merge keys
$override = [];
if (file_exists($stateFile)) {
    $contents = file_get_contents($stateFile);
    $override = json_decode($contents, true) ?: [];
}

$data = generate_data();

// Merge override values on top of generated data when present
if (!empty($override)) {
    $data = array_merge($data, $override);
    $data['source'] = 'override';
} else {
    $data['source'] = 'generated';
}

echo json_encode($data);
