
<?php
    include "../configuration/connection.php";
    include "../athentification/userValidation.php";

    if(!$_COOKIE['token']) {
        header("Location: http://localhost:3000/athentification/login.php");
    }
    $user = userValidation($conn);
?>

<?php

include('C:/Users/ycode/location-de-voitures/configuration/connection.php');

$name = '';
$adress = '';
$tel = '';
$error_message = '';
$sucess_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérifier si l'ID est bien passé dans l'URL et qu'il est numérique
    if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
        header("Location: /Clients/clients.php");
        exit;
    }
    $id = $_GET["id"];

    // Si l'ID existe dans la base de données
    $sql = "SELECT * FROM clients WHERE Num = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        header("Location: /Clients/clients.php");
        exit;
    }

    // Récupérer les valeurs de la base pour les afficher dans le formulaire
    $name = $row['Nom'];
    $adress = $row['Adresse'];
    $tel = $row['Tel'];

    // Validation du formulaire
    if (empty($_POST['Nom']) || empty($_POST['Adresse']) || empty($_POST['Tel'])) {
        $error_message = 'Tous les champs sont obligatoires.';
    } else {
        // Assigner les nouvelles valeurs envoyées par le formulaire
        $name = $_POST['Nom'];
        $adress = $_POST['Adresse'];
        $tel = $_POST['Tel'];

        // Préparer la requête de mise à jour
        $sql = "UPDATE clients SET Nom = ?, Adresse = ?, Tel = ? WHERE Num = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $name, $adress, $tel, $id);

        // Exécuter la requête
        if ($stmt->execute()) {
            $sucess_message = 'Le client a bien été modifié.';
            header("Location: /Clients/clients.php");
            exit;
        } else {
            $error_message = "Erreur lors de la mise à jour : " . $stmt->error;
        }
    }
} else {
    // Vérification si l'ID existe et est numérique
    if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
        $id = $_GET["id"];

        // Récupérer les données du client à modifier
        $sql = "SELECT * FROM clients WHERE Num = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            $name = $row['Nom'];
            $adress = $row['Adresse'];
            $tel = $row['Tel'];
        }
    }
}


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarFlex</title>
    <link rel="stylesheet" href="/style.css">
</head>

<body>
<nav class="navbar" id="desktop">
        <div class="logo"><a href="/index.php"><img src="/img/CarFlex.png" alt=""></a></div>
        <div>
            <ul class="section">
                <li><a href="/voitures/voitures.php">Voitures</a></li>
                <li><a href="/Clients/clients.php">Clients</a></li>
                <li><a href="/contrats/contrat.php">Contrats</a></li>
            </ul>
        </div>
        <div class="login">
            <div class="logo-login">
                
                <?php
                if (isset($_COOKIE['user_id']) && isset($_COOKIE['user_email'])) {
                    // L'utilisateur est connecté
                    echo '<p>Bonjour, ' . htmlspecialchars($_COOKIE['nom']) . ' | <a href="athentification/logout.php">Se déconnecter</a></p>';
                } else {
                    // L'utilisateur n'est pas connecté
                    echo '<p><a href="athentification\login.php"><i class="fa-solid fa-right-to-bracket fa-2x" style="color: #19191a;"></i></a></p>';
                }
                ?>
            </div>
        </div>

        
    </nav>
    <nav id="mobile">
    <div class="logo"><a href="/admin_dashboard.php"><img src="/img/CarFlex.png" alt=""></a></div>
    <div class="login">
            <div class="logo-login">
                
                <?php
                if (isset($_COOKIE['user_id']) && isset($_COOKIE['user_email'])) {
                    // L'utilisateur est connecté
                    echo '<p>Bonjour, ' . htmlspecialchars($_COOKIE['nom']) . ' | <a href="athentification/logout.php">Se déconnecter</a></p>';
                } else {
                    // L'utilisateur n'est pas connecté
                    echo '<p><a href="athentification\login.php"><i class="fa-solid fa-right-to-bracket fa-2x" style="color: #19191a;"></i></a></p>';
                }
                ?>
            </div>
            <div class="burgerMenu">
            <button><i class="fa-solid fa-bars fa-2x" style="color: #0d0d0d;"></i></button>
        </div>
        </div>
       
    </nav>
    <div>
            <ul class="section" id="section-burger">
                <li><a href="/voitures/voitures.php">Voitures</a></li>
                <li><a href="/Clients/clients.php">Clients</a></li>
                <li><a href="/contrats/contrat.php">Contrats</a></li>
            </ul>
        </div>

    <div class="container-creat">
        <!-- Affichage du message d'erreur -->
        <?php 
        if (!empty($error_message)) {
            echo "<div class=\"alert-warning\" role=\"alert\"><strong>$error_message</strong></div>";
        }
        ?>

        <h1>Modifier le Client :</h1>

        <form method="post">
            <div class="nom">
                <label for="nom">Le Nom :</label>
                <input type="text" name="Nom" value="<?php echo $name; ?>">
            </div>

            <div class="adresse">
                <label for="adresse">L'Adresse:</label>
                <input type="text" name="Adresse" value="<?php echo $adress; ?>">
            </div>

            <div class="tel">
                <label for="tel">Le téléphone :</label>
                <input type="text" name="Tel" value="<?php echo $tel; ?>">
            </div>

            <!-- Affichage du message de succès -->
            <?php
            if (!empty($sucess_message)) {
                echo "<div class=\"alert-success\"><strong>$sucess_message</strong></div>";
            }
            ?>

            <div class="option">
                <button type="submit">Sauvegarder</button>
                <button type="button"><a href="/Clients/clients.php">Annuler</a></button>
            </div>
        </form>
    </div>
</body>

</html>
