<?php
/*
 * enterprise_b_api/generator.php
 *
 * Purpose:
 *   Produces a realistic-looking JSON payload representing reactor
 *   sensor telemetry. The function `generate_data()` is intentionally
 *   simple and deterministic in shape so the dashboard can render
 *   temperature, pressure, status, alerts and additional details.
 *
 * Notes:
 *   - Value ranges are produced using `mt_rand()` and then scaled to
 *     readable units. This is a mock; in real deployments the API
 *     would return real sensor values.
 */

function generate_data() {
    // Temperature in Celsius (mock range)
    $temperature = round(mt_rand(2600, 3400) / 100, 2); // 26.00 - 34.00 °C

    // Pressure in bar (mock range)
    $pressure = round(mt_rand(15000, 22000) / 100, 2); // 150.00 - 220.00 bar

    // Determine simplified status and alerts based on thresholds
    $status = 'OK';
    $alerts = [];
    if ($temperature > 33 || $pressure > 210) {
        $status = 'Critical';
        $alerts[] = 'Sensor reading above critical threshold';
    } elseif ($temperature > 31 || $pressure > 200) {
        $status = 'Warning';
        $alerts[] = 'Sensor reading approaching critical threshold';
    }

    // Additional synthetic details that the dashboard can display
    $details = [
        'sensor_core_1' => round(mt_rand(2500, 3400) / 100, 2),
        'sensor_core_2' => round(mt_rand(2500, 3400) / 100, 2),
        'coolant_flow' => round(mt_rand(800, 1200) / 10, 1), // arbitrary units
        'reactor_power_pct' => round(mt_rand(7000, 10000) / 100, 2),
    ];

    return [
        'timestamp' => gmdate('c'),
        'temperature' => $temperature,
        'pressure' => $pressure,
        'status' => $status,
        'alerts' => $alerts,
        'details' => $details
    ];
}
