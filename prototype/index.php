<?php 
require_once 'functions.php'; 


$listeProduits = obtenirProduits($pdo);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Produits - GoldenFork</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container">
        <div class="header-section">
            <header>
                <h1>Liste des Produits</h1>
            </header>
            <a href="add.php" class="btn-add">Ajouter un nouveau produit</a>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom du Produit</th>
                        <th>Prix (DH)</th>
                        <th>Quantité</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($listeProduits)): ?>
                        <?php foreach ($listeProduits as $produit): ?>
                            <tr>
                                <td><?= $produit['id'] ?></td>
                                <td><?= htmlspecialchars($produit['name']) ?></td>
                                <td class="price"><?= number_format($produit['price'], 2) ?> DH</td>
                                <td><?= $produit['quantity'] ?></td>
                                <td class="actions">
                                    <a href="edit.php?id=<?= $produit['id'] ?>" class="btn-edit">Modifier</a>
                                    <a href="delete.php?id=<?= $produit['id'] ?>" 
                                       class="btn-delete" 
                                       onclick="return confirm('Voulez-vous vraiment supprimer ce produit ?')">
                                        Supprimer
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="no-data">Aucun produit trouvé dans la base de données.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>