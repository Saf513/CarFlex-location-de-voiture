<?php
include("C:\Users\ycode\location-de-voitures\configuration\connection.php");

$DateDebut = '';
$DateFin = '';
$Duree = '';
$Num = '';
$NumImmatriculation = '';
$error_message = '';
$sucess_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $DateDebut = $_POST['DateDebut'];
    $DateFin = $_POST['DateFin'];
    $Duree = $_POST['Duree'];
    $Num = $_POST['Num'];
    $NumImmatriculation = $_POST['NumImmatriculation'];

        if (empty($DateDebut) || empty($DateFin) || empty($Duree) || empty($Num) || empty($NumImmatriculation)) {
        $error_message = 'Tous les champs sont obligatoires.';
    } else {
                $check_client_query = "SELECT COUNT(*) FROM clients WHERE Num = ?";
        $check_client_stmt = $conn->prepare($check_client_query);
        $check_client_stmt->bind_param("s", $Num);         $check_client_stmt->execute();
        $check_client_stmt->bind_result($client_count);
        $check_client_stmt->fetch();
        $check_client_stmt->close(); 
        if ($client_count == 0) {
            $error_message = "Le numéro du client n'existe pas dans la table des clients.";
        } else {
                        $check_voiture_query = "SELECT COUNT(*) FROM voitures WHERE NumImmatriculation = ?";
            $check_voiture_stmt = $conn->prepare($check_voiture_query);
            $check_voiture_stmt->bind_param("s", $NumImmatriculation);             $check_voiture_stmt->execute();
            $check_voiture_stmt->bind_result($voiture_count);
            $check_voiture_stmt->fetch();
            $check_voiture_stmt->close(); 
            if ($voiture_count == 0) {
                $error_message = "Numéro d'immatriculation invalide. Ce numéro n'existe pas dans la table des voitures.";
            } else {
                                $DateDebut = DateTime::createFromFormat('d-M-Y', $DateDebut);
                $DateFin = DateTime::createFromFormat('d-M-Y', $DateFin);

                                if ($DateDebut && $DateFin) {
                                        $DateDebut = $DateDebut->format('Y-m-d');
                    $DateFin = $DateFin->format('Y-m-d');

                                        $sql = "INSERT INTO contrat (DateDebut, DateFin, Duree, Num, NumImmatriculation) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sssis", $DateDebut, $DateFin, $Duree, $Num, $NumImmatriculation);

                                        if ($stmt->execute()) {
                                                $DateDebut = '';
                        $DateFin = '';
                        $Duree = '';
                        $Num = '';
                        $NumImmatriculation = '';
                        $sucess_message = 'Contrat ajouté avec succès!';

                                                header("Location: /contrats/contrat.php");
                        exit;
                    } else {
                        $error_message = "Erreur lors de l'ajout du contrat: " . $stmt->error;
                        echo 'error';
                    }

                    $stmt->close();                 } else {
                                        $error_message = 'Format de date incorrect. Veuillez entrer la date au format "dd-Mmm-yyyy".';
                }
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
    <div class="logo"><a href="/admin_dashboard.php"><img src="/img/CarFlex.png" alt=""></a></div>
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

        <h1>Ajouter un Contrat :</h1>

        <form method="post">
            <div class="DateDebut">
                <label for="DateDebut">Date de Début :</label>
                <input type="text" name="DateDebut" value="<?php echo $DateDebut; ?>">
            </div>

            <div class="DateFin">
                <label for="DateFin">Date de Fin :</label>
                <input type="text" name="DateFin" value="<?php echo $DateFin; ?>">
            </div>

            <div class="Duree">
                <label for="Duree">Durée :</label>
                <input type="text" name="Duree" value="<?php echo $Duree; ?>">
            </div>

            <div class="Num">
                <label for="Num">Numéro du Client :</label>
                <input type="text" name="Num" value="<?php echo $Num; ?>">
            </div>

            <div class="NumImmatriculation">
                <label for="NumImmatriculation">Numéro d'Immatriculation :</label>
                <input type="text" name="NumImmatriculation" value="<?php echo $NumImmatriculation; ?>">
            </div>

            <!-- Affichage du message de succès -->
            <?php
            if (!empty($sucess_message)) {
                echo "<div class=\"alert-success\"><strong>$sucess_message</strong></div>";
            }
            ?>

            <div class="option">
                <button type="submit">Sauvegarder</button>
                <button type="button"><a href="/contrats/contrat.php">Annuler</a></button>
            </div>
        </form>
    </div>
</body>
</html>
