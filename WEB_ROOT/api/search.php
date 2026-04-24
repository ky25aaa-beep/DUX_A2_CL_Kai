<?php
header('Content-Type: application/json');

$query = trim((string)($_GET['q'] ?? ''));
$filterLocation = trim((string)($_GET['location'] ?? ''));
$filterCategory = trim((string)($_GET['category'] ?? ''));
$limit = (int)($_GET['limit'] ?? 50);

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

// prepare tokens for query (split on whitespace, remove empty)
$tokens = [];
if ($query !== '') {
    // remove punctuation and split
    $clean = preg_replace('/[\p{P}\p{S}]+/u', ' ', mb_strtolower($query));
    $parts = preg_split('/\s+/', $clean, -1, PREG_SPLIT_NO_EMPTY);
    $tokens = $parts ?: [];
}

$results = [];
foreach ($ads as $ad) {
    $title = mb_strtolower($ad['ad_title'] ?? $ad['title'] ?? '');
    $desc = mb_strtolower($ad['ad_description'] ?? $ad['description'] ?? '');
    $category = mb_strtolower($ad['ad_category'] ?? $ad['category'] ?? '');
    $subcategory = mb_strtolower($ad['ad_subcategory'] ?? $ad['subcategory'] ?? '');
    $location = mb_strtolower($ad['location'] ?? '');

    // apply simple filters if provided
    if ($filterLocation !== '' && stripos($location, mb_strtolower($filterLocation)) === false) {
        continue;
    }
    if ($filterCategory !== '' && stripos($category, mb_strtolower($filterCategory)) === false && stripos($subcategory, mb_strtolower($filterCategory)) === false) {
        continue;
    }

    // if no query tokens provided, include the ad (subject to filters)
    if (count($tokens) === 0) {
        $results[] = ['score' => 1, 'ad' => $ad];
        continue;
    }

    // compute a simple relevance score
    $score = 0;
    foreach ($tokens as $t) {
        if ($t === '') continue;
        // boost title matches
        $score += substr_count($title, $t) * 4;
        // description matches
        $score += substr_count($desc, $t) * 1;
        // category/subcategory/location matches
        $score += substr_count($category, $t) * 2;
        $score += substr_count($subcategory, $t) * 2;
        $score += substr_count($location, $t) * 2;
    }

    if ($score > 0) {
        $results[] = ['score' => $score, 'ad' => $ad];
    }
}

// sort by score desc
usort($results, function($a, $b) {
    return $b['score'] <=> $a['score'];
});

// extract ads and enforce limit
$out = array_slice(array_map(function($r) { return $r['ad']; }, $results), 0, max(0, $limit));

echo json_encode(array_values($out));
