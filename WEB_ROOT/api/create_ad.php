#create ad api function will recieve post request containing ad details and save it to london.ads.json file
<?php
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}
$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON']);
    exit;
}
$requiredFields = ['ad_title', 'ad_description', 'ad_price', 'location', 'creation_user', 'ad_category'];
foreach ($requiredFields as $field) {
    if (empty($input[$field])) {
        http_response_code(400);
        echo json_encode(['error' => "Field '$field' is required"]);
        exit;
    }
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
$newAd = [
    'id' => 'ad' . str_pad(count($ads) + 1,
        3, '0', STR_PAD_LEFT),
    'creation_user' => $input['creation_user'],
    'location' => $input['location'],
    'ad_title' => $input['ad_title'],
    'ad_category' => $input['ad_category'] ?? '',
    'ad_subcategory' => $input['ad_subcategory'] ?? '',
    'ad_price' => $input['ad_price'],
    'ad_type' => $input['ad_type'] ?? 'offering',
    'ad_description' => $input['ad_description'],
    'created_at' => gmdate('c'),
    'images' => $input['images'] ?? []
];
$ads[] = $newAd;
if (file_put_contents($dataFile, json_encode($ads, JSON_PRETTY_PRINT)) === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to save ad']);
    exit;
}
echo json_encode(['success' => true, 'ad_id' => $newAd['id']]); 
