
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Contact</title>
    <?php include 'header.php'?>
    <?php
    if ($serveur['REQUEST_METHOD'] == 'POST') {
        $errors = [];
    
        // Récupération et nettoyage des données
        $civilite = htmlspecialchars($_POST['civilite'] ?? '');//htmlspecialchars est une fonction qui va permettre d'échapper certains caractères spéciaux ("<"">")en les transformant en entités HTML 
        $nom = htmlspecialchars($_POST['nom'] ?? '');
        $prenom = htmlspecialchars($_POST['prenom'] ?? '');
        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);//FILTER_SANITIZE_EMAIL Supprime tous les caractères sauf les lettres, chiffres, et !#$%&'*+-=?^_`{|}~@.[]. 
        $raison_contact = htmlspecialchars($_POST['raison_contact'] ?? '');
        $message = htmlspecialchars($_POST['message'] ?? '');
    
        // Vérification du champ nom
        if (empty($nom)) {//si la case nom est vide 
            $errors[] = 'Le champ nom est requis.';//variable errors qui demande le champ requis pour validation 
        }
    
        // Vérification du champ prénom
        if (empty($prenom)) {//si la case prénom est vide
            $errors[] = 'Le champ prénom est requis.';//variable errors qui demande le champ requis pour validation
        }
    
        // Vérification de l'email
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {//filter_var:filtre une variable avec un filtre spécifique ici dans notre cas $email est filtré avec FILTER_VALIDATE_EMAIL
            $errors[] = 'Veuillez fournir un email valide.';//variable errors qui demande le champ requis pour validation
        }
    
        // Vérification de la raison de contact
        $raisons_valides = ['service_comptable', 'support_technique', 'demande_informations'];//variable qui vérifie la que la raison sociale est bien comprise dans celles que nous avons  
        if (empty($raison_contact) || !in_array($raison_contact, $raisons_valides)) {// !in array ici indique si une valeur appartient a un tableau 
            $errors[] = 'Veuillez choisir une raison de contact valide.';//variable errors qui demande le champ requis pour validation
        }
    
        // Vérification du message
        if (empty($message) || strlen($message) < 5) {// strlen fct qui  calcule la taille d'une chaine de caractère 
            $errors[] = 'Le message doit contenir au moins 5 caractères.';//variable errors qui demande le champ requis pour validation
        }
    
        // Affichage des erreurs ou traitement des données
        if (empty($errors)) {
            // Traitez les données ici, comme les envoyer par email ou les sauvegarder en base de données
            echo "Votre message a été envoyé avec succès.";
        } else {
            foreach ($errors as $error) {
                echo "<p style='color:red;'>$error</p>";
            }
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
</head>
<form action="index.php?page=contact" method="post">
        <label for="civilite">Civilité :</label>
        <select id="civilite" name="civilite">
            <option value="M.">M.</option>
            <option value="Mme">Mme</option>
            <option value="Mlle">Mlle</option>
        </select><br><br>

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom"><br><br>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom"><br><br>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email"><br><br>

        <label>Raison du contact :</label><br>
        <input type="radio" id="comptable" name="raison_contact" value="service_comptable">
        <label for="comptable">Service Comptable</label><br>
        <input type="radio" id="support" name="raison_contact" value="support_technique">
        <label for="support">Support Technique</label><br>
        <input type="radio" id="info" name="raison_contact" value="demande_informations">
        <label for="info">Demande d'Informations</label><br><br>

        <label for="message">Message :</label><br>
        <textarea id="message" name="message"></textarea><br><br>

        <button type="submit">Envoyer</button>
    </form>
</body>
<?php include 'footer.php'?>
</html>