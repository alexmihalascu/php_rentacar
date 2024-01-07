<?php
session_start();
include 'configurare_bd.php';

if (!isset($_SESSION['este_admin']) || !$_SESSION['este_admin']) {
    header('Location: index.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$idMasina = $conn->real_escape_string($_GET['id']);

// Procesează formularul când este trimis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $conn->prepare("UPDATE Masini SET marca = ?, model = ?, an = ?, pret_inchiriere = ?, motorizare = ?, consum = ?, transmisie = ? WHERE id = ?");
    $stmt->bind_param("ssidsisi", $_POST['marca'], $_POST['model'], $_POST['an'], $_POST['pret_inchiriere'], $_POST['motorizare'], $_POST['consum'], $_POST['transmisie'], $idMasina);

    if ($stmt->execute()) {
        // Procesare și înlocuire imagini
        $folderMasina = "img/poze_masini/masina_$idMasina";
        for ($i = 1; $i <= 5; $i++) {
            if (isset($_FILES["poza$i"]) && $_FILES["poza$i"]['error'] == 0) {
                $numeFisier = "poza{$i}_masina_$idMasina.jpg";
                $caleSalvare = "$folderMasina/$numeFisier";
                move_uploaded_file($_FILES["poza$i"]['tmp_name'], $caleSalvare);
            }
        }

        echo "Informațiile mașinii au fost actualizate cu succes.";
    } else {
        echo "Eroare la actualizarea mașinii: " . $stmt->error;
    }
    $stmt->close();
}

// Cod pentru preluarea datelor existente ale mașinii
$stmt = $conn->prepare("SELECT * FROM Masini WHERE id = ?");
$stmt->bind_param("i", $idMasina);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $masina = $result->fetch_assoc();
} else {
    echo "Mașina nu a fost găsită.";
    exit();
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editează Mașina - Închirieri Auto</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-4">
        <h2>Editează Mașina</h2>
        <form action="editeaza_masina.php?id=<?php echo $idMasina; ?>" method="post">
            <div class="mb-3">
                <label for="marca" class="form-label">Marca</label>
                <input type="text" class="form-control" id="marca" name="marca" value="<?php echo $masina['marca']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="model" class="form-label">Model</label>
                <input type="text" class="form-control" id="model" name="model" value="<?php echo $masina['model']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="an" class="form-label">An de Fabricație</label>
                <input type="number" class="form-control" id="an" name="an" value="<?php echo $masina['an']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="pret_inchiriere" class="form-label">Preț Închiriere (RON/zi)</label>
                <input type="number" class="form-control" id="pret_inchiriere" name="pret_inchiriere" value="<?php echo $masina['pret_inchiriere']; ?>" required>
            </div>
            <div class="mb-3">
            <label for="motorizare" class="form-label">Motorizare</label>
            <select class="form-control" id="motorizare" name="motorizare" required>
                <option value="Diesel" <?php echo $masina['motorizare'] == 'Diesel' ? 'selected' : ''; ?>>Diesel</option>
                <option value="Benzina" <?php echo $masina['motorizare'] == 'Benzina' ? 'selected' : ''; ?>>Benzină</option>
                <option value="Hibrid" <?php echo $masina['motorizare'] == 'Hibrid' ? 'selected' : ''; ?>>Hibrid</option>
                <option value="Electric" <?php echo $masina['motorizare'] == 'Electric' ? 'selected' : ''; ?>>Electric</option>
            </select>
            </div>
            <div class="mb-3">
                <label for="consum" class="form-label">Consum (l/100km)</label>
                <input type="text" class="form-control" id="consum" name="consum" value="<?php echo $masina['consum']; ?>">
            </div>
            <div class="mb-3">
                <label for="transmisie" class="form-label">Transmisie</label>
                <input type="text" class="form-control" id="transmisie" name="transmisie" value="<?php echo $masina['transmisie']; ?>">
            </div>
            <!-- Câmpuri pentru încărcarea de noi imagini -->
            <?php for ($i = 1; $i <= 5; $i++): ?>
            <div class="mb-3">
                <label for="poza<?php echo $i; ?>" class="form-label">Imagine <?php echo $i; ?></label>
                <input type="file" class="form-control" name="poza<?php echo $i; ?>">
            </div>
            <?php endfor; ?>
            <button type="submit" class="btn btn-primary">Salvează Modificările</button>
        </form>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
