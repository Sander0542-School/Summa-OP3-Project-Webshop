    <nav>
      <div class="navbar-left"></div>
      <a href="#"><img class="nav-logo" alt="De Concurrent" src="/assets/images/logo.png"></a>
      <a href="/home" class="nav-item<?php if ($pageTitle == "Home") { echo " active"; } ?>">Home</a>
      <a href="/fietsen" class="nav-item<?php if ($pageTitle == "Fietsen") { echo " active"; } ?>">Fietsen</a>
      <a href="/reparatie" class="nav-item<?php if ($pageTitle == "Reparatie") { echo " active"; } ?>">Reparatie</a>
      <a href="/contact" class="nav-item<?php if ($pageTitle == "Contact") { echo " active"; } ?>">Contact</a>
      <div class="navbar-right"></div>
<?php
if ($CORE->isLoggedIn()) {
  echo '
      <div class="dropdown right">
        <a href="/login" class="nav-item dropdown-link'; if ($pageTitle == "Mijn Account" || $pageTitle == "Mijn Bestellingen") { echo " active"; } echo '">'.$U_DATA["firstname"].' '.$U_DATA["lastname"].'</a>
        <div class="dropdown-content">
          <a href="/account">Mijn Account</a>
          <a href="/bestellingen">Mijn Bestellingen</a>
          <a href="/logout?returnUrl='.str_replace(".php", "", $_SERVER["PHP_SELF"]).'">Logout</a>
        </div>
      </div> ';
} else {
  echo '
      <a href="/login?returnUrl='.str_replace(".php", "", $_SERVER["PHP_SELF"]).'" class="nav-item right'; if ($pageTitle == "Login") { echo " active"; } echo '">Login</a>
      <a href="/registreer" class="nav-item right'; if ($pageTitle == "Registreer") { echo " active"; } echo '">Registreer</a>';
}
?>
      <a href="/bestellen" class="nav-item right<?php if ($pageTitle == "Bestellen") { echo " active"; } ?>">Winkelwagen</a>
    </nav>
    <div class="navbar-top"></div>