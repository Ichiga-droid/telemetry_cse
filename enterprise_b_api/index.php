<?php
// Enterprise B simple API - returns JSON sensor data
header('Content-Type: application/json');

$stateFile = __DIR__ . '/state.json';

// If an override state exists, return it (allow query param ?mode=override to force)
if (file_exists($stateFile) && (!empty($_GET['mode']) && $_GET['mode'] === 'override')) {
    echo file_get_contents($stateFile);
    exit;
}

require __DIR__ . '/generator.php';

// If an override file exists and is non-empty, merge it into output (so we can simulate changes)
$override = [];
if (file_exists($stateFile)) {
    $contents = file_get_contents($stateFile);
    $override = json_decode($contents, true) ?: [];
}

$data = generate_data();

if (!empty($override)) {
    // merge override keys onto generated data (override takes precedence)
    $data = array_merge($data, $override);
    $data['source'] = 'override';
} else {
    $data['source'] = 'generated';
}

echo json_encode($data);
