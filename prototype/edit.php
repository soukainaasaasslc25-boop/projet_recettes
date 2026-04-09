<?php 
require_once 'db.php';
require_once 'functions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$produit = obtenirProduitParId($pdo, $id);

if (!$produit) {
    die("Produit non trouvé !");
}

$message = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name']);
    $price    = floatval($_POST['price']);
    $quantity = intval($_POST['quantity']);

    if (!empty($name) && $price > 0) {
        if (modifierProduit($pdo, $id, $name, $price, $quantity)) {
            header("Location: index.php?success=updated");
            exit();
        } else {
            $message = "Erreur lors de la modification.";
           
        }
    } else {
        $message = "Veuillez remplir correctement les champs.";
        
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Produit - GoldenFork</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
            padding: 2rem;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-3px); }
            20%, 40%, 60%, 80% { transform: translateX(3px); }
        }

        .container {
            max-width: 650px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08), 0 1px 2px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            animation: fadeIn 0.4s ease-out;
        }

        .header {
            padding: 2rem 2rem 1.5rem 2rem;
            border-bottom: 1px solid #eef2f6;
            background: white;
        }

        .header h1 {
            color: #1a1f36;
            font-size: 1.75rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .header .product-name {
            color: #5c6ac4;
            font-size: 0.875rem;
            font-weight: 500;
            background: #f0f2ff;
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
        }

        .content {
            padding: 2rem;
        }

        .message {
            padding: 0.875rem 1rem;
            border-radius: 8px;
            margin-bottom: 1.75rem;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .message-error {
            background: #fef2f2;
            color: #dc2626;
            border-left: 3px solid #dc2626;
        }

        .message-error::before {
            content: "⚠️";
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #1a1f36;
            font-size: 0.875rem;
        }

        .form-group label::after {
            content: "*";
            color: #dc2626;
            margin-left: 0.25rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            font-family: inherit;
            background: white;
        }

        .form-group input:focus {
            outline: none;
            border-color: #5c6ac4;
            box-shadow: 0 0 0 3px rgba(92, 106, 196, 0.1);
        }

        .form-group input:hover {
            border-color: #9ca3af;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 0.5rem;
        }

        .btn-save {
            flex: 1;
            padding: 0.75rem 1.5rem;
            background: #5c6ac4;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-save:hover {
            background: #4a56b0;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .btn-save:active {
            transform: translateY(0);
        }

        .btn-cancel {
            flex: 1;
            padding: 0.75rem 1.5rem;
            background: white;
            color: #4b5563;
            text-decoration: none;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            text-align: center;
            transition: all 0.2s ease;
            border: 1px solid #d1d5db;
        }

        .btn-cancel:hover {
            background: #f9fafb;
            border-color: #9ca3af;
            transform: translateY(-1px);
        }

        .btn-cancel:active {
            transform: translateY(0);
        }

        /* Info note */
        .info-note {
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid #eef2f6;
            font-size: 0.75rem;
            color: #6b7280;
            text-align: center;
        }

        /* Responsive design */
        @media (max-width: 640px) {
            body {
                padding: 1rem;
            }
            
            .header {
                padding: 1.5rem;
            }
            
            .header h1 {
                font-size: 1.5rem;
            }
            
            .content {
                padding: 1.5rem;
            }
            
            .form-actions {
                flex-direction: column;
                gap: 0.75rem;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h1>Modifier le produit</h1>
            <div class="product-name">✏️ <?= htmlspecialchars($produit['name']) ?></div>
        </div>

        <div class="content">
            <?php if ($message): ?>
                <div class="message message-<?= $messageType ?>">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="name">Nom du produit</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($produit['name']) ?>" placeholder="Ex: Ordinateur portable" required>
                </div>

                <div class="form-group">
                    <label for="price">Prix (DH)</label>
                    <input type="number" id="price" name="price" step="0.01" value="<?= $produit['price'] ?>" placeholder="0.00" required>
                </div>

                <div class="form-group">
                    <label for="quantity">Quantité</label>
                    <input type="number" id="quantity" name="quantity" value="<?= $produit['quantity'] ?>" placeholder="0" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save">💾 Enregistrer</button>
                    <a href="index.php" class="btn-cancel">← Annuler</a>
                </div>
            </form>
            
            <div class="info-note">
                Les champs marqués d'un <span style="color:#dc2626">*</span> sont obligatoires
            </div>
        </div>
    </div>

</body>
</html>