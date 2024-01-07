<?php
session_start();
include 'configurare_bd.php';
include 'navbar.php';

if (!isset($_SESSION['logat'])) {
    header('Location: autentificare.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$idMasina = $conn->real_escape_string($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM Masini WHERE id = ?");
$stmt->bind_param("i", $idMasina);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $masina = $result->fetch_assoc();
    $imaginiMasina = glob("img/poze_masini/masina_" . $masina['id'] . "/*.{jpg,png,gif}", GLOB_BRACE);
} else {
    echo "Mașina solicitată nu a fost găsită.";
    $conn->close();
    exit();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalii Mașină - <?php echo $masina['marca'] . " " . $masina['model']; ?></title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="row g-0">
                <div class="col-md-6">
                    <!-- Carousel Slider pentru Imagini -->
                    <div id="carouselMasina" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php foreach ($imaginiMasina as $index => $imagine): ?>
                                <div class="carousel-item <?php if ($index == 0) echo 'active'; ?>">
                                    <img src="<?php echo $imagine; ?>" class="d-block w-100" alt="Imagine Mașină">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselMasina" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselMasina" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <div class="col-md-6 align-self-center">
                    <!-- Detalii Mașină -->
                    <div class="card-body text-center">
                        <h5 class="card-title"><?php echo $masina['marca'] . " " . $masina['model']; ?></h5>
                        <p class="card-text">An: <?php echo $masina['an']; ?></p>
                        <p class="card-text">Preț închiriere: <?php echo $masina['pret_inchiriere']; ?> RON/zi</p>
                        <p class="card-text">Motorizare: <?php echo $masina['motorizare']; ?></p>
                        <p class="card-text">Consum: <?php echo $masina['consum']; ?> L/100km</p>
                        <p class="card-text">Transmisie: <?php echo $masina['transmisie']; ?></p>
                    </div>
                    <div class="align-self-bottom">
                        <div class="text-center">
                            <a href="inchiriaza_masina.php?id=<?php echo $masina['id']; ?>" class="btn btn-primary">Închiriază Mașina</a>
                            <?php if(isset($_SESSION['este_admin']) && $_SESSION['este_admin']): ?>
                                <br>
                                <a href="editeaza_masina.php?id=<?php echo $masina['id']; ?>" class="btn btn-secondary mt-2">Editează Mașina</a>
                                <br>
                                <a href="sterge_masina.php?id=<?php echo $masina['id']; ?>" class="btn btn-danger mt-2">Șterge Mașina</a>
                            <?php endif; ?>
                        </div>
                    </div>
        </div>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
