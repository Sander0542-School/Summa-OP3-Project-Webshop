<?php
$pageTitle = "Loguit";
include "assets/header.php";

$CORE->logout();
if (isset($_GET["returnUrl"])) {
  $CORE->redirect($_GET['returnUrl']);
} else {
  $CORE->redirect('/home');
}
?>

    <div class="row page-head margin-top">
      <div class="col col1"></div>
      <div class="col col8">
        <h2>Logout</h2>
      </div>
    </div>

<?php
include "assets/footer.php"
?>