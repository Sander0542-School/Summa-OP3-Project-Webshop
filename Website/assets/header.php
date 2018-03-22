<?php
session_start();
include "classes/core.php";
$CORE = new CORE();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php if (isset($pageTitle)) { echo $pageTitle; } else { echo "Pagina"; } ?> | De Concurrent</title>

    <link rel="stylesheet" type="text/css" href="/assets/styles/deconcurrent.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  </head>
  <body onload="onReseize()" onscroll="onReseize()" onpageshow="onReseize()">

<!-- Navbar -->
<?php
include "head/nav.php";
?>

