<?php
$pageTitle = "Fietsen";
include "assets/header.php";
?>

<?php
if (isset($_GET["id"])) {
  $bikeInfo = $CORE->getBikeInfo($_GET["id"]);
  if ($bikeInfo) {
    echo '
    <div class="row">
      <div class="col col1>"></div>
      <div class="col col10">
        
      </div>
    </div>';
  }
} else {
  $bikesList = $CORE->getBikes();
  if ($bikesList) {
    echo '
    <div class="row">
      <div class="col col1"></div>
      <div class="col col8 card-row">';
    foreach ($bikesList as $bike) {
      echo '
        <div onclick="window.location.href=\'/fietsen/'.$bike["id"].'/'. strtolower(preg_replace("/[^a-zA-Z0-9,-]+/", "", str_replace(" ", "-", $bike["name"]))).'\'" class="card">
          <div class="card-image">
            <span></span><img alt="'.$bike["name"].'" src="'.$bike["imagePath"].'">
          </div>
          <div class="card-content">
            <h3>'.$bike["brand"].' '.$bike["name"].'</h3>'; 
      if ($bike["isAction"]) {
        echo '
            <p><span class="old-price">'.$bike["price"].',-</span> <span class="current-price">'.$bike["actionPrice"].',-</span></p>';
      } else {
        echo '
            <p class="current-price">'.$bike["price"].',-</p>';
      } echo '
            <p class="kleuren">Kleuren: '.$bike["colors"].'</p>
          </div>
        </div>
';
    }
  }
  echo '
      </div>
    </div>';
}
?>


<?php
include "assets/footer.php"
?>