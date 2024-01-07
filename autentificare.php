<?php
session_start();
include 'configurare_bd.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $parolaIntrodusa = $_POST['password']; 

    $sql = "SELECT * FROM Utilizatori WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($parolaIntrodusa, $row['parola'])) {
            $_SESSION['logat'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['este_admin'] = $row['este_admin']; // Setează variabila de sesiune este_admin

            header('Location: index.php');
            exit();
        } else {
            echo "<p>Parolă incorectă</p>";
        }
    } else {
        echo "<p>Nume de utilizator inexistent</p>";
    }
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autentificare - Închirieri Auto</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
<div class="bg-light py-3 py-md-5">
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-12 col-md-11 col-lg-8 col-xl-7 col-xxl-6">
        <div class="bg-white p-4 p-md-5 rounded shadow-sm">
          <div class="row">
            <div class="col-12">
              <div class="text-center mb-5">
                <h1>Autentificare</h1>
                <img src = "img/iconite/logo.jpg" width="300" height="300" alt="Logo Închirieri Auto">
              </div>
            </div>
          </div>
          <form action="autentificare.php" method="post"> <!-- Schimbă action cu scriptul PHP corespunzător -->
            <div class="row gy-3 gy-md-4 overflow-hidden">
              <div class="col-12">
                <label for="username" class="form-label">Nume utilizator <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text">
                    <img src="img/iconite/user.png" width="24" height="24" alt="Icon nume utilizator">
                  </span>
                  <input type="text" class="form-control" name="username" id="username" required>
                </div>
              </div>
              <div class="col-12">
                <label for="password" class="form-label">Parolă <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text">
                    <img src="img/iconite/lock.png" width="24" height="24" alt="Icon parola">
                  </span>
                  <input type="password" class="form-control" name="password" id="password" required>
                </div>
              </div>
              <div class="col-12">
                <div class="d-grid">
                  <button class="btn btn-primary btn-lg" type="submit">Autentificare</button>
                </div>
              </div>
            </div>
          </form>
          <div class="row">
            <div class="col-12">
              <hr class="mt-5 mb-4 border-secondary-subtle">
              <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-center">
                <a href="inregistrare.php" class="link-secondary text-decoration-none">Creează un cont nou</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
