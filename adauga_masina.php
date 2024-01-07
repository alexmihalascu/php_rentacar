<?php
session_start();
include 'configurare_bd.php';
include 'navbar.php';

if (!isset($_SESSION['logat']) || $_SESSION['este_admin'] != 1) {
    header('Location: autentificare.php');
    exit();
}

$sqlClase = "SELECT * FROM ClaseMasini";
$resultClase = $conn->query($sqlClase);

$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $marca = $conn->real_escape_string($_POST['marca']);
    $model = $conn->real_escape_string($_POST['model']);
    $an = $conn->real_escape_string($_POST['an']);
    $pretInchiriere = $conn->real_escape_string($_POST['pret_inchiriere']);
    $clasaId = $conn->real_escape_string($_POST['clasa_id']);
    $motorizare = $conn->real_escape_string($_POST['motorizare']);
    $consum = $conn->real_escape_string($_POST['consum']);
    $transmisie = $conn->real_escape_string($_POST['transmisie']);

    $sql = "INSERT INTO Masini (marca, model, an, pret_inchiriere, clasa_id, motorizare, consum, transmisie) VALUES ('$marca', '$model', '$an', '$pretInchiriere', '$clasaId', '$motorizare', '$consum', '$transmisie')";
    if ($conn->query($sql) === TRUE) {
        $idMasina = $conn->insert_id;
        $folderMasina = "img/poze_masini/masina_$idMasina";
        if (!file_exists($folderMasina)) {
            mkdir($folderMasina, 0777, true);
        }

        // Procesare și salvare imagini
        for ($i = 1; $i <= 5; $i++) {
            if (isset($_FILES["poza$i"]) && $_FILES["poza$i"]['error'] == 0) {
                $numeFisier = "poza{$i}_masina_$idMasina.jpg";
                $caleSalvare = "$folderMasina/$numeFisier";
                move_uploaded_file($_FILES["poza$i"]['tmp_name'], $caleSalvare);
            }
        }

        $msg = "Mașină adăugată cu succes.";
    } else {
        $msg = "Eroare: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adaugă Mașină - Închirieri Auto</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
<div class="container rounded bg-white mt-5 mb-5">
    <h2>Adaugă o Mașină Nouă</h2>
    <?php if ($msg): ?>
        <p><?php echo $msg; ?></p>
    <?php endif; ?>
    <form action="adauga_masina.php" method="post" enctype="multipart/form-data">
        <div class="p-3 py-5">
            <div class="row mt-2">
                <div class="col-md-6">
                    <label class="labels">Marca</label>
                    <input type="text" class="form-control" name="marca" required>
                </div>
                <div class="col-md-6">
                    <label class="labels">Model</label>
                    <input type="text" class="form-control" name="model" required>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <label class="labels">An</label>
                    <input type="number" class="form-control" name="an" required>
                </div>
                <div class="col-md-6">
                    <label class="labels">Preț Închiriere</label>
                    <input type="text" class="form-control" name="pret_inchiriere" required>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <label class="labels">Clasa mașinii</label>
                    <select class="form-control" name="clasa_id">
                    <?php while($rowClasa = $resultClase->fetch_assoc()): ?>
                        <option value="<?php echo $rowClasa['idClasa']; ?>">
                            <?php echo $rowClasa['numeClasa']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                </div>
                <div class="col-md-6">
                    <label class="labels">Motorizare</label>
                    <input type="text" class="form-control" name="motorizare">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <label class="labels">Consum</label>
                    <input type="text" class="form-control" name="consum">
                </div>
                <div class="col-md-6">
                    <label class="labels">Transmisie</label>
                    <input type="text" class="form-control" name="transmisie">
                </div>
            </div>
            <!-- adaugare imagini -->
            <?php for ($i = 1; $i <= 5; $i++): ?>
            <div class="col-md-12">
                <label class="labels">Imagine <?php echo $i; ?></label>
                <input type="file" class="form-control" name="poza<?php echo $i; ?>">
            </div>
             <?php endfor; ?>
            <div class="mt-5 text-center">
                <button class="btn btn-primary profile-button" type="submit">Adaugă Mașina</button>
            </div>
        </div>
    </form>
</div>
    </form>
</div>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
