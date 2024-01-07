<?php
session_start();
include 'configurare_bd.php';

if (!isset($_SESSION['este_admin']) || !$_SESSION['este_admin']) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id']) && isset($_GET['status'])) {
    $idCerere = $conn->real_escape_string($_GET['id']);
    $noulStatus = $conn->real_escape_string($_GET['status']);

    $stmt = $conn->prepare("UPDATE CereriInchiriere SET status=? WHERE id=?");
    $stmt->bind_param("si", $noulStatus, $idCerere);
    if ($stmt->execute()) {
        echo "Statusul cererii a fost actualizat.";
    } else {
        echo "Eroare la actualizarea statusului: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Solicitare invalidă.";
}

$conn->close();
header('Location: cereri_inchiriere.php'); 
exit();
?>