#get ad wordwrapith ad id and return ad details as json
<?php
header('Content-Type: application/json');
$adId = $_GET['id'] ?? '';
if (trim($adId) === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Ad ID is required']);
    exit;
}
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
$ad = null;
foreach ($ads as $item) {
    if (isset($item['id']) && $item['id'] === $adId
        || isset($item['ad_id']) && $item['ad_id'] === $adId) {
        $ad = $item;
        break;
    }
}
if ($ad) {
    echo json_encode($ad);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Ad not found']);
}
