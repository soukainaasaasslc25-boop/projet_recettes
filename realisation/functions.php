<?php
//  recuperer  tout les recettes avec sn  categorie
function getallcategorie($pdo){
    $sql="SELECT r.*, c.name as category_name 
            FROM recipes r 
            LEFT JOIN categories c ON r.category_id = c.id 
            ORDER BY r.created_at DESC";
    $stmt=$pdo->query($sql);
   return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// recuperer ALL by id
function getRecepByID($pdo,$id){
    $stmt=$pdo->prepare("SELECT * FROM recipes WHERE id =? ");
    $stmt->execute([$id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

// Récupérer toutes les catégories
function getCategoryById($pdo){
    $stmt = $pdo->query("SELECT * FROM categories ORDER BY name");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Ajouter une recette
function addRecipe($pdo, $name, $prep_time, $category_id, $image = null) {
    $stmt = $pdo->prepare("INSERT INTO recipes (name, prep_time, category_id, image) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$name, $prep_time, $category_id, $image]);
}

// Supprimer une recette
function deleteRecipe($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM recipes WHERE id = ?");
    return $stmt->execute([$id]);
}




