<?php
include('C:/Users/ycode/location-de-voitures/configuration/connection.php');

$NumImmatriculation = '';
$model = '';
$marque = '';
$annee = '';
$error_message = '';
$sucess_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérifier si l'ID est bien passé dans l'URL et qu'il est numérique
    if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
        header("Location: /voitures/voitures.php");
        exit;
    }
    $id = $_GET["id"];

    // Si l'ID existe dans la base de données
    $sql = "SELECT * FROM voitures WHERE NumImmatriculation = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        $error_message = 'Erreur de préparation de la requête de sélection : ' . $conn->error;
    } else {
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if (!$row) {
            $error_message = "Aucune voiture trouvée avec cet immatriculation.";
        }

        // Récupérer les valeurs de la base pour les afficher dans le formulaire
        $NumImmatriculation = $row['NumImmatriculation'];
        $marque = $row['Marque'];
        $model = $row['Model'];
        $annee = $row['Annee'];
    }

    // Validation du formulaire
    if (empty($_POST['NumImmatriculation']) || empty($_POST['Model']) || empty($_POST['Marque']) || empty($_POST['Annee'])) {
        $error_message = 'Tous les champs sont obligatoires.';
    } else {
        // Assigner les nouvelles valeurs envoyées par le formulaire
        $NumImmatriculation = $_POST['NumImmatriculation'];
        $model = $_POST['Model'];
        $marque = $_POST['Marque'];
        $annee = $_POST['Annee'];

        // Préparer la requête de mise à jour
        $sql = "UPDATE voitures SET Model = ?, Marque = ?, Annee = ? WHERE NumImmatriculation = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            $error_message = 'Erreur de préparation de la requête de mise à jour : ' . $conn->error;
        } else {
            $stmt->bind_param("ssss", $model, $marque, $annee, $NumImmatriculation);

            // Exécuter la requête
            if ($stmt->execute()) {
                $sucess_message = 'La voiture a bien été modifiée.';
                header("Location: /voitures/voitures.php");
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

        // Récupérer les données de la voiture à modifier
        $sql = "SELECT * FROM voitures WHERE NumImmatriculation = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            $NumImmatriculation = $row['NumImmatriculation'];
            $marque = $row['Marque'];
            $model = $row['Model'];
            $annee = $row['Annee'];
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

        <h1>Modifier la Voiture :</h1>

        <form method="post">

            <div class="NumImmatriculation">
                <label for="NumImmatriculation">Numéro d'Immatriculation :</label>
                <input type="text" name="NumImmatriculation" value="<?php echo $NumImmatriculation; ?>" readonly>
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
                <input type="text" name="Annee" value="<?php echo $annee; ?>">
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
