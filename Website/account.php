<?php
$pageTitle = "Account";
include "assets/header.php";

$isLoggedIn = $CORE->isLoggedIn();

if ($isLoggedIn && isset($_POST["email"]) && isset($_POST["firstname"]) && isset($_POST["lastname"]) && isset($_POST["phonenumber"]) && isset($_POST["city"]) && isset($_POST["zipcode"]) && isset($_POST["street"]) && isset($_POST["housenumber"])) {
  if ($CORE->updateCustomerInfo($_POST["email"],$_POST["firstname"],$_POST["lastname"],$_POST["phonenumber"],$_POST["city"],str_replace(" ", "", $_POST["zipcode"]),$_POST["street"],$_POST["housenumber"])) {
    echo '<div class="messagebox"><h3>Account informatie bijgewerkt</h3></div>';
  } else {
    echo '<div class="messagebox"><h3>Kon account informatie niet bijwerken</h3></div>';
  }
}

if ($isLoggedIn)  {
  $stmt = $CORE->runQuery("SELECT * FROM customers WHERE id=:id");
  $stmt->execute(array(":id"=>$_SESSION['userSession']));
  $U_DATA = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($isLoggedIn) {

  echo '
    <div class="row page-head margin-top">
      <div class="col col1"></div>
      <div class="col col8">
        <h2>Account</h2>
      </div>
    </div>

    <form action="/account" method="POST">
      <div class="row">
        <div class="col col2-5"></div>
        <div class="col col5">
          <div class="row">
            <div class="col4-5">
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" value="'.$U_DATA["email"].'" required>
              </div>
              <div class="form-group">
                <label for="firstname">Voornaam</label>
                <input type="text" name="firstname" value="'.$U_DATA["firstname"].'" required>
              </div>
              <div class="form-group">
                <label for="lastname">Achternaam</label>
                <input type="text" name="lastname" value="'.$U_DATA["lastname"].'" required>
              </div>
              <div class="form-group">
                <label for="phonenumber">Telefoon Nummer</label>
                <input type="number" name="phonenumber" value="'.$U_DATA["phoneNumber"].'" required><br/>
              </div>
            </div>
            <div class="col1"></div>
            <div class="col4-5">
              <div class="form-group">
                <label for="city">Stad</label>
                <input type="text" name="city" value="'.$U_DATA["city"].'" required>
              </div>
              <div class="form-group">
                <label for="zipcode">Postcode</label>
                <input type="text" pattern="^[1-9][0-9]{3} ?(?!sa|sd|ss)[a-zA-Z]{2}$" title="Postcode (1234 AB)" name="zipcode" value="'.$U_DATA["zipcode"].'" required>
              </div>
              <div class="form-group">
                <label for="street">Straat</label>
                <input type="text" name="street" value="'.$U_DATA["street"].'" required>
              </div>
              <div class="form-group">
                <label for="housenumber">Huis Nummer</label>
                <input type="number" name="housenumber" value="'.$U_DATA["houseNumber"].'" required>
              </div>
            </div>
          </div>
          <input type="submit" class="block" value="Bijwerken"><br/><br/>
        </div>
      </div>
    </form>';

} else {
  echo '<div class="messagebox"><h3>U moet inloggen om de account pagina te kunnen bekijken</h3></div>';
}

include "assets/footer.php"
?>