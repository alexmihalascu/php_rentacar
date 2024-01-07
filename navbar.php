<?php
// Acest fișier presupune că sesiunea a fost deja inițiată înainte de includerea acestuia
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="index.php">PRC RENT A CAR</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <?php if (isset($_SESSION['logat'])): ?>
        <li class="nav-item">
          <a class="nav-link" href="profil.php">Profilul Meu</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="inchirierile_mele.php">Închirierile Mele</a>
        </li>
        <?php if (isset($_SESSION['este_admin']) && $_SESSION['este_admin'] == 1): ?>
          <li class="nav-item">
            <a class="nav-link" href="panou_control.php">Panou Control Admin</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="cereri_inchiriere.php">Cereri Închiriere</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="adauga_masina.php">Adaugă Mașină</a>
          </li>
        <?php endif; ?>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Deconectare</a>
        </li>
      <?php else: ?>
        <li class="nav-item">
          <a class="nav-link" href="autentificare.php">Autentificare</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="inregistrare.php">Înregistrare</a>
        </li>
      <?php endif; ?>
    </ul>
  </div>
</nav>
