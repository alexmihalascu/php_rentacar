<?php
session_start();
include 'configurare_bd.php';
include 'navbar.php';

if (!isset($_SESSION['logat'])) {
    header('Location: autentificare.php');
    exit();
}

$whereClauses = [];
$params = [];
$types = "";

if (!empty($_GET['transmisie']) && in_array($_GET['transmisie'], ['Automata', 'Manuala'])) {
    $whereClauses[] = "transmisie = ?";
    $params[] = $_GET['transmisie'];
    $types .= "s";
}

if (!empty($_GET['pret_max'])) {
    $whereClauses[] = "pret_inchiriere <= ?";
    $params[] = $_GET['pret_max'];
    $types .= "i";
}

if (!empty($_GET['motorizare']) && in_array($_GET['motorizare'], ['Benzina', 'Diesel', 'Hibrid', 'Electric'])) {
    $whereClauses[] = "motorizare = ?";
    $params[] = $_GET['motorizare'];
    $types .= "s";
}

$sql = "SELECT * FROM Masini";
if (!empty($whereClauses)) {
    $sql .= " WHERE " . join(" AND ", $whereClauses);
}

$orderClause = "";
if (!empty($_GET['sortare'])) {
    switch ($_GET['sortare']) {
        case 'an_asc':
            $orderClause = "ORDER BY an ASC";
            break;
        case 'an_desc':
            $orderClause = "ORDER BY an DESC";
            break;
        case 'pret_asc':
            $orderClause = "ORDER BY pret_inchiriere ASC";
            break;
        case 'pret_desc':
            $orderClause = "ORDER BY pret_inchiriere DESC";
            break;
    }
}

$sql .= " " . $orderClause;

$stmt = $conn->prepare($sql);
if ($types) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

$conn->close();
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
    <form action="index.php" method="get">
    <div class="form-group">
        <label for="transmisie">Transmisie:</label>
        <select class="form-control" name="transmisie" id="transmisie">
    <option value="Toate" <?php if(isset($_GET['transmisie']) && $_GET['transmisie'] == 'toate') echo 'selected'; ?>>Toate</option>
    <option value="Automata" <?php if(isset($_GET['transmisie']) && $_GET['transmisie'] == 'Automata') echo 'selected'; ?>>Automată</option>
    <option value="Manuala" <?php if(isset($_GET['transmisie']) && $_GET['transmisie'] == 'Manuala') echo 'selected'; ?>>Manuală</option>
</select>
<div class="form-group">
    <label for="motorizare">Motorizare:</label>
    <select class="form-control" name="motorizare" id="motorizare">
        <option value="">Toate</option>
        <option value="Benzina" <?php if(isset($_GET['motorizare']) && $_GET['motorizare'] == 'Benzina') echo 'selected'; ?>>Benzină</option>
        <option value="Diesel" <?php if(isset($_GET['motorizare']) && $_GET['motorizare'] == 'Diesel') echo 'selected'; ?>>Diesel</option>
        <option value="Hibrid" <?php if(isset($_GET['motorizare']) && $_GET['motorizare'] == 'Hibrid') echo 'selected'; ?>>Hibrid</option>
        <option value="Electric" <?php if(isset($_GET['motorizare']) && $_GET['motorizare'] == 'Electric') echo 'selected'; ?>>Electric</option>
    </select>
</div>
<div class="form-group">
<label for="motorizare">Filtrare după:</label>
<select class="form-control" name="sortare" id="sortare">
    <option value="an_asc" <?php if(isset($_GET['sortare']) && $_GET['sortare'] == 'an_asc') echo 'selected'; ?>>An (Crescător)</option>
    <option value="an_desc" <?php if(isset($_GET['sortare']) && $_GET['sortare'] == 'an_desc') echo 'selected'; ?>>An (Descrescător)</option>
    <option value="pret_asc" <?php if(isset($_GET['sortare']) && $_GET['sortare'] == 'pret_asc') echo 'selected'; ?>>Preț (Crescător)</option>
    <option value="pret_desc" <?php if(isset($_GET['sortare']) && $_GET['sortare'] == 'pret_desc') echo 'selected'; ?>>Preț (Descrescător)</option>
</select>
</div>
    </div>
    <div class="form-group mb-3">
        <label for="pret_max">Preț maxim:</label>
        <input type="number" class="form-control" name="pret_max" id="pret_max">
    </div>
    <button type="submit" class="btn btn-primary">Filtrează</button>
</form>

<div class="row">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $idMasina = $row["id"];
                $folderMasina = "img/poze_masini/masina_$idMasina";
                $pozeMasina = scandir($folderMasina);
                $pozeMasina = array_slice($pozeMasina, 2);
                $primaImagine = count($pozeMasina) > 0 ? "$folderMasina/".$pozeMasina[0] : "img/iconite/avatar.jpg"; // Imagine implicită dacă nu există

                echo "<div class='col-md-6 mb-4'>";
                echo "<div class='card'>";
                echo "<a href='masina.php?id=" . $row["id"] . "' class='card-img-link'>";
                echo "<img src='$primaImagine' class='card-img-top' alt='Imagine Masina'>";
                echo "</a>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>" . $row["marca"]. " " . $row["model"]. "</h5>";
                echo "<p class='card-text'>An: " . $row["an"]. "<br>";
                echo "Transmisie: " . $row["transmisie"]. "<br>";
                echo "Preț: " . $row["pret_inchiriere"]. " RON / zi</p>";
                echo "<a href='inchiriaza_masina.php?id_masina=" . $row["id"] . "' class='btn btn-primary'>Închiriază</a>";
                echo "</div></div></div>";
            }
        } else {
            echo "<p class='col-12'>Nu sunt mașini disponibile.</p>";
        }
        ?>
    </div>
</div>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
