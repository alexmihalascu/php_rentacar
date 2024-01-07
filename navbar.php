<nav class="navbar navbar-expand-lg navbar-dark p-3 bg-primary">
    <div class="container-fluid">
        <!-- Butoanele din stânga -->
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <?php if (isset($_SESSION['logat'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="profil.php">Profilul Meu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="inchirierile_mele.php">Închirierile Mele</a>
                </li>
            <?php endif; ?>
        </ul>

        <!-- Logo-ul în centru -->
        <a class="navbar-brand mx-auto" href="index.php">
            <h1>INCHIRERI AUTO</h1>
        </a>

        <!-- Butoanele din dreapta -->
        <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
            <?php if (isset($_SESSION['logat'])): ?>
                <?php if ($_SESSION['este_admin']): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="cereri_inchiriere.php">Cereri Închiriere</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="adauga_masina.php">Adaugă Mașină</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="delogare.php">Deconectare</a>
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
