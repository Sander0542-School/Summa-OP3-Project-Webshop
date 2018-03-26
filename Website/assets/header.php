<?php
session_start();
include "classes/core.php";
$CORE = new CORE();
if ($CORE->isLoggedIn())  {
  $stmt = $CORE->runQuery("SELECT * FROM customers WHERE id=:id");
  $stmt->execute(array(":id"=>$_SESSION['userSession']));
  $U_DATA = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php if (isset($pageTitle)) { echo $pageTitle; } else { echo "Pagina"; } ?> | De Concurrent</title>

    <link rel="stylesheet" type="text/css" href="/assets/styles/deconcurrent.css">
  </head>
  <body>

<!-- Navbar -->
<?php
include "head/nav.php";
?>

