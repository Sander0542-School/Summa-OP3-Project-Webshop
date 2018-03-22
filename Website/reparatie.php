<?php
$pageTitle = "Reparatie";
include "assets/header.php";
?>

    <div class="row page-head margin-top">
      <div class="col col1"></div>
      <div class="col col8">
        <h2>Reparatie</h2>
      </div>
    </div>

    <div class="row">
      <div class="col col1"></div>
      <div class="col col4-5">
        <form class="reparatie-form" action="/reparatie" method="POST">
          <div class="form-group">
            <label for="naam">Naam</label>
            <input type="text" name="formNaam">
          </div>
          <div class="form-group">
            <label for="naam">Email</label>
            <input type="text" name="formEmail">
          </div>
          <div class="form-group">
            <label for="naam">Onderwerp</label>
            <input type="text" name="formSubject">
          </div>
          <div class="form-group">
            <label for="naam">Naam</label>
            <textarea rows="5" name="formMessage"></textarea>
          </div>
        </form>
      </div>
      <div class="col col3-5">

      </div>
      <div class="col col1"></div>
    </div>

<?php
include "assets/footer.php"
?>