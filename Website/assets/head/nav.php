<nav>
  <div class="navbar-left"></div>
  <a href="/home" class="nav-item<?php if ($pageTitle == "Home") { echo " active"; } ?>">Home</a>
  <a href="/fietsen" class="nav-item<?php if ($pageTitle == "Fietsen") { echo " active"; } ?>">Fietsen</a>
  <a href="/reparatie" class="nav-item<?php if ($pageTitle == "Reparatie") { echo " active"; } ?>">Reparatie</a>
  <a href="/contact" class="nav-item<?php if ($pageTitle == "Contact") { echo " active"; } ?>">Contact</a>
  <div class="navbar-right"></div>
  <a href="/login" class="nav-item right<?php if ($pageTitle == "Login") { echo " active"; } ?>">Login</a>
  <a href="/registreer" class="nav-item right<?php if ($pageTitle == "Registreer") { echo " active"; } ?>">Registreer</a>
</nav>
