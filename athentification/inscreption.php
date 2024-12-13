<?php
// Inclusion du fichier de connexion à la base de données
include('C:/Users/ycode/location-de-voitures/configuration/connection.php');

$nom = '';
$email = '';
$password = '';
$password_confirm = '';
$role = 'user'; // Rôle par défaut
$token = ''; // Le token sera généré automatiquement
$error_message = '';
$success_message = '';

// Traitement du formulaire d'inscription
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    $role = $_POST['role']; // Récupérer le rôle choisi

    // Validation des champs
    if (empty($nom) || empty($email) || empty($password) || empty($password_confirm)) {
        $error_message = 'Tous les champs sont obligatoires.';
    } elseif ($password !== $password_confirm) {
        // Vérifier si les mots de passe correspondent
        $error_message = 'Les mots de passe ne correspondent pas.';
    } else {
        // Vérifier si l'utilisateur existe déjà
        $sql_check_user = "SELECT * FROM users WHERE email = ?";
        $stmt_check = $conn->prepare($sql_check_user);
        $stmt_check->bind_param('s', $email);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        if ($result->num_rows > 0) {
            $error_message = 'Cet email est déjà utilisé.';
        } else {
            // Hacher le mot de passe
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Générer un token unique
            $token = bin2hex(random_bytes(32));  // Génère un token de 64 caractères

            // Insertion de l'utilisateur dans la base de données
            $sql_insert = "INSERT INTO users (nom, email, password, role, token) VALUES (?, ?, ?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param('sssss', $nom, $email, $hashed_password, $role, $token);

            if ($stmt_insert->execute()) {
                // Inscription réussie
                $success_message = 'Inscription réussie ! Vous pouvez vous connecter maintenant.';

                // Récupérer l'ID de l'utilisateur nouvellement inscrit
                $user_id = $conn->insert_id;

                // Créer un cookie pour l'utilisateur
                // setcookie('user_id', $user_id, time() + 3600, '/'); // Expire dans 1 heure
                // setcookie('nom', $nom, time() + 3600, '/'); // Cookie pour le nom d'utilisateur
                // setcookie('role', $role, time() + 3600, '/'); // Cookie pour le rôle
                setcookie('token', $token, time() + 3600, '/'); // Cookie pour le token

                // Rediriger vers la page en fonction du rôle
                if ($role == 'admin') {
                    header('Location: /dashboard.php'); // Redirection vers voitures.php pour les admins
                } else {
                    header('Location: /index.php'); 
                }
                exit(); // Terminer l'exécution du script
            } else {
                $error_message = 'Erreur lors de l\'inscription. Veuillez réessayer.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Inscription</title>
    <link rel="stylesheet" href="../form.css">
</head>
<body>
    <div class="container">
        <h2>Inscription</h2>

        <!-- Affichage du message d'erreur -->
        <?php
        if (!empty($error_message)) {
            echo "<div class='error'>$error_message</div>";
        }

        // Affichage du message de succès
        if (!empty($success_message)) {
            echo "<div class='success'>$success_message</div>";
        }
        ?>

        <form method="POST">
            <div class="input-group">
                <label for="nom">Nom d'utilisateur:</label>
                <input type="text" id="nom" name="nom" value="<?php echo $nom; ?>" required>
            </div>

            <div class="input-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
            </div>

            <div class="input-group">
                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="input-group">
                <label for="password_confirm">Confirmer le mot de passe:</label>
                <input type="password" id="password_confirm" name="password_confirm" required>
            </div>

            <div class="input-group">
                <label for="role">Rôle:</label>
                <select name="role" id="role" required>
                    <option value="user" <?php echo ($role == 'user') ? 'selected' : ''; ?>>Utilisateur</option>
                    <option value="admin" <?php echo ($role == 'admin') ? 'selected' : ''; ?>>Administrateur</option>
                </select>
            </div>

            <div class="input-group">
                <button type="submit">S'inscrire</button>
            </div>
        </form>

        <p>Vous avez déjà un compte ? <a href="/athentification/login.php">Se connecter</a></p>
    </div>
</body>
</html>
