<?php
$page = $_GET['page'] ?? 'Home';

# Basic cleaning
$page = trim(str_replace("\0", '', $page));
if ($page === '') {
  $page = 'Home';
}

# Only allow characters we expect (letters, numbers, underscore, hyphen, forward slash (no dots or backslashes to prevent directory traversal))
if (!preg_match('#^[A-Za-z0-9_\-\/]+$#', $page) || strpos($page, '..') !== false || strpos($page, '\\') !== false) {
  $page = 'Home';
}

$parts = explode('/', $page); # split by slash for potential subpages
$titleParts = array_map(function($p){ return ucwords(str_replace('-', ' ', $p)); }, $parts); # convert dashes to spaces and caps the front
$title = implode(' - ', $titleParts);

# Resolve and include only if the resolved path is inside pages/ and is a file
$pagesDir = realpath(__DIR__ . '/pages');
$requested = $page . '.php';
$fullPath = $pagesDir ? realpath($pagesDir . '/' . $requested) : false;
if ($fullPath && is_file($fullPath) && strpos($fullPath, $pagesDir) === 0) {
  $includePath = $fullPath;
} else {
  $includePath = $pagesDir . '/Home.php';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>craiglist: <?php echo $title; ?></title>
  <link rel="stylesheet" href="wireframe.css">
  <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

</head>
<body>

  <?php include 'fixed/nav-head.php'; ?>

  <!-- MAIN -->
  <div class="page-wrap">

    <?php include 'fixed/sidebar.php'; ?>

    <!-- CONTENT -->
    <main class="content">
      <?php include $includePath; ?>
    </main>

  </div>

  <?php include 'fixed/footer.php'; ?>


</body>
</html>

