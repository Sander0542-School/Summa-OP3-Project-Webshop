<?php
$pageTitle = "Mijn Bestellingen";
include "assets/header.php";

if ($CORE->isLoggedIn()) {
  if (isset($_GET["id"])) {
    $orderInfo = $CORE->getOrderInfo($_GET["id"]);
    if ($orderInfo) {
      $totalPrice = 0;
      $totalBikes = 0;
      foreach ($orderInfo as $orderItem) {
        $totalPrice = $totalPrice + $orderItem["totalPrice"];
        $totalBikes = $totalBikes + $orderItem["totalBikes"];
      }
      echo '
    <div class="row page-head margin-top">
      <div class="col col1"></div>
      <div class="col col8">
        <h2>Bestelling van '.strftime("%A %e-%m-%G",strtotime($orderInfo[0]["orderDate"])).'</h2>
        <p class="small-text">Bestelnummer: '.$orderInfo[0]["orderID"].' | '.$totalBikes.' '.($totalBikes == 1 ? "artikel" : "artikelen").', totaal &euro;'.$totalPrice.',-</p>
      </div>
    </div>
    <div class="row">
      <div class="col col1"></div>
      <div class="col col8">
        <div class="card block">
          <div class="card-content">
            <div class="row">'; 

      foreach ($orderInfo as $orderItem) {
        echo '
              <div class="col col2-5 order-table">
                <div class="order-image">
                  <span></span><img alt="'.$orderItem["name"].'" src="'.$orderItem["imagePath"].'">
                </div>
                <div class="order-content">
                  <h3>'.$orderItem["brand"].' '.$orderItem["name"].'</h3>
                  <p class="small-text">Prijs/stuk: &euro;'.$orderItem["priceEach"].',-<br/>Aantal: '.$orderItem["quantity"].'</p>
                </div>
              </div>';
      }

      echo '
            </div>
            <hr>
            <h3>Bestelgegevens</h3>
            <p class="small-text"><strong>Bezorgadres</strong></p>
            <p class="small-text">'.$orderInfo[0]["firstname"].' '.$orderInfo[0]["lastname"].'<br/>'.$orderInfo[0]["street"].' '.$orderInfo[0]["houseNumber"].'<br/>'.$orderInfo[0]["zipcode"].' '.$orderInfo[0]["city"].'</p>
          </div>
        </div>
      </div>
    </div>';
    } else {
      echo '<div class="messagebox"><h3>Deze bestelling bestaat niet</h3></div>';
    }
  } else {
    $orderList = $CORE->getOrders();
    if ($orderList) {
      echo '
    <div class="row page-head margin-top">
      <div class="col col1"></div>
      <div class="col col8">
        <h2>Mijn Bestellingen</h2>
      </div>
    </div>
    <div class="row">
      <div class="col col1"></div>
      <div class="col col8 card-row">';
      foreach ($orderList as $order) {
        $orderItems = $CORE->getOrderInfo($order["orderID"]);
        $itemsShown = 0;
        echo '
        <div onclick="window.location.href=\'/bestellingen/'.$order["orderID"].'\'" class="card full-width">
          <div class="card-content">
            <div class="row">
              <div class="col col3">
                <h3>Bestelnummer: '.$order["orderID"].'</h3>
                <p class="small-text">'.$order["totalBikes"].' '.($order["totalBikes"] == 1 ? "artikel" : "artikelen").', totaal &euro;'.$order["totalPrice"].',-</p>
                <p class="small-text">'.strftime("%e %B %G %H:%M",strtotime($order["orderDate"])).'</p>
              </div>';
        foreach ($orderItems as $bike) {
          if ($itemsShown < 7) {
            echo '
              <div class="col col1 order-table">
                <div class="order-image">
                  <span></span><img alt="'.$bike["name"].'" src="'.$bike["imagePath"].'">
                </div>
              </div>';
          }
        }

        echo '
            </div>
          </div>
        </div>
    ';
      }
      echo '
    </div>
  </div>';
    } else {
      echo '<div class="messagebox"><h3>U heeft geen bestellingen</h3></div>';
    }
  }
} else {
  echo '<div class="messagebox"><h3>U moet inloggen om bestellingen te kunnen bekijken</h3></div>';
}

include "assets/footer.php"
?>