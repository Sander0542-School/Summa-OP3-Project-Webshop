<?php
$pageTitle = "Fietsen";
include "assets/header.php";
?>

<div class="row">
  <div class="col col1"></div>
  <div class="col col8">
<?php
    $bikesList = $CORE->getBikes();
    if ($bikesList) {
      foreach ($bikesList as $bike) {
        echo '
    <div class="card">
      <div class="card-image">
        <span></span><img src="'.$bike["imagePath"].'">
      </div>
      <div class="card-content">
        <h2>'.$bike["name"].'</h2>
        <span>'.$bike["brand"].'</span>
      </div>
    </div>';
      }
    }
?>
  </div>
</div>

<?php
include "assets/footer.php"
?>