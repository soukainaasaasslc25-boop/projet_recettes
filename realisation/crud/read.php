<?php 
require_once '../functions.php';
$recipes = getAllRecipes($pdo);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Recettes</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Mes Recettes</h1>
        <a href="create.php" class="btn btn-add">+ Ajouter une recette</a>

        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Nom</th>
                    <th>Catégorie</th>
                    <th>Temps de prép.</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($recipes as $r): ?>
                <tr>
                    <td>
                        <?php if($r['image']): ?>
                            <img src="../uploads/<?= htmlspecialchars($r['image']) ?>" width="80" height="60" alt="">
                        <?php else: ?>
                            <span style="color:#999;">Pas d'image</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($r['name']) ?></td>
                    <td><?= htmlspecialchars($r['category_name'] ?? 'Non classée') ?></td>
                    <td><?= $r['prep_time'] ?> min</td>
                    <td>
                        <a href="update.php?id=<?= $r['id'] ?>" class="btn btn-edit">Modifier</a>
                        <a href="delete.php?id=<?= $r['id'] ?>" class="btn btn-delete" 
                           onclick="return confirm('Supprimer cette recette ?')">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>