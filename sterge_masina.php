<?php
session_start();
include 'configurare_bd.php';

if (!isset($_SESSION['este_admin']) || !$_SESSION['este_admin']) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $idMasina = $conn->real_escape_string($_GET['id']);

    // Începe o tranzacție
    $conn->begin_transaction();

    try {
        // Șterge mai întâi toate cererile de închiriere asociate cu această mașină
        $stmt = $conn->prepare("DELETE FROM CereriInchiriere WHERE id_masina = ?");
        $stmt->bind_param("i", $idMasina);
        $stmt->execute();
        $stmt->close();

        // Acum șterge mașina
        $stmt = $conn->prepare("DELETE FROM Masini WHERE id = ?");
        $stmt->bind_param("i", $idMasina);
        if ($stmt->execute()) {
            // Confirmă tranzacția
            $conn->commit();
            echo "Mașina și toate cererile de închiriere asociate au fost șterse cu succes.";
        } else {
            throw new Exception("Eroare la ștergerea mașinii: " . $stmt->error);
        }
        $stmt->close();
    } catch (Exception $e) {
        // Anulează tranzacția
        $conn->rollback();
        echo $e->getMessage();
    }
} else {
    echo "Solicitare invalidă.";
}

$conn->close();
header('Location: index.php'); 
exit();
?>
