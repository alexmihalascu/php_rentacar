<?php
$host = 'localhost';
$utilizator_bd = 'root';
$parola_bd = '';
$nume_bd = 'InchirieriAuto';

// Crearea conexiunii
$conn = new mysqli($host, $utilizator_bd, $parola_bd, $nume_bd);

// Verificarea conexiunii
if ($conn->connect_error) {
    die("Conexiunea a eșuat: " . $conn->connect_error);
}
?>
