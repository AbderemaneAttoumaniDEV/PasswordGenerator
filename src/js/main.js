// Caractères pour générer les mots de passe
const chars = {
    upper: 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',   // Lettres majuscules
    lower: 'abcdefghijklmnopqrstuvwxyz',   // Lettres minuscules
    numbers: '0123456789',                 // Chiffres
    special: '!@#$%^&*()'                  // Caractères spéciaux
};

// Génère un mot de passe aléatoire sécurisé
function generatePassword(length = 12) {
    if (length < 4) {
        return "Erreur : La longueur doit être d'au moins 4 caractères.";  // Vérification de la longueur minimale
    }

    // Inclut chaque type de caractère au moins une fois pour garantir un mot de passe sécurisé
    const passwordChars = [
        chars.upper[Math.floor(Math.random() * chars.upper.length)],   // Majuscule
        chars.lower[Math.floor(Math.random() * chars.lower.length)],   // Minuscule
        chars.numbers[Math.floor(Math.random() * chars.numbers.length)], // Chiffre
        chars.special[Math.floor(Math.random() * chars.special.length)], // Spécial
    ];

    // Complète avec des caractères aléatoires jusqu'à la longueur demandée
    const allChars = chars.upper + chars.lower + chars.numbers + chars.special;
    for (let i = 4; i < length; i++) {
        passwordChars.push(allChars[Math.floor(Math.random() * allChars.length)]);
    }

    // Mélange le mot de passe pour éviter une prévisibilité
    return passwordChars.sort(() => Math.random() - 0.5).join('');
}

// Vérifie si un mot de passe est fort
function isStrongPassword(password) {
    const hasUpper = /[A-Z]/.test(password);  // Vérifie la présence de majuscules
    const hasLower = /[a-z]/.test(password);  // Vérifie la présence de minuscules
    const hasNumber = /[0-9]/.test(password); // Vérifie la présence de chiffres
    const hasSpecial = /[!@#$%^&*()]/.test(password);  // Vérifie la présence de caractères spéciaux

    // Retourne vrai si le mot de passe contient tous les critères
    return password.length >= 8 && hasUpper && hasLower && hasNumber && hasSpecial;
}

// Fonction pour copier le mot de passe dans le presse-papiers
function copyToClipboard(text) {
    navigator.clipboard.writeText(text)  // Utilise l'API Clipboard pour copier
        .then(() => {
            console.log("Mot de passe copié !");
        })
        .catch(err => {
            console.error("Erreur de copie :", err);  // Affiche une erreur si la copie échoue
        });
}

// Fonction pour coller le mot de passe dans un champ de texte
function pasteFromClipboard(event) {
    event.preventDefault(); // Empêche le comportement par défaut (rechargement de la page)
    
    navigator.clipboard.readText()  // Utilise l'API Clipboard pour lire le texte
        .then(text => {
            document.getElementById('password').value = text;  // Colle le texte dans le champ de mot de passe
        })
        .catch(err => {
            console.error("Erreur de lecture du presse-papiers :", err);
        });
}

// Génération du mot de passe lors du clic sur le bouton "Générer"
document.getElementById('generateBtn').addEventListener('click', () => {
    const length = parseInt(document.getElementById('length').value) || 12;  // Prend la longueur du mot de passe
    const generatedPassword = generatePassword(length);  // Appelle la fonction pour générer le mot de passe

    // Affiche le mot de passe généré dans l'élément HTML
    const generatedPasswordElement = document.getElementById('generatedPassword');
    generatedPasswordElement.textContent = "Mot de passe généré : " + generatedPassword;

    // Affiche le bouton "Copier"
    const copyBtn = document.getElementById('copyBtn');
    copyBtn.classList.remove('hidden');  // Affiche le bouton "Copier"

    // Ajoute un événement de clic pour copier le mot de passe
    copyBtn.addEventListener('click', () => {
        copyToClipboard(generatedPassword);

        // Affiche le bouton "Coller" lorsque le bouton "Copier" est cliqué
        const pasteBtn = document.getElementById('pasteBtn');
        pasteBtn.classList.remove('hidden');  // Affiche le bouton "Coller"
    });
});

// Vérification de robustesse du mot de passe lors du clic sur "Vérifier"
document.getElementById('checkBtn').addEventListener('click', () => {
    const password = document.getElementById('password').value;  // Récupère le mot de passe saisi
    const strength = isStrongPassword(password) ? "fort" : "faible";  // Vérifie si le mot de passe est fort
    document.getElementById('passwordStrength').textContent = "Le mot de passe est : " + strength;  // Affiche la robustesse
});

// Ajoute un événement pour coller le mot de passe dans le champ de texte
document.getElementById('pasteBtn').addEventListener('click', pasteFromClipboard);
