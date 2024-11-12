<?php

namespace User\Passwordgene;

class PasswordGenerator
{
    // Déclaration des propriétés statiques pour les différents types de caractères
    private static $upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'; // Lettres majuscules
    private static $lower = 'abcdefghijklmnopqrstuvwxyz'; // Lettres minuscules
    private static $numbers = '0123456789';               // Chiffres
    private static $special = '!@#$%^&*()';               // Caractères spéciaux

    /**
     * Génère un mot de passe aléatoire sécurisé.
     *
     * @param int $length La longueur souhaitée du mot de passe (par défaut 12).
     * @return string Le mot de passe généré.
     * @throws InvalidArgumentException Si la longueur est inférieure à 4.
     */
    public static final function generatePassword(int $length = 12): string
    {
        // Vérification que la longueur minimale du mot de passe est de 4 pour garantir diversité
        if ($length < 4) {
            throw new InvalidArgumentException("La longueur du mot de passe doit être d'au moins 4 caractères.");
        }

        // Concatène tous les ensembles de caractères en une seule chaîne pour les tirages aléatoires
        $allCharacters = self::$upper . self::$lower . self::$numbers . self::$special;

        // Initialisation du mot de passe avec un caractère de chaque type pour assurer diversité
        $password = [
            // Prend un caractère aléatoire parmi les lettres majuscules
            self::$upper[random_int(0, strlen(self::$upper) - 1)],
            // Prend un caractère aléatoire parmi les lettres minuscules
            self::$lower[random_int(0, strlen(self::$lower) - 1)],
            // Prend un caractère aléatoire parmi les chiffres
            self::$numbers[random_int(0, strlen(self::$numbers) - 1)],
            // Prend un caractère aléatoire parmi les caractères spéciaux
            self::$special[random_int(0, strlen(self::$special) - 1)]
        ];

        // Complète le mot de passe avec des caractères aléatoires jusqu'à atteindre la longueur souhaitée
        for ($i = 4; $i < $length; $i++) {
            // Prend un caractère aléatoire parmi tous les caractères disponibles
            $password[] = $allCharacters[random_int(0, strlen($allCharacters) - 1)];
        }

        // Mélange l'ordre des caractères dans le mot de passe pour plus de sécurité
        shuffle($password);

        // Convertit le tableau en une chaîne de caractères et retourne le mot de passe généré
        return implode('', $password);
    }

    /**
     * Vérifie si un mot de passe est considéré comme "fort".
     *
     * @param string $password Le mot de passe à vérifier.
     * @return bool true si le mot de passe est fort, sinon false.
     */
    public static function isStrongPassword(string $password):bool
    {
        // Vérifie que la longueur du mot de passe est d'au moins 8 caractères
        if (strlen($password) < 8) {
            return false;
        }

        // Utilise des expressions régulières pour vérifier la présence de chaque type de caractère
        $hasUpper = preg_match('/[A-Z]/', $password);      // Vérifie la présence d'au moins une lettre majuscule
        $hasLower = preg_match('/[a-z]/', $password);      // Vérifie la présence d'au moins une lettre minuscule
        $hasNumber = preg_match('/[0-9]/', $password);     // Vérifie la présence d'au moins un chiffre
        $hasSpecial = preg_match('/[!@#$%^&*()]/', $password); // Vérifie la présence d'au moins un caractère spécial

        // Retourne true seulement si le mot de passe contient chaque type de caractère
        return $hasUpper && $hasLower && $hasNumber && $hasSpecial;
    }
}

// Exemple d'utilisation
// try {
//     // Génère un mot de passe de 12 caractères
//     $password = PasswordGenerator::generatePassword(12);
//     echo "Mot de passe généré : $password\n";

//     // Vérifie si le mot de passe généré est "fort"
//     $isStrong = PasswordGenerator::isStrongPassword($password);
//     echo "Le mot de passe est fort ? " . ($isStrong ? "Oui" : "Non") . "\n";
// } catch (Exception $e) {
//     // Gestion des erreurs (si la longueur du mot de passe demandée est inférieure à 4)
//     echo "Erreur : " . $e->getMessage();
// }
