<?php 
require_once '../functions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$recipe = getRecipeById($pdo, $id);
$categories = getAllCategories($pdo);

if (!$recipe) {
    die("Recette non trouvée !");
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $name        = trim($_POST['name']);
    $prep_time   = (int)$_POST['prep_time'];
    $category_id = (int)$_POST['category_id'];
    $image       = $recipe['image']; 

  
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        
        $file_tmp   = $_FILES['image']['tmp_name'];
        $file_name  = $_FILES['image']['name'];
        $file_size  = $_FILES['image']['size'];
        
   
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if (!in_array($file_ext, $allowed_extensions)) {
            $message = " Extension non autorisée. Utilisez JPG, JPEG, PNG, WEBP ou GIF.";
        }
        elseif ($file_size > 5 * 1024 * 1024) { 
            $message = " L'image est trop volumineuse (max 5 Mo).";
        }
        else {
          
            $new_image_name = uniqid('recipe_', true) . '.' . $file_ext;
            $upload_path = "../uploads/" . $new_image_name;

            if (move_uploaded_file($file_tmp, $upload_path)) {
                $image = $new_image_name;  
                
                
                if ($recipe['image'] && file_exists("../uploads/" . $recipe['image'])) {
                    unlink("../uploads/" . $recipe['image']);
                }
            } else {
                $message = "Erreur lors du téléchargement de l'image.";
            }
        }
    }

    if (empty($message) && !empty($name) && $prep_time > 0 && $category_id > 0) {
        
        if (updateRecipe($pdo, $id, $name, $prep_time, $category_id, $image)) {
            header("Location: read.php?success=updated");
            exit();
        } else {
            $message = "Erreur lors de la modification de la recette.";
        }
    } 
    elseif (empty($message)) {
        $message = "Veuillez remplir tous les champs correctement.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la Recette</title>
    <link rel="stylesheet" href="../css/update.css">
</head>
<body>
    <div class="container">
        <h1>Modifier la recette</h1>

        <?php if ($message): ?>
            <p style="color: red;"><?= $message ?></p>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <label>Nom de la recette :</label>
            <input type="text" name="name" value="<?= htmlspecialchars($recipe['name']) ?>" required>

            <label>Temps de préparation (minutes) :</label>
            <input type="number" name="prep_time" value="<?= $recipe['prep_time'] ?>" min="1" required>

            <label>Catégorie :</label>
            <select name="category_id" required>
                <?php foreach($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" 
                        <?= $cat['id'] == $recipe['category_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Image actuelle :</label><br>
            <?php if (!empty($recipe['image'])): ?>
                <img src="../uploads/<?= htmlspecialchars($recipe['image']) ?>" width="250" style="margin-bottom:15px; border-radius:8px;"><br>
            <?php else: ?>
                <p>Aucune image</p>
            <?php endif; ?>

            <label>Changer l'image (optionnel) :</label>
            <input type="file" name="image" accept="image/jpeg,image/png,image/webp,image/gif">

            <button type="submit" class="btn btn-add">Enregistrer les modifications</button>
        </form>

        <a href="read.php">← Retour à la liste</a>
    </div>
</body>
</html>