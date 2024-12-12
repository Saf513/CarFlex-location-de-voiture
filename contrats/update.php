<?php
include('C:/Users/ycode/location-de-voitures/configuration/connection.php');

$NumContrat = '';
$DateDebut = '';
$DateFin = '';
$Duree = '';
$Num = '';
$NumImmatriculation = '';
$error_message = '';
$sucess_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérifier si l'ID est bien passé dans l'URL et qu'il est numérique
    if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
        header("Location: /contrats/contrat.php");
        exit;
    }
    $id = $_GET["id"];

    // Si l'ID existe dans la base de données
    $sql = "SELECT * FROM contrat WHERE NumContrat = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        $error_message = "Le contrat avec l'ID spécifié n'existe pas.";
    }

    // Récupérer les valeurs de la base pour les afficher dans le formulaire
    $NumContrat = $row['NumContrat'];
    $DateDebut = $row['DateDebut'];
    $DateFin =  $row['DateFin'];
    $Duree =  $row['Duree'];
    $Num =  $row['Num'];
    $NumImmatriculation =  $row['NumImmatriculation'];

    // Validation du formulaire
    if (empty($_POST['NumContrat']) || empty($_POST['DateDebut']) || empty($_POST['DateFin']) || empty($_POST['Duree']) || empty($_POST['Num']) || empty($_POST['NumImmatriculation'])) {
        $error_message = 'Tous les champs sont obligatoires.';
    } else {
        // Assigner les nouvelles valeurs envoyées par le formulaire
        $NumContrat =  $_POST['NumContrat'];
        $DateDebut =  $_POST['DateDebut'];
        $DateFin =   $_POST['DateFin'];
        $Duree =   $_POST['Duree'];
        $Num =   $_POST['Num'];
        $NumImmatriculation =  $_POST['NumImmatriculation'];

        // Préparer la requête de mise à jour
        $sql = "UPDATE contrat SET DateDebut = ?, DateFin = ?, Duree = ?, Num = ?, NumImmatriculation = ? WHERE NumContrat = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            $error_message = 'Erreur de préparation de la requête: ' . $conn->error;
        } else {
            $stmt->bind_param("sssssi", $DateDebut, $DateFin, $Duree, $Num, $NumImmatriculation, $NumContrat);
            // Exécuter la requête
            if ($stmt->execute()) {
                $sucess_message = 'Le contrat a bien été modifié.';
                header("Location: /contrats/contrat.php");
                exit;
            } else {
                $error_message = "Erreur lors de la mise à jour : " . $stmt->error;
            }
        }
    }
} else {
    // Vérification si l'ID existe et est numérique
    if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
        $id = $_GET["id"];

        // Récupérer les données du contrat à modifier
        $sql = "SELECT * FROM contrat WHERE NumContrat = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            $NumContrat = $row['NumContrat'];
            $DateDebut = $row['DateDebut'];
            $DateFin = $row['DateFin'];
            $Duree = $row['Duree'];
            $Num = $row['Num'];
            $NumImmatriculation = $row['NumImmatriculation'];
        } else {
            $error_message = "Aucun contrat trouvé avec cet ID.";
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
<nav class="navbar">
    <div class="logo"><a href="/index.html"><img src="/img/CarFlex.png" alt=""></a></div>
    <div>
        <ul class="section">
            <li><a href="/voitures/voitures.php">Voitures</a></li>
            <li> <a href="/Clients/clients.php">Clients</a></li>
            <li><a href="/contrats/contrat.php">Contrats</a></li>
        </ul>
        
    </div>
    <div class="login">
        <div class="logo-login"> <p><a href="/athentification/login.php"><i class="fa-solid fa-right-to-bracket fa-2x" style="color: #19191a;"></i></a></p></div>
    </div>
   </nav> 

    <div class="container-creat">
        <!-- Affichage du message d'erreur -->
        <?php
        if (!empty($error_message)) {
            echo "<div class=\"alert-warning\" role=\"alert\"><strong>$error_message</strong></div>";
        }
        ?>

        <h1>Modifier le Contrat :</h1>

        <form method="post">

            <div class="NumContrat">
                <label for="NumContrat">Numéro du Contrat :</label>
                <input type="text" name="NumContrat" value="<?php echo $NumContrat; ?>" readonly>
            </div>

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
