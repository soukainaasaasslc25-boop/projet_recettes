<?php




$host = '127.0.0.1'; 
$port = '3307';
$dbname = 'recettesDB';
$username = 'root';
$password = '';

try {
    // On ajoute port=$port dans la chaîne de caractères
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie à la base $dbname sur le port $port";
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}