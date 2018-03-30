<?php
$pageTitle = "Reparatie";
include "assets/header.php";

$isLoggedIn = $CORE->isLoggedIn();

if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["subject"]) && isset($_POST["message"])) {
  if ($CORE->newReperation(($isLoggedIn ? $_SESSION["userSession"] : null), $_POST["name"], $_POST["email"], $_POST["subject"], $_POST["message"])) {
    echo '<div class="messagebox"><h3>Uw reparatie verzoek is verzonden</h3></div>';
  } else {
    echo '<div class="messagebox"><h3>Kon uw reparatie verzoek niet verzenden</h3></div>';
  }
}
?>

    <div class="row page-head margin-top">
      <div class="col col1"></div>
      <div class="col col8">
        <h2>Reparatie</h2>
      </div>
    </div>

    <div class="row">
      <div class="col col1"></div>
    </div>

    <div class="row">
      <div class="col col1"></div>
      <div class="col col3-5">
        <form class="reparatie-form" action="/reparatie" method="POST">
          <div class="form-group">
            <label for="naam">Naam</label>
            <input type="text" name="name"<?php if ($isLoggedIn) { echo ' value="'.$U_DATA["firstname"].' '.$U_DATA["lastname"].'"'; } ?> required>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email"<?php if ($isLoggedIn) { echo ' value="'.$U_DATA["email"].'"'; } ?> required>
          </div>
          <div class="form-group">
            <label for="subject">Onderwerp</label>
            <input type="text" name="subject" required>
          </div>
          <div class="form-group">
            <label for="message">Omschrijving van het probleem</label>
            <textarea rows="5" name="message" required></textarea><br/>
          </div>
          <input type="submit" value="Verzend">
        </form>
      </div>
      <div class="col col0-5"></div>
      <div class="col col4">
        <img src="/assets/images/concurrent3.jpg" alt="De Concurrent Werkplaats" width="100%">
        <p>Door onze professioneel ingerichte nieuwe werkplaats kunnen wij uw fiets in topconditie houden. Wij zijn altijd op de hoogte van de laatste technologische ontwikkelingen van o.a. Lefty, Shimano, Campagnolo, Rockshox en Sram. Wij volgen dan ook vele cursussen om de absolute specialist van Amsterdam te blijven. Ook verzorgen wij carbon reparatie's.</p>
      </div>
      <div class="col col1"></div>
    </div>

<?php
include "assets/footer.php"
?>