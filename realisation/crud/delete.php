<?php 
require_once '../functions.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    if (deleteRecipe($pdo, $id)) {
        header("Location: read.php?success=deleted");
        exit();
    } else {
        die("Erreur lors de la suppression de la recette.");
    }
} else {
    die("ID non valide.");
}
?>