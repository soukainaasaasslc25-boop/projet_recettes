<?php 
require_once 'db.php';
require_once 'functions.php';

$message = "";
$messageType = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name']);
    $price    = floatval($_POST['price']);
    $quantity = intval($_POST['quantity']);

    if (!empty($name) && $price > 0 && $quantity >= 0) {
        if (ajouterProduit($pdo, $name, $price, $quantity)) {
            header("Location: index.php?success=added");
            exit();
        } else {
            $message = "Erreur lors de l'ajout du produit.";
            $messageType = "error";
        }
    } else {
        $message = "Veuillez remplir tous les champs correctement.";
        $messageType = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Produit - GoldenFork</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #ffffff;
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

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-15px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-2px); }
            20%, 40%, 60%, 80% { transform: translateX(2px); }
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.03);
            animation: fadeIn 0.4s ease-out;
        }

        .header {
            padding: 2rem 2rem 0 2rem;
        }

        .header h1 {
            color: #111827;
            font-size: 1.75rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .header p {
            color: #6b7280;
            font-size: 0.875rem;
        }

        .content {
            padding: 2rem;
        }

        .message {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
            animation: shake 0.3s ease-out;
        }

        .message-error {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fee2e2;
        }

        .form-group {
            margin-bottom: 1.5rem;
            animation: slideIn 0.3s ease-out backwards;
        }

        .form-group:nth-child(1) { animation-delay: 0.05s; }
        .form-group:nth-child(2) { animation-delay: 0.1s; }
        .form-group:nth-child(3) { animation-delay: 0.15s; }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #374151;
            font-size: 0.875rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.625rem 0.875rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            font-family: inherit;
            background: white;
        }

        .form-group input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-group input:hover {
            border-color: #9ca3af;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            animation: slideIn 0.3s ease-out 0.2s backwards;
        }

        .btn-save {
            flex: 1;
            padding: 0.625rem 1.5rem;
            background: #3b82f6;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-save:hover {
            background: #2563eb;
            transform: translateY(-1px);
        }

        .btn-save:active {
            transform: translateY(0);
        }

        .btn-cancel {
            flex: 1;
            padding: 0.625rem 1.5rem;
            background: white;
            color: #4b5563;
            text-decoration: none;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            text-align: center;
            transition: all 0.2s ease;
            border: 1px solid #a4a6a9ff;
        }

        .btn-cancel:hover {
            background: #f9fafb;
            border-color: #b0b5beff;
            transform: translateY(-1px);
        }

        .btn-cancel:active {
            transform: translateY(0);
        }

        /* Responsive */
        @media (max-width: 640px) {
            body {
                padding: 1rem;
            }
            
            .header {
                padding: 1.5rem 1.5rem 0 1.5rem;
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
            <h1>Ajouter un produit</h1>
            <p>Remplissez les informations ci-dessous</p>
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
                    <input type="text" id="name" name="name" placeholder="Ex: Ordinateur portable" required>
                </div>

                <div class="form-group">
                    <label for="price">Prix (DH)</label>
                    <input type="number" id="price" name="price" step="0.01" placeholder="0.00" required>
                </div>

                <div class="form-group">
                    <label for="quantity">Quantité</label>
                    <input type="number" id="quantity" name="quantity" placeholder="0" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save">Ajouter le produit</button>
                    <a href="index.php" class="btn-cancel">Annuler</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>