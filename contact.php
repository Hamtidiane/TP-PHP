<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contactez-nous</title>
</head>
<body>
<?php include 'header.php'?>
    <h2>Contactez-nous</h2>

    <?php
    // Démarrer la session pour gérer les erreurs et les données
    session_start();

    // Récupérer les erreurs et les données postées précédemment
    $errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
    $formData = isset($_SESSION['formData']) ? $_SESSION['formData'] : [];

    // Détruire les erreurs et les données après l'affichage
    unset($_SESSION['errors']);
    unset($_SESSION['formData']);
    ?>
    <?php
// Commencer la session pour stocker les erreurs et les données
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tableau pour les erreurs
    $errors = [];
    // Tableau pour stocker les données valides
    $formData = [
        'civilite' => $_POST['civilite'] ?? '',
        'nom' => $_POST['nom'] ?? '',
        'prenom' => $_POST['prenom'] ?? '',
        'email' => $_POST['email'] ?? '',
        'raison' => $_POST['raison'] ?? '',
        'message' => $_POST['message'] ?? ''
    ];

    // Vérification des champs
    if (!in_array($formData['civilite'], ['Monsieur', 'Madame'])) {
        $errors['civilite'] = "Veuillez choisir une civilité valide.";
    }

    if (empty($formData['nom'])) {
        $errors['nom'] = "Le champ nom est obligatoire.";
    }

    if (empty($formData['prenom'])) {
        $errors['prenom'] = "Le champ prénom est obligatoire.";
    }

    if (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "L'adresse email est invalide.";
    }

    $raisonsValides = ['Service comptable', 'Support technique', 'Autre'];
    if (!in_array($formData['raison'], $raisonsValides)) {
        $errors['raison'] = "Veuillez choisir une raison valide.";
    }

    if (strlen($formData['message']) < 5) {
        $errors['message'] = "Le message doit contenir au moins 5 caractères.";
    }

    if (empty($errors)) {
        // Créer le contenu pour le fichier texte
        $contenu = "Civilité : {$formData['civilite']}\n";
        $contenu .= "Nom : {$formData['nom']}\n";
        $contenu .= "Prénom : {$formData['prenom']}\n";
        $contenu .= "Email : {$formData['email']}\n";
        $contenu .= "Raison : {$formData['raison']}\n";
        $contenu .= "Message : {$formData['message']}\n";
        $contenu .= "---------------------------\n";

        // Enregistrer dans un fichier texte
        $fichier = 'données_formulaire.txt';
        file_put_contents($fichier, $contenu, FILE_APPEND | LOCK_EX);

        // Redirection après succès pour éviter la resoumission du formulaire
        header("Location: index.php?page=contact&success=1");
        exit;
    } else {
        // Enregistrer les erreurs et les données postées pour réafficher le formulaire
        $_SESSION['errors'] = $errors;
        $_SESSION['formData'] = $formData;
        
        // Redirection pour afficher les erreurs
        header("Location: index.php?page=contact");
        exit;
    }
}
?>
    <style>
        /* Styles de base pour une meilleure apparence du formulaire */
        body {
            font-family: Arial, sans-serif;
            padding: 0;
            display: flex;
            flex-direction: column;
            place-content: space-between;
        }
        form {
            width: 60%;
            margin: auto;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        div {
            margin-bottom: 15px;
        }
        #field-container{
            display: flex;
            flex-wrap: wrap;
        }
        fieldset{
            width: 45%;
            display: flex;
            align-items: flex-start;
            border: none;
        }
        fieldset label{
            padding-left: 10px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="email"], select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }
        textarea {
            resize: vertical;
        }
        button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            background-color: #007BFF;
            border: none;
            border-radius: 3px;
            color: white;
        }
    </style>

    <form action="index.php?page=contact" method="post">
        <label for="civilite">Civilité :</label>
        <select id="civilite" name="civilite">
            <option value="Monsieur" <?= (isset($formData['civilite']) && $formData['civilite'] == 'Monsieur') ? 'selected' : '' ?>>Monsieur</option>
            <option value="Madame" <?= (isset($formData['civilite']) && $formData['civilite'] == 'Madame') ? 'selected' : '' ?>>Madame</option>
        </select><br>
        <?php if (isset($errors['civilite'])) echo "<p style='color:red'>{$errors['civilite']}</p>"; ?>

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="<?= isset($formData['nom']) ? htmlspecialchars($formData['nom']) : '' ?>"><br>
        <?php if (isset($errors['nom'])) echo "<p style='color:red'>{$errors['nom']}</p>"; ?>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" value="<?= isset($formData['prenom']) ? htmlspecialchars($formData['prenom']) : '' ?>"><br>
        <?php if (isset($errors['prenom'])) echo "<p style='color:red'>{$errors['prenom']}</p>"; ?>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" value="<?= isset($formData['email']) ? htmlspecialchars($formData['email']) : '' ?>"><br>
        <?php if (isset($errors['email'])) echo "<p style='color:red'>{$errors['email']}</p>"; ?>

        <p>Raison du contact :</p>
        <input type="radio" id="comptable" name="raison" value="Service comptable" <?= (isset($formData['raison']) && $formData['raison'] == 'Service comptable') ? 'checked' : '' ?>>
        <label for="comptable">Service comptable</label><br>
        <input type="radio" id="technique" name="raison" value="Support technique" <?= (isset($formData['raison']) && $formData['raison'] == 'Support technique') ? 'checked' : '' ?>>
        <label for="technique">Support technique</label><br>
        <input type="radio" id="autre" name="raison" value="Autre" <?= (isset($formData['raison']) && $formData['raison'] == 'Autre') ? 'checked' : '' ?>>
        <label for="autre">Autre</label><br>
        <?php if (isset($errors['raison'])) echo "<p style='color:red'>{$errors['raison']}</p>"; ?>

        <label for="message">Message :</label><br>
        <textarea id="message" name="message"><?= isset($formData['message']) ? htmlspecialchars($formData['message']) : '' ?></textarea><br>
        <?php if (isset($errors['message'])) echo "<p style='color:red'>{$errors['message']}</p>"; ?>

        <input type="submit" value="Envoyer">
    </form>
    <?php include 'footer.php'; ?>
</body>
</html>