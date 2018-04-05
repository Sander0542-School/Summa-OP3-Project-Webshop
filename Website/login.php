<?php
$pageTitle = "Login";
include "assets/header.php";

if (isset($_POST["email"]) && isset($_POST["password"])) {
  if ($CORE->login($_POST["email"], hash("sha256", $_POST["password"]))) {
    if (isset($_POST["returnUrl"])) {
      $CORE->redirect($_POST["returnUrl"]);
    } else {
      $CORE->redirect('/login?success');
    }
  } else {
    echo '<div class="messagebox"><h3>Uw email of wachtwoord klopt niet</h3></div>';
  }
} elseif (isset($_GET["success"])) {
  echo '<div class="messagebox"><h3>U bent nu inglogd</h3></div>';
}
?>

    <div class="row page-head margin-top">
      <div class="col col1"></div>
      <div class="col col8">
        <h2>Login</h2>
      </div>
    </div>

    <div class="row">
      <div class="col col4"></div>
      <div class="col col2">
        <form action="/login" method="POST">
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" required>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" required><br/>
          </div>
          <?php if (isset($_GET["returnUrl"])) { echo '<input type="hidden" name="returnUrl" value="'.$_GET["returnUrl"].'">'; } ?>
          <input type="submit" class="block" value="Login">
          <hr>
          <p class="form-below"><a href="/registreer">Nog geen account? Klik hier om er een te maken</a></p>
        </form>
      </div>
    </div>

<?php
include "assets/footer.php"
?>