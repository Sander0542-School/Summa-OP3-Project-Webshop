<?php
$pageTitle = "Contact";
include "assets/header.php";
?>

    <div class="row page-head margin-top">
      <div class="col col1"></div>
      <div class="col col8">
        <h2>Contact</h2>
      </div>
    </div>

    <div class="row">
      <div class="col col1"></div>
      <div class="col col4">
        <p>De Concurrent</p>
        <p>Seinpoststraat 8<br/>7766 BG Nunteren<br/>Tel: <a href="tel:+318082001833">0808-2001833</a><br/>Mobiel: <a href="tel:+31693447567">06-93447567</a></p>
      </div>
      <div class="col col4">
        <div id="map" class="google-maps"></div>

        <script>
          function initMap() {
            var uluru = {lat: 52.1070807, lng: 4.2824765};
            var map = new google.maps.Map(document.getElementById('map'), {
              zoom: 18,
              center: uluru,
              zoomControl: false,
              draggable: false
            });
            var marker = new google.maps.Marker({
              position: uluru,
              map: map
            });
          }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDhUaFv5qwATzUG_DlgxbNCH1wXBa-B-PQ&callback=initMap"></script>
      </div>
    </div>

<?php
include "assets/footer.php"
?>