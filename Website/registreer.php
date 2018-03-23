<?php
$pageTitle = "Registreer";
include "assets/header.php";

if (isset($_POST["firstname"]) && isset($_POST["lastname"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["repeatpassword"]) && isset($_POST["phonenumber"]) && isset($_POST["city"]) && isset($_POST["zipcode"]) && isset($_POST["street"]) && isset($_POST["housenumber"])) {
  if ($_POST["password"] == $_POST["repeatpassword"]) {
    $register = $CORE->register($_POST["email"], $_POST["firstname"], $_POST["lastname"], $_POST["password"], $_POST["phonenumber"], $_POST["city"], $_POST["zipcode"], $_POST["street"], $_POST["housenumber"]);
    if ($register) {
      echo '<div class="messagebox"><h3>Account aangemaakt, u kunt nu inloggen</h3></div>';
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
                <input type="text" name="firstname" required>
              </div>
              <div class="form-group">
                <label for="lastname">Achternaam</label>
                <input type="text" name="lastname" required>
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" required>
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
                <input type="number" name="phonenumber" required>
              </div>
              <div class="form-group">
                <label for="city">Stad</label>
                <input type="text" name="city" required>
              </div>
              <div class="form-group">
                <label for="zipcode">Postcode</label>
                <input type="text" name="zipcode" required>
              </div>
              <div class="form-group">
                <label for="street">Straat</label>
                <input type="text" name="street" required>
              </div>
              <div class="form-group">
                <label for="housenumber">Huis Nummer</label>
                <input type="number" name="housenumber" required>
              </div>
            </div>
          </div>
          <input type="submit" class="block" value="Registreer"><br/><br/>
        </div>
      </div>
    </form>

<?php
include "assets/footer.php"
?>