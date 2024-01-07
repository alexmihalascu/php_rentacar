<?php
session_start();
include 'configurare_bd.php';
include 'navbar.php';

// Verifică dacă utilizatorul este logat și are un ID de utilizator setat
if (!isset($_SESSION['logat']) || !isset($_SESSION['id_utilizator'])) {
    header('Location: autentificare.php');
    exit();
}

$idUtilizator = $_SESSION['id_utilizator'];

// Definirea interogării SQL pentru a recupera închirierile utilizatorului
$sql = "SELECT Masini.marca, Masini.model, CereriInchiriere.data_inceput, CereriInchiriere.data_sfarsit, CereriInchiriere.status 
        FROM CereriInchiriere 
        JOIN Masini ON CereriInchiriere.id_masina = Masini.id 
        WHERE CereriInchiriere.id_utilizator = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idUtilizator);
$stmt->execute();
$result = $stmt->get_result();

$conn->close();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Închirierile Mele - Închirieri Auto</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5 mb-5">
    <h2>Închirierile Mele</h2>
    <?php if ($result->num_rows > 0): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Marca</th>
                    <th>Model</th>
                    <th>Data Început</th>
                    <th>Data Sfârșit</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['marca']; ?></td>
                        <td><?php echo $row['model']; ?></td>
                        <td><?php echo $row['data_inceput']; ?></td>
                        <td><?php echo $row['data_sfarsit']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nu ai efectuat nicio închiriere.</p>
    <?php endif; ?>
</div>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
