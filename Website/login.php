<?php
$pageTitle = "Login";
$footerScript = true;
include "assets/header.php";
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
            <input type="email" name="email">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password"><br/>
          </div>
          <input type="submit" class="block" value="Login"><br/><br/>
        </form>
      </div>
    </div>

<?php
include "assets/footer.php"
?>