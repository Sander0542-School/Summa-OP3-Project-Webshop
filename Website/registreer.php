<?php
$pageTitle = "Registreer";
include "assets/header.php";

if (isset($_POST["firstname"]) && isset($_POST["lastname"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["repeatpassword"]) && isset($_POST["phonenumber"]) && isset($_POST["city"]) && isset($_POST["zipcode"]) && isset($_POST["street"]) && isset($_POST["housenumber"])) {
  if ($_POST["password"] == $_POST["repeatpassword"]) {
    $register = $CORE->register($_POST["email"], $_POST["firstname"], $_POST["lastname"], hash("sha256",$_POST["password"]), $_POST["phonenumber"], $_POST["city"], str_replace(" ", "", $_POST["zipcode"]), $_POST["street"], $_POST["housenumber"]);
    if ($register) {
      echo '<div class="messagebox"><h3>Account aangemaakt, u kunt nu inloggen</h3></div>';
      unset($_POST);
    } else {
      echo '<div class="messagebox"><h3>Kon account niet maken</h3></div>';
    }
  } else {
    echo '<div class="messagebox"><h3>Wachtwoorden komen niet overeen</h3></div>';
  }
}
?>

    <div class="row page-head margin-top">
      <div class="col col1"></div>
      <div class="col col8">
        <h2>Registreer</h2>
      </div>
    </div>

    <form action="/registreer" method="POST">
      <div class="row">
        <div class="col col2-5"></div>
        <div class="col col5">
          <div class="row">
            <div class="col4-5">
              <div class="form-group">
                <label for="firstname">Voornaam</label>
                <input type="text" name="firstname"<?php if (isset($_POST["firstname"])) { echo 'value="'.$_POST["firstname"].'"'; } ?> required>
              </div>
              <div class="form-group">
                <label for="lastname">Achternaam</label>
                <input type="text" name="lastname"<?php if (isset($_POST["lastname"])) { echo 'value="'.$_POST["lastname"].'"'; } ?> required>
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email"<?php if (isset($_POST["email"])) { echo 'value="'.$_POST["email"].'"'; } ?> required>
              </div>
              <div class="form-group">
                <label for="password">Wachtwoord</label>
                <input type="password" name="password" required>
              </div>
              <div class="form-group">
                <label for="repeatpassword">Herhaal Wachtwoord</label>
                <input type="password" name="repeatpassword" required><br/>
              </div>
            </div>
            <div class="col1"></div>
            <div class="col4-5">
              <div class="form-group">
                <label for="phonenumber">Telefoon Nummer</label>
                <input type="number" name="phonenumber"<?php if (isset($_POST["phonenumber"])) { echo 'value="'.$_POST["phonenumber"].'"'; } ?> required>
              </div>
              <div class="form-group">
                <label for="city">Stad</label>
                <input type="text" name="city"<?php if (isset($_POST["city"])) { echo 'value="'.$_POST["city"].'"'; } ?> required>
              </div>
              <div class="form-group">
                <label for="zipcode">Postcode</label>
                <input type="text" pattern="^[1-9][0-9]{3} ?(?!sa|sd|ss)[a-zA-Z]{2}$" title="Postcode (1234AB)" name="zipcode"<?php if (isset($_POST["zipcode"])) { echo 'value="'.$_POST["zipcode"].'"'; } ?> required>
              </div>
              <div class="form-group">
                <label for="street">Straat</label>
                <input type="text" name="street"<?php if (isset($_POST["street"])) { echo 'value="'.$_POST["street"].'"'; } ?> required>
              </div>
              <div class="form-group">
                <label for="housenumber">Huis Nummer</label>
                <input type="number" name="housenumber"<?php if (isset($_POST["housenumber"])) { echo 'value="'.$_POST["housenumber"].'"'; } ?> required>
              </div>
            </div>
          </div>
          <input type="submit" class="block" value="Registreer">
          <hr>
          <p class="form-below">Al een account? Klik <a href="/login">hier</a> om in te loggen</p>
        </div>
      </div>
    </form>

<?php
include "assets/footer.php"
?>