<?php
require_once __DIR__ . '/vendor/autoload.php';

// Importer la classe
use User\Passwordgene\PasswordGenerator;

$generatedPassword = "";
$passwordStrength = "";

// Vérifier si le formulaire de génération de mot de passe est soumis
if (isset($_POST['generate'])) {
    $length = isset($_POST['length']) ? (int)$_POST['length'] : 12;
    try {
        $generatedPassword = PasswordGenerator::generatePassword($length);
    } catch (Exception $e) {
        $generatedPassword = "Erreur : " . $e->getMessage();
    }
}

// Vérifier si le formulaire de vérification de robustesse est soumis
if (isset($_POST['check'])) {
    $password = $_POST['password'];
    $passwordStrength = PasswordGenerator::isStrongPassword($password) ? "fort" : "faible";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Générateur de Mot de Passe</title>
    <link rel="stylesheet" href="./src/css/styles.css">
</head>
<body>

<div class="container">
    <h1>Générateur de Mot de Passe</h1>

    <!-- Formulaire pour générer un mot de passe -->
    <div class="password-generator">
        <h2>Générer un mot de passe</h2>
        <form method="post" action="index.php">
            <label for="length">Longueur du mot de passe :</label>
            <input type="number" id="length" name="length" value="12" min="4" max="32">
            <button type="submit" name="generate">Générer</button>
        </form>
        <?php if (!empty($generatedPassword)) : ?>
            <p class="generated-password">Mot de passe généré : <strong id="generatedPasswordText"><?php echo htmlspecialchars($generatedPassword); ?></strong></p>
        <?php endif; ?>
    </div>

    <!-- Formulaire pour vérifier la robustesse d'un mot de passe -->
    <div class="password-checker">
        <h2>Vérifier la robustesse</h2>
        <form method="post" action="index.php">
            <label for="password">Entrez un mot de passe :</label>
            <input type="text" id="password" name="password">
            <button type="submit" name="check">Vérifier</button>
        </form>
        <?php if (!empty($passwordStrength)) : ?>
            <p class="password-strength">Le mot de passe est : <strong><?php echo $passwordStrength; ?></strong></p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>e
