<?php

require_once 'db.php';

function obtenirProduits($pdo) {
    
   
    $stmt = $pdo->query("SELECT * FROM Products");
    
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function ajouterProduit($pdo, $name, $price, $quantity) {
    $stmt = $pdo->prepare("INSERT INTO Products (name, price, quantity) VALUES (?, ?, ?)");
    return $stmt->execute([$name, $price, $quantity]);
}


function modifierProduit($pdo, $id, $name, $price, $quantity) {
    $stmt = $pdo->prepare("UPDATE Products SET name = ?, price = ?, quantity = ? WHERE id = ?");
    return $stmt->execute([$name, $price, $quantity, $id]);
}


function supprimerProduit($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM Products WHERE id = ?");
    return $stmt->execute([$id]);
}

function obtenirProduitParId($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM Products WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
