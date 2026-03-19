<?php
header('Content-Type: application/json');
$dataFile = __DIR__ . '/../files/posts/london.ads.json';
$featuredFile = __DIR__ . '/../files/posts/london.featured.json';
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
$today = date('Y-m-d');
$featured = [];

$postIds = array_column($ads, 'id');

if (file_exists($featuredFile) && is_readable($featuredFile)) {
    $rawFeatured = file_get_contents($featuredFile);
    $featuredData = json_decode($rawFeatured, true);

    if (is_array($featuredData) && isset($featuredData['day']) && $featuredData['day'] === $today) {
        $cached = $featuredData['post_ids'] ?? [];
        $featured = array_values(array_intersect($cached, $postIds));
    }
}

if (empty($featured)) {
    shuffle($postIds);
    $featured = array_slice($postIds, 0, 6);
    $featuredData = [
        'day' => $today,
        'post_ids' => $featured
    ];
    file_put_contents($featuredFile, json_encode($featuredData));
}
$featuredAds = array_filter($ads, function($ad) use ($featured) {
    return in_array($ad['id'], $featured);
});
echo json_encode(array_values($featuredAds));
