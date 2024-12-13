<?php
include('C:/Users/ycode/location-de-voitures/configuration/connection.php');

$nom = '';
$email = '';
$password = '';
$password_confirm = '';
$role = 'user'; $token = ''; $error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    $role = $_POST['role']; 
        if (empty($nom) || empty($email) || empty($password) || empty($password_confirm)) {
        $error_message = 'Tous les champs sont obligatoires.';
    } elseif ($password !== $password_confirm) {
                $error_message = 'Les mots de passe ne correspondent pas.';
    } else {
                $sql_check_user = "SELECT * FROM users WHERE email = ?";
        $stmt_check = $conn->prepare($sql_check_user);
        $stmt_check->bind_param('s', $email);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        if ($result->num_rows > 0) {
            $error_message = 'Cet email est déjà utilisé.';
        } else {
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                        $token = bin2hex(random_bytes(32));  
                        $sql_insert = "INSERT INTO users (nom, email, password, role, token) VALUES (?, ?, ?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param('sssss', $nom, $email, $hashed_password, $role, $token);

            if ($stmt_insert->execute()) {
                                $success_message = 'Inscription réussie ! Vous pouvez vous connecter maintenant.';

                                $user_id = $conn->insert_id;

                                                                                setcookie('token', $token, time() + 3600, '/'); 
                                if ($role == 'admin') {
                    header('Location: /dashboard.php');                 } else {
                    header('Location: /index.php'); 
                }
                exit();             } else {
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
