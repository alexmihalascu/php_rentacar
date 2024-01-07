<?php
session_start();
include 'configurare_bd.php';
include 'navbar.php';

// Verifică dacă utilizatorul este logat
if (!isset($_SESSION['logat'])) {
    header('Location: autentificare.php');
    exit();
}

$sql = "SELECT * FROM Masini";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Închirieri Auto</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2>Mașini Disponibile pentru Închiriere</h2>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class='card mb-3'><div class='card-body'>";
            echo "<h5 class='card-title'>" . $row["marca"]. " " . $row["model"]. "</h5>";
            echo "<p class='card-text'>An: " . $row["an"]. " - Preț: " . $row["pret_inchiriere"]. " RON</p>";
            echo "<p class='card-text'>Motorizare: " . $row["motorizare"]. " - Consum: " . $row["consum"]. " l/100km</p>";
            echo "<p class='card-text'>Transmisie: " . $row["transmisie"]. "</p>";
            $idMasina = $row["id"];
            $folderMasina = "img/poze_masini/masina_$idMasina";
            $pozeMasina = scandir($folderMasina);
            $pozeMasina = array_slice($pozeMasina, 2);
            if (count($pozeMasina) > 0) {
                echo "<div id='carouselMasina$idMasina' class='carousel slide' data-bs-ride='carousel'>";
                echo "<div class='carousel-inner'>";
                foreach ($pozeMasina as $index => $pozaMasina) {
                    $active = $index == 0 ? "active" : "";
                    echo "<div class='carousel-item $active'>";
                    echo "<img src='$folderMasina/$pozaMasina' class='d-block w-10% h-10%' alt='Poza $index'>";
                    echo "</div>";
                }
                echo "</div>";
                echo "<button class='carousel-control-prev' type='button' data-bs-target='#carouselMasina$idMasina' data-bs-slide='prev'>";
                echo "<span class='carousel-control-prev-icon' aria-hidden='true'></span>";
                echo "<span class='visually-hidden'>Previous</span>";
                echo "</button>";
                echo "<button class='carousel-control-next' type='button' data-bs-target='#carouselMasina$idMasina' data-bs-slide='next'>";
                echo "<span class='carousel-control-next-icon' aria-hidden='true'></span>";
                echo "<span class='visually-hidden'>Next</span>";
                echo "</button>";
                echo "</div>";
            }
            
            echo "<a href='inchiriaza_masina.php?id=" . $row["id"]. "' class='btn btn-primary'>Închiriază</a>";

            echo "</div></div>";
        }
    } else {
        echo "<p>Nu sunt mașini disponibile.</p>";
    }
    $conn->close();
    ?>
</div>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
