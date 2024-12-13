<?php
// session_start();
// if (isset($_SESSION['token']) && isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
//     header('Location: admin_dashboard.php'); // Rediriger vers le tableau de bord admin si déjà connecté
//     exit();
// }

include('C:/Users/ycode/location-de-voitures/configuration/connection.php');

// Vérification de la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Recherche de l'utilisateur dans la base de données
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Vérification du mot de passe
        if (password_verify($password, $user['password'])) {
            // Créer un token d'authentification unique (par exemple en utilisant la fonction uniqid)
            $token = bin2hex(random_bytes(32)); // Génère un token unique de 32 octets
            
            // Stocker le token dans la session
            setcookie('token', $token, time() + 3600 , "/");
            /*$_SESSION['user_id'] = $user['id'];
            $_SESSION['nom'] = $user['nom'];
            $_SESSION['role'] = $user['role'];*/

            // Enregistrer le token dans la base de données pour l'utilisateur
            $sql_update_token = "UPDATE users SET token = ? WHERE id = ?";
            $stmt_update_token = $conn->prepare($sql_update_token);
            $stmt_update_token->bind_param('si', $token, $user['id']);
            $stmt_update_token->execute();

            // Rediriger l'utilisateur en fonction de son rôle
            if ($user['role'] == 'admin') {
                header('Location: /admin_dashboard.php');
            } else {
                header('Location: /index.php');
            }
            exit();
        } else {
            $error_message = "Identifiants incorrects.";
        }
    } else {
        $error_message = "Identifiants incorrects.";
    }
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="/form.css">
</head>

<body>
    


    <div class="container">
        <!-- Affichage du message d'erreur -->
        <?php
        if (!empty($error_message)) {
            echo "<div class='alert-warning' role='alert'><strong>$error_message</strong></div>";
        }
        ?>

        <h1>Se connecter</h1>

        <form method="POST">
            <div class="input-group">
                <label for="email">Email :</label>
                <input type="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="password">Mot de passe :</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Se connecter</button>
            <button type="submit"><a href="/athentification/inscreption.php">S'inscrire</a></button>
        </form>
    </div>
</body>

</html>