<?php
$host = 'localhost';
$db = 'books';
$user = 'root';
$pass = '';

$dsn = "mysql:host=$host;dbname=$db";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
$pdo = new PDO($dsn, $user, $pass, $options);

$titolo = $_POST['Titolo'];
$autore = $_POST['Autore'];
$annoPubblicazione = $_POST['AnnoPubblicazione'];
$genere = $_POST['Genere'];
$immagine = $_POST['Immagine'];

// INSERT
$stmt = $pdo->prepare("INSERT INTO books (titolo, autore, anno_pubblicazione,genere,img) VALUES (:titolo, :autore, :anno_pubblicazione,:genere, :img)");
$stmt->execute([
    'titolo' => $titolo,
    'autore' => $autore,
    'anno_pubblicazione' => $annoPubblicazione,
    'genere' => $genere,
    'img' => $immagine
]);
header('Location: index.php');