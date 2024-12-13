<?php

include("C:\Users\ycode\location-de-voitures\configuration\connection.php");
$NumContrat = '';
$DateDebut = '';
$DateFin = '';
$Duree = '';
$Num = '';
$NumImmatriculation = '';
$error_message = '';
$sucess_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['nom'];
    $adress = $_POST['adresse'];
    $tel = $_POST['tel'];

    if (empty($name) || empty($adress) || empty($tel)) {
        $error_message = 'Tous les champs sont obligatoires.';
    } else {
                $sql = "INSERT INTO clients (Nom, Adresse, Tel) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $adress, $tel);  
                if ($stmt->execute()) {
            $name = '';
            $adress = '';
            $tel = '';
            $sucess_message = 'Client ajouté avec succès!';
                        header("Location: /Clients/clients.php");
            exit;
        } else {
            $error_message = "Erreur lors de l'ajout du client : " . $stmt->error;
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
        <div class="logo"><a href="/admin_dashboard.php"><img src="/img/CarFlex.png" alt=""></a></div>
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
    <div class="logo"><a href="/index.php"><img src="/img/CarFlex.png" alt=""></a></div>
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
            echo "
            <div class=\"alert-warning\" role=\"alert\">
                <strong>$error_message</strong>
            </div>
            ";
        }
        ?>

        <h1>Ajouter un Client:</h1>

        <form method="post">
            <div class="nom">
                <label for="nom">Le Nom :</label>
                <input type="text" name="nom" value="" placeholder="Votre nom">
            </div>

            <div class="adresse">
                <label for="adresse">L'Adresse:</label>
                <input type="text" name="adresse" value="" placeholder="Votre Adresse">
            </div>

            <div class="tel">
                <label for="tel">Le téléphone :</label>
                <input type="text" name="tel" value="" placeholder="Votre numero de telephone">
            </div>

            <!-- Affichage du message de succès -->
            <?php
            if (!empty($sucess_message)) {
                echo "
                <div class=\"alert-success\" role=\"alert\">
                    <strong>$sucess_message</strong>
                </div>
                ";
            }
            ?>

            <div class="option">
                <button type="submit">
                    Sauvegarder
                </button>

                <button type="button">
                    <a href="/Clients/clients.php">
                        Annuler
                    </a>
                </button>
            </div>

        </form>
    </div>
</body>

</html>
