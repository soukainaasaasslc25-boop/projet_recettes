<?php 
require_once 'db.php';
require_once 'functions.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    if (supprimerProduit($pdo, $id)) {
        header("Location: index.php?success=deleted");
        exit();
    } else {
        die("Erreur lors de la suppression du produit.");
    }
} else {
    die("ID non valide.");
}
?>