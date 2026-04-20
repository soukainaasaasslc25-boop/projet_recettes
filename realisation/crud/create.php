<?php 
require_once '../functions.php';

$message = '';
$categories = getAllCategories($pdo);

$upload_dir = '../uploads/';


if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $name        = trim($_POST['name'] ?? '');
    $prep_time   = (int)($_POST['prep_time'] ?? 0);
    $category_id = (int)($_POST['category_id'] ?? 0);
    $image       = null;

  
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        
        $file_name = time() . '_' . $_FILES['image']['name'];   
        $target_file = $upload_dir . $file_name;

      
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image = $file_name;
        } else {
            $message = "Erreur : Impossible d'enregistrer l'image. Vérifie que le dossier 'uploads' existe.";
        }
    }

    
    if (empty($message) && !empty($name) && $prep_time > 0 && $category_id > 0) {
        if (addRecipe($pdo, $name, $prep_time, $category_id, $image)) {
            header("Location: read.php?success=added");
            exit();
        } else {
            $message = "Erreur lors de l'ajout dans la base de données.";
        }
    } else {
        if (empty($message)) {
            $message = "Veuillez remplir tous les champs obligatoires.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Recette</title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../css/create.css">
  
</head>
<body>
    <div class="container">
        <h1> Ajouter une nouvelle recette</h1>

        <?php if ($message): ?>
            <p style="color: red; text-align:center;"><?= $message ?></p>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            
            <label>Nom de la recette :</label>
            <input type="text" name="name" required>

            <label>Temps de préparation (minutes) :</label>
            <input type="number" name="prep_time" min="1" required>

            <label>Catégorie :</label>
            <select name="category_id" required>
                <option value="">-- Choisir une catégorie --</option>
                <?php foreach($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                <?php endforeach; ?>
            </select>

            <label>Image de la recette :</label>
            <input type="file" name="image" accept="image/*">

            <button type="submit">Ajouter la recette</button>
        </form>

        <a href="read.php" style="display:block; text-align:center; margin-top:20px;">
            ← Retour à la liste
        </a>
    </div>
</body>
</html>