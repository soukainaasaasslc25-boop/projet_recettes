<?php
require_once 'db.php';

// Récupérer toutes les recettes avec catégorie
function getAllRecipes($pdo) {
    $sql = "SELECT r.*, c.name as category_name 
            FROM recipes r 
            LEFT JOIN categories c ON r.category_id = c.id 
            ORDER BY r.created_at DESC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Récupérer une recette par ID
function getRecipeById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM recipes WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Récupérer toutes les catégories
function getAllCategories($pdo) {
    $stmt = $pdo->query("SELECT * FROM categories ORDER BY name");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function addRecipe($pdo, $name, $prep_time, $category_id, $image = null) {
    $stmt = $pdo->prepare("INSERT INTO recipes (name, prep_time, category_id, image) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$name, $prep_time, $category_id, $image]);
}


function updateRecipe($pdo, $id, $name, $prep_time, $category_id, $image = null) {
    if ($image) {
        $stmt = $pdo->prepare("UPDATE recipes SET name=?, prep_time=?, category_id=?, image=?, edited_at=NOW() WHERE id=?");
        return $stmt->execute([$name, $prep_time, $category_id, $image, $id]);
    } else {
        $stmt = $pdo->prepare("UPDATE recipes SET name=?, prep_time=?, category_id=?, edited_at=NOW() WHERE id=?");
        return $stmt->execute([$name, $prep_time, $category_id, $id]);
    }
}

// Supprimer une recette
function deleteRecipe($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM recipes WHERE id = ?");
    return $stmt->execute([$id]);
}
?>