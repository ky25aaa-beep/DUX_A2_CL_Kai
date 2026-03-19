<?php
header('Content-Type: application/json');

$query = $_GET['q'] ?? '';

    // locate data file relative to this script
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

$matches = array_filter($ads, function($ad) use ($query) {
    $title = $ad['ad_title'] ?? $ad['title'] ?? '';
    $desc = $ad['ad_description'] ?? $ad['description'] ?? '';
    $category = $ad['ad_category'] ?? '';
    $subcategory = $ad['ad_subcategory'] ?? '';
    $location = $ad['location'] ?? '';
    if (trim($query) === '') return true;
    $hay = $title . " " . $desc . " " . $category . " " . $subcategory . " " . $location;
    return stripos($hay, $query) !== false;
});

echo json_encode(array_values($matches));
