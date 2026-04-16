<?php
#/../ is the same as ../ just intercompatible between linux and windows hosting solutions and is the reference for going up to the parent directory. 
#The point of this file is to recieve a create_ad post request as json check that all fields required are present if not return a Bad Request error for insufficient fields, if all fields are present it loads the london.ads.json file formats an new json entry for the file, and writes the file with its current contents+new_ad and return a json  message
header('Content-Type: application/json'); 
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); # if server request is not a POST request e.g a GET reuqest return Invalid Request Method (http error 405) 
    echo json_encode(['error' => 'Method not allowed']); # Return json of Method not allowed
    exit;
}
# Read the raw HTTP request body sent to the server
# php://input is a data stream that contains the request data (in this case json)

# file_get_contents() reads that raw data as a string

# json_decode() converts the JSON string into a PHP variable $asdf e.g

$input = json_decode(file_get_contents('php://input'), true); # decode the parsed php 
#Json invalidation check, if the json is incorrectly formatted and therefore parsed worng return http error 415 invalid data type
if (!is_array($input)) {
    http_response_code(415);
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


$raw = file_get_contents($dataFile); # gets the contents of the london.ads.json file as a string and stores it in $raw 
$ads = json_decode($raw, true); # decodes the json string into a php variable $ads which should be an array of ads, if the json is invalid and cannot be decoded return http error 503 service unavailable
if (!is_array($ads)) { # if the decoded json is not an array (e.g if the file is empty or contains invalid json) return http error 503 service unavailable
    http_response_code(503); # Service Unavailable Http Error
    echo json_encode(['error' => 'Failed to parse data file']); # Return json of Failed to parse data file
    exit; # exit the script to prevent further execution
}
$newAd = [ # create a new ad array with the required fields and values from the input, also generate a unique id for the ad based on the number of existing ads in the file
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
