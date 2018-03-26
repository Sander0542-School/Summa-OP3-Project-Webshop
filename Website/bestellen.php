<?php
$pageTitle = "Winkelwagen";
include "assets/header.php";

if (isset($_POST["bikeID"])) {
  if (empty($_SESSION["shoppingcart"])) {
    $_SESSION["shoppingcart"] = array();
  }
  array_push($_SESSION["shoppingcart"], array($_POST["bikeID"], 1));
}

if (!empty($_SESSION["shoppingcart"])) {
  $bikeItems = array();
  foreach ($_SESSION["shoppingcart"] as $bike) {
    if ($bikeItems[$bike][1] > 0) {
      $bikeItems[$bike] = array($bike, $bikeItems[$bike][1] + 1);
    } else {
      $bikeItems[$bike] = array($bike, 1);
    }
  }
  $_SESSION["shoppingcart"] = $bikeItems;
}
?>

    <div class="row page-head margin-top">
      <div class="col col1"></div>
      <div class="col col8">
        <h2>Winkelwagen</h2>
      </div>
    </div>

<?php
if (!empty($_SESSION["shoppingcart"])) {
  echo '
    <div class="row">
      <div class="col col1"></div>
      <div class="col col8">
        <div class="card full-width">
          <div class="card-content">
            <form action="/bestellen" method="POST">
              <table width="100%">
                <thead>
                  <tr>
                    <td width="8%"></td>
                    <td width="62%">Naam</td>
                    <td width="15%">Prijs</td>
                    <td width="15%">Aantal</td>
                  </tr>
                </thead>
                <tbody>';

  foreach ($_SESSION["shoppingcart"] as $bike) {
    $bikeInfo = $CORE->getBikeInfo($bike[1]);
  
    if ($bikeInfo) {
      echo '
                  <tr class="shoppingcart-item">
                    <td><img src="'.$bikeInfo["imagePath"].'" alt=".$bikeInfo["name"]."></td>
                    <td>'.$bikeInfo["name"].'</td>
                    <td>'.$bikeInfo["price"].'</td>
                    <td>1</td>
                  </tr>';
    }
  }

  echo '
                </tbody>
              </table>
              <input type="submit" class="shoppingcart-order" value="Bestel">
            </form>
          </div>
        </div>
      </div>
    </div>';
} else {
  echo '<div class="messagebox"><h3>U heeft geen items in uw winkelwagen</h3></div>';
}
?>

<?php
include "assets/footer.php"
?>