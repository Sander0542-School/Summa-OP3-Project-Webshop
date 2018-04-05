<?php
$pageTitle = "Fietsen";
include "assets/header.php";
?>

<?php
if (isset($_GET["id"])) {
  $bikeInfo = $CORE->getBikeInfo($_GET["id"]);
  if ($bikeInfo) {
    echo '
    <script>
      document.title = "'. $bikeInfo["name"].' | De Concurrent";
    </script>
    <div class="row page-head margin-top">
      <div class="col col1"></div>
      <div class="col col3-5">
        <div class="card padding">
          <div class="card-content">
            <h2>'.$bikeInfo["brand"].' '.$bikeInfo["name"].'</h2>
            <div class="row">
              <div class="col col7">'; 
            if ($bikeInfo["isAction"]) {
              echo '
                  <p><span class="advies-price">Adviesprijs</span> <span class="old-price">'.$bikeInfo["price"].',-</span><br/><span class="current-price-big">'.$bikeInfo["actionPrice"].',-</span></p>';
            } else {
              echo '
                  <p class="current-price">'.$bikeInfo["price"].',-</p>';
            } 
            echo '
              </div>
              <div class="col col3" style="position:relative">';
              if ($CORE->isLoggedIn()) {
                echo '
                <form action="/bestellen" method="POST">
                  <input type="hidden" name="bikeID" value="'.$bikeInfo["id"].'">
                  <input type="submit" class="block bottom" value="Bestel">
                </form>';
              } else {
                echo '
                <form action="/bestellen" method="POST">
                  <input type="hidden" name="noLogin" value="true">
                  <input type="submit" class="block bottom" value="Bestellen">
                </form>';
              } echo '
              </div>
            </div>
            <hr>
            <h3>Omschrijving</h3>
            <p>'.$bikeInfo["description"].'</p>
            <hr>
            <h3>Eigenschappen</h3>
            <p>
              <b>Merk:</b> '.$bikeInfo["brand"].'<br/>
              <b>Model:</b> '.$bikeInfo["model"].'<br/>
              <b>Modeljaar:</b> '.$bikeInfo["modelYear"].'<br/>
              <b>Merk:</b> '.$bikeInfo["brand"].'<br/>
              <b>Kleuren:</b> '.$bikeInfo["colors"].'
            </p>
          </div>
        </div>
      </div>
      <div class="col col4-5">
        <div class="card padding">
          <div class="card-content">
            <img alt="'.$bikeInfo["name"].'" class="bike" src="'.$bikeInfo["imagePath"].'">
          </div>
        </div>
      </div>
    </div>';
  }
} else {
  $bikesList = $CORE->getBikes();
  if ($bikesList) {
    echo '
    <div class="row page-head margin-top">
      <div class="col col1"></div>
      <div class="col col8">
        <h2>Onze Fietsen</h2>
      </div>
    </div>
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
            <p class="small-text">Kleuren: '.$bike["colors"].'</p>
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