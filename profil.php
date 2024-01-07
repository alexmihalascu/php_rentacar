<?php
session_start();
include 'configurare_bd.php';
include 'navbar.php';

if (!isset($_SESSION['logat'])) {
    header('Location: autentificare.php');
    exit();
}

$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usernameNou = $conn->real_escape_string($_POST['username']);
    $parolaNoua = !empty($_POST['parola']) ? password_hash($_POST['parola'], PASSWORD_DEFAULT) : '';
    $nume = $conn->real_escape_string($_POST['nume']);
    $prenume = $conn->real_escape_string($_POST['prenume']);
    $cnp = $conn->real_escape_string($_POST['cnp']);
    $dataNasterii = $conn->real_escape_string($_POST['data_nasterii']);
    $numarPermis = $conn->real_escape_string($_POST['numar_permis']);

    $usernameVechi = $_SESSION['username'];

    $sql = "UPDATE Utilizatori SET username = ?, nume = ?, prenume = ?, cnp = ?, data_nasterii = ?, numar_permis = ?";
    if($parolaNoua) {
        $sql .= ", parola = ?";
    }
    $sql .= " WHERE username = ?";

    $stmt = $conn->prepare($sql);
    $parolaNoua ? $stmt->bind_param("ssssssss", $usernameNou, $nume, $prenume, $cnp, $dataNasterii, $numarPermis, $parolaNoua, $usernameVechi) : $stmt->bind_param("sssssss", $usernameNou, $nume, $prenume, $cnp, $dataNasterii, $numarPermis, $usernameVechi);

    if ($stmt->execute()) {
        $_SESSION['username'] = $usernameNou;
        $msg = "Profil actualizat cu succes.";
    } else {
        $msg = "Eroare: " . $stmt->error;
    }
    $stmt->close();
}

// Preia datele actuale ale utilizatorului pentru a le afișa în formular
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT * FROM Utilizatori WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$conn->close();
?>


<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editare Profil - Închirieri Auto</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
<div class="container rounded bg-white mt-5 mb-5">
    <div class="row">
        <div class="col-md-2 border-right d-flex align-items-center">
        </div>
        <div class="col-md-9">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Setări Profil</h4>
                </div>
                <?php if ($msg): ?>
                    <p><?php echo $msg; ?></p>
                <?php endif; ?>
                <form action="profil.php" method="post">
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label class="labels">Nume de utilizator</label>
                            <input type="text" class="form-control" name="username" value="<?php echo $row['username']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="labels">Parolă Nouă (lasă gol dacă nu vrei să schimbi)</label>
                            <input type="password" class="form-control" name="parola">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label class="labels">Nume</label>
                            <input type="text" class="form-control" name="nume" value="<?php echo $row['nume']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="labels">Prenume</label>
                            <input type="text" class="form-control" name="prenume" value="<?php echo $row['prenume']; ?>">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label class="labels">CNP</label>
                            <input type="text" class="form-control" name="cnp" value="<?php echo $row['cnp']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="labels">Data Nașterii</label>
                            <input type="date" class="form-control" name="data_nasterii" value="<?php echo $row['data_nasterii']; ?>">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class="labels">Număr Permis</label>
                            <input type="text" class="form-control" name="numar_permis" value="<?php echo $row['numar_permis']; ?>">
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <button class="btn btn-primary profile-button" type="submit">Salvează Profilul</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
