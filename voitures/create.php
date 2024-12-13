<?php

include("C:\Users\ycode\location-de-voitures\configuration\connection.php");
$NumImmatriculation = '';
$model = '';
$marque = '';
$annee = '';
$error_message = '';
$sucess_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $NumImmatriculation = $_POST['NumImmatriculation'];
    $model = $_POST['Model'];
    $marque = $_POST['Marque'];
    $annee = $_POST['Annee'];

    if (empty($_POST['NumImmatriculation']) || empty($_POST['Model']) || empty($_POST['Marque']) || empty($_POST['Annee'])) {
        $error_message = 'Tous les champs sont obligatoires.';
    } else {

        $sql = "INSERT INTO voitures  VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $NumImmatriculation, $model, $marque, $annee);  
                if ($stmt->execute()) {
            $NumImmatriculation = '';
            $model = '';
            $marque = '';
            $annee = '';
            $sucess_message = 'voiture ajouté avec succès!';
                        header("Location: /voitures/voitures.php");
            exit;
        } else {
            $error_message = "Erreur lors de l'ajout du voiture: " . $stmt->error;
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
                                        echo '<p>Bonjour, ' . htmlspecialchars($_COOKIE['nom']) . ' | <a href="athentification/logout.php">Se déconnecter</a></p>';
                } else {
                                        echo '<p><a href="athentification\login.php"><i class="fa-solid fa-right-to-bracket fa-2x" style="color: #19191a;"></i></a></p>';
                }
                ?>
            </div>
        </div>

        
    </nav>
    <nav id="mobile">
    <div class="logo"><a href=""><img src="/img/CarFlex.png" alt=""></a></div>
    <div class="login">
            <div class="logo-login">
                
                <?php
                if (isset($_COOKIE['user_id']) && isset($_COOKIE['user_email'])) {
                                        echo '<p>Bonjour, ' . htmlspecialchars($_COOKIE['nom']) . ' | <a href="athentification/logout.php">Se déconnecter</a></p>';
                } else {
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

        <h1>Ajouter la Voiture :</h1>

        <form method="post">

            <div class="NumImmatriculation">
                <label for="NumImmatriculation">Numéro d'Immatriculation :</label>
                <input type="text" name="NumImmatriculation" value="<?php echo $NumImmatriculation; ?>" >
            </div>

            <div class="marque">
                <label for="marque">La Marque :</label>
                <input type="text" name="Marque" value="<?php echo $marque; ?>">
            </div>

            <div class="model">
                <label for="model">Le Modèle :</label>
                <input type="text" name="Model" value="<?php echo $model; ?>">
            </div>

            <div class="annee">
                <label for="annee">L'Année :</label>
                <input type="text" name="Annee">
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