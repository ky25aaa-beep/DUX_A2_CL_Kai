<?php
header('Content-Type: application/json');
$dataFile = __DIR__ . '/../files/posts/london.ads.json';
if (!file_exists($dataFile) || !is_readable($dataFile)) {
    http_response_code(500);
    echo json_encode(['error' => 'Data file not found']);
    exit;
}
$raw = file_get_contents($dataFile);
$ads = json_decode($raw, true);
if (!is_array($ads)) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to parse data file']);
    exit;
}
echo json_encode($ads);
