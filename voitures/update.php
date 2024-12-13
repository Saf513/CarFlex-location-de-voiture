<?php
include('C:/Users/ycode/location-de-voitures/configuration/connection.php');

$NumImmatriculation = '';
$model = '';
$marque = '';
$annee = '';
$error_message = '';
$sucess_message = '';

// Vérification de l'ID dans l'URL
if (isset($_GET["id"]) && is_string($_GET["id"])) {
    $NumImmatriculation = $_GET["id"];
} else {
    header("Location: /voitures/voitures.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les valeurs du formulaire
    $model = $_POST['Model'];
    $marque = $_POST['Marque'];
    $annee = $_POST['Annee'];

    // Validation des champs
    if (empty($model) || empty($marque) || empty($annee)) {
        $error_message = 'Tous les champs sont obligatoires.';
    } else {
        // Mise à jour des informations dans la base de données
        $sql = "UPDATE voitures SET Model = ?, Marque = ?, Annee = ? WHERE NumImmatriculation = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            $error_message = 'Erreur de préparation de la requête de mise à jour : ' . $conn->error;
        } else {
            $stmt->bind_param("ssss", $model, $marque, $annee, $NumImmatriculation);

            if ($stmt->execute()) {
                $sucess_message = 'La voiture a bien été modifiée.';
                // Rediriger vers la page des voitures après la mise à jour
                header("Location: /voitures/voitures.php");
                exit;
            } else {
                $error_message = "Erreur lors de la mise à jour : " . $stmt->error;
            }
        }
    }
} else {
    // Si ce n'est pas une requête POST, récupérer les informations de la voiture à modifier
    $sql = "SELECT * FROM voitures WHERE NumImmatriculation = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $NumImmatriculation);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        // Récupérer les données de la voiture
        $NumImmatriculation = $row['NumImmatriculation'];
        $marque = $row['Marque'];
        $model = $row['Model'];
        $annee = $row['Annee'];
    } else {
        $error_message = "Aucune voiture trouvée avec cet immatriculation.";
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

        <h1>Modifier la Voiture :</h1>

        <form method="post">

            <div class="marque">
                <label for="marque">La Marque :</label>
                <input type="text" name="Marque" value="<?php echo htmlspecialchars($marque); ?>">
            </div>

            <div class="model">
                <label for="model">Le Modèle :</label>
                <input type="text" name="Model" value="<?php echo htmlspecialchars($model); ?>">
            </div>

            <div class="annee">
                <label for="annee">L'Année :</label>
                <input type="text" name="Annee" value="<?php echo htmlspecialchars($annee); ?>">
            </div>

            <!-- Affichage du message de succès -->
            <?php
            if (!empty($sucess_message)) {
                echo "<div class=\"alert-success\"><strong>$sucess_message</strong></div>";
            }
            ?>

            <div class="option">
                <button type="submit">Sauvegarder</button>
                <button type="button"><a href="/voitures/voitures.php">Annuler</a></button>
            </div>
        </form>
    </div>
</body>

</html>
