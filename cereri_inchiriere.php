<?php
session_start();
include 'configurare_bd.php';

if (!isset($_SESSION['este_admin']) || !$_SESSION['este_admin']) {
    header('Location: index.php');
    exit();
}

$sql = "SELECT CereriInchiriere.id, Utilizatori.username, Utilizatori.nume, Utilizatori.prenume, Utilizatori.cnp, Utilizatori.data_nasterii, Utilizatori.numar_permis, Masini.marca, Masini.model, CereriInchiriere.data_inceput, CereriInchiriere.data_sfarsit, CereriInchiriere.status FROM CereriInchiriere JOIN Utilizatori ON CereriInchiriere.id_utilizator = Utilizatori.id JOIN Masini ON CereriInchiriere.id_masina = Masini.id";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cereri de Închiriere - Închirieri Auto</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-4">
        <h2>Cereri de Închiriere</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID Cerere</th>
                    <th>Utilizator</th>
                    <th>Nume</th>
                    <th>CNP</th>
                    <th>Data Nașterii</th>
                    <th>Număr Permis</th>
                    <th>Mașină</th>
                    <th>Data Început</th>
                    <th>Data Sfârșit</th>
                    <th>Status</th>
                    <th>Acțiuni</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): 
                    $dataNasteriiFormatata = (new DateTime($row['data_nasterii']))->format('d.m.Y');
                ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['nume'] . " " . $row['prenume']; ?></td>
                    <td><?php echo $row['cnp']; ?></td>
                    <td><?php echo $dataNasteriiFormatata; ?></td>
                    <td><?php echo $row['numar_permis']; ?></td>
                    <td><?php echo $row['marca'] . " " . $row['model']; ?></td>
                    <td><?php echo $row['data_inceput']; ?></td>
                    <td><?php echo $row['data_sfarsit']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td>
                        <a href="actualizeaza_status.php?id=<?php echo $row['id']; ?>&status=aprobat" class="btn btn-success">Aprobă</a>
                        <a href="actualizeaza_status.php?id=<?php echo $row['id']; ?>&status=respins" class="btn btn-danger">Respinge</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
