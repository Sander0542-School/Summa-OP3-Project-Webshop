<?php
$pageTitle = "Winkelwagen";
include "assets/header.php";

$isLoggedIn = $CORE->isLoggedIn();

$displayShoppingCart = true;

if (isset($_POST["bestel"]) && $isLoggedIn) {
  if ($CORE->orderShoppingCart()) {
    echo '<div class="messagebox"><h3>Uw bestelling is geplaatst</h3></div>';
    $CORE->emptyShoppingCart();
  } else {
    echo '<div class="messagebox"><h3>Kon uw bestelling niet plaatsen</h3></div>';
  }
  $displayShoppingCart = false;
} elseif (isset($_POST["bikeID"]) && $isLoggedIn) {
  $CORE->updateShoppingCart($_SESSION['userSession'], $_POST["bikeID"]);
} elseif (isset($_POST["bikeID"]) && isset($_POST["customerID"])) {
  $CORE->updateShoppingCart($_POST["customerID"], $_POST["bikeID"]);
} elseif (isset($_POST["deleteBike"]) && $isLoggedIn) {
  if ($CORE->deleteItemFromShoppingCart($_POST["deleteBike"])) {
    echo '<div class="messagebox"><h3>Fiets verwijderd uit winkelwagen</h3></div>';
  } else {
    echo '<div class="messagebox"><h3>Kon uw fiets niet verwijderen uit de winkelwagen</h3></div>';
  }
}
?>

<?php
if ($displayShoppingCart) {
  if ($CORE->isLoggedIn()) {
    $shoppingCart = $CORE->getShoppingCart();
    if ($shoppingCart) {
      $bikesPrice = 0;
      $bikesCount = 0;

      echo '
    <div class="row page-head margin-top">
      <div class="col col1"></div>
      <div class="col col8">
        <h2>Winkelwagen</h2>
      </div>
    </div>

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
                    <td width="57%">Naam</td>
                    <td width="15%">Prijs</td>
                    <td width="15%">Aantal</td>
                    <td width="5%"></td>
                  </tr>
                </thead>
                <tbody>';

      foreach ($shoppingCart as $bike) {
        $bikesPrice = $bikesPrice + (($bike["isAction"] == true ? $bike["actionPrice"] : $bike["price"]) * $bike["quantity"]);
        $bikesCount = $bikesCount + $bike["quantity"];

        echo '
                  <tr class="shoppingcart-item">
                    <td><img src="'.$bike["imagePath"].'" alt="'.$bike["name"].'"></td>
                    <td>'.$bike["name"].'</td>
                    <td>&euro;'; if ($bike["isAction"]) {echo $bike["actionPrice"]; } else { echo $bike["price"]; } echo ',-</td>
                    <td>'.$bike["quantity"].'</td>
                    <td>
                      <form action="/bestellen" method="POST">
                        <input type="hidden" value="'.$bike["id"].'" name="deleteBike">
                        <input type="submit" value="&#10006;">
                      </form>
                    </td>
                  </tr>';
      }

      echo '
                  <tr>
                    <td></td>
                    <td></td>
                    <td><strong>Totaal: &euro;'.$bikesPrice.',-</strong></td>
                    <td><strong>Totaal: '.$bikesCount.'</strong></td>
                  </tr>
                </tbody>
              </table><br/>
              <input type="submit" class="shoppingcart-order" name="bestel" value="Bestel">
            </form>
          </div>
        </div>
      </div>
    </div>';
    } else {
      echo '<div class="messagebox"><h3>U heeft geen fietsen in uw winkelwagen</h3></div>';
    }
  } else {
    echo '<div class="messagebox"><h3>U moet inloggen om fietsen te kunnen bestellen</h3></div>';
  }
}
?>

<?php
include "assets/footer.php"
?>