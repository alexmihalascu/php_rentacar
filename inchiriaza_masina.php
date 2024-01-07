<?php
session_start();
include 'configurare_bd.php';

// Verifică dacă utilizatorul este logat
if (!isset($_SESSION['logat'])) {
    header('Location: autentificare.php');
    exit();
}

$dataInceput = '';
$dataSfarsit = '';
$mesaj = '';
$idUtilizator = $_SESSION['id_utilizator'];
$pretPeZi = 0;
$idMasinaSelectata = isset($_GET['id_masina']) ? $_GET['id_masina'] : '';

// Obține prețul pe zi pentru mașina selectată, dacă este cazul
if ($idMasinaSelectata) {
    $stmt = $conn->prepare("SELECT pret_inchiriere FROM Masini WHERE id = ?");
    $stmt->bind_param("i", $idMasinaSelectata);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $pretPeZi = $row['pret_inchiriere'];
    }
    $stmt->close();
}

// Procesează formularul când este trimis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idMasina = $_POST['id_masina'];
    $dataInceput = $_POST['data_inceput'];
    $dataSfarsit = $_POST['data_sfarsit'];

    // Obține pretul pe zi pentru mașina selectată
    $stmt = $conn->prepare("SELECT pret_inchiriere FROM Masini WHERE id = ?");
    $stmt->bind_param("i", $idMasina);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $pretPeZi = $row['pret_inchiriere'];
    }
    $stmt->close();

    // Calculul costului total
    $dataStart = new DateTime($dataInceput);
    $dataEnd = new DateTime($dataSfarsit);
    $interval = $dataStart->diff($dataEnd);
    $numarZile = $interval->days + 1;
    $costTotal = $numarZile * $pretPeZi;

    // Inserează cererea în baza de date
    $stmt = $conn->prepare("INSERT INTO CereriInchiriere (id_utilizator, id_masina, data_inceput, data_sfarsit, status, cost_total) VALUES (?, ?, ?, ?, 'in asteptare', ?)");
    $stmt->bind_param("iissd", $idUtilizator, $idMasina, $dataInceput, $dataSfarsit, $costTotal);
    if ($stmt->execute()) {
        $mesaj = "Cererea de închiriere a fost trimisă. Cost total: $costTotal RON.";
        echo "<script>setTimeout(function(){ window.location.href = 'index.php'; }, 2000);</script>";
    } else {
        $mesaj = "Eroare la trimiterea cererii: " . $stmt->error;
    }
    $stmt->close();
}

// Selectează mașinile disponibile pentru închiriere
$sqlMasini = "SELECT id, marca, model, pret_inchiriere FROM Masini";
$masini = $conn->query($sqlMasini);

$conn->close();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Închiriază o Mașină - Închirieri Auto</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-4">
        <h2>Închiriază o Mașină</h2>
        <?php if (isset($mesaj)): ?>
            <p><?php echo $mesaj; ?></p>
        <?php endif; ?>
        <form action="inchiriaza_masina.php" method="post">
            <div class="mb-3">
                <label for="id_masina" class="form-label">Mașina aleasă:</label>
                <select class="form-control" id="id_masina" name="id_masina" <?php echo $idMasinaSelectata ? 'disabled' : ''; ?> required>
                    <?php while($row = $masini->fetch_assoc()): ?>
                        <option value="<?php echo $row['id']; ?>" <?php if($row['id'] == $idMasinaSelectata) echo 'selected'; ?>>
                            <?php echo $row['marca'] . ' ' . $row['model']; ?> - <?php echo $row['pret_inchiriere']; ?> RON/zi
                        </option>
                    <?php endwhile; ?>
                </select>
                <?php if($idMasinaSelectata): ?>
                    <input type="hidden" name="id_masina" value="<?php echo $idMasinaSelectata; ?>">
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="data_inceput" class="form-label">Data Început</label>
                <input type="date" class="form-control" id="data_inceput" name="data_inceput" required>
            </div>
            <div class="mb-3">
                <label for="data_sfarsit" class="form-label">Data Sfârșit</label>
                <input type="date" class="form-control" id="data_sfarsit" name="data_sfarsit" required>
            </div>
            <div id="cost_total" class="mt-3"><?php if ($pretPeZi && $dataInceput && $dataSfarsit) { echo 'Cost total: ' . $costTotal . ' RON'; } ?></div>
            <button type="submit" class="btn btn-primary">Trimite Cererea</button>
        </form>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dataInceputElem = document.getElementById('data_inceput');
            const dataSfarsitElem = document.getElementById('data_sfarsit');
            const costTotalElem = document.getElementById('cost_total');

            const pretPeZi = <?php echo json_encode($pretPeZi); ?>;

            function updateCostTotal() {
                const dataInceput = new Date(dataInceputElem.value);
                const dataSfarsit = new Date(dataSfarsitElem.value);
                const timpDiff = dataSfarsit.getTime() - dataInceput.getTime();
                const numarZile = Math.ceil(timpDiff / (1000 * 3600 * 24)) + 1;
                const pretPeZi = <?php echo json_encode($pretPeZi); ?>;

                if (!isNaN(numarZile) && numarZile > 0) {
                    const costTotal = numarZile * pretPeZi;
                    costTotalElem.textContent = 'Cost total: ' + costTotal + ' RON';
                } else {
                    costTotalElem.textContent = '';
                }
            }

            dataInceputElem.addEventListener('change', updateCostTotal);
            dataSfarsitElem.addEventListener('change', updateCostTotal);
        });
    </script>
</body>
</html>
