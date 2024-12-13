
<?php
    include "../configuration/connection.php";
    include "../athentification/userValidation.php";

    if(!$_COOKIE['token']) {
        header("Location: http://localhost:3000/athentification/login.php");
    }
    $user = userValidation($conn);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="wNumth=device-wNumth, initial-scale=1.0">
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
        <div>
            <?php  ?>
            <p style="margin-right: 30px;">Bienvenue, <?php echo $user['nom'] ?? ''; ?> | <a href="athentification\logout.php">Se déconnecter</a></p>
        </div>

        
    </nav>
   
    <div>
            <ul class="section" id="section-burger">
                <li><a href="/voitures/voitures.php">Voitures</a></li>
                <li><a href="/Clients/clients.php">Clients</a></li>
                <li><a href="/contrats/contrat.php">Contrats</a></li>
            </ul>
        </div>
    <section>
        <div class="container">
           <div class="entete">
           <h1>Liste des clients:</h1>
           <button><a href="/contrats/create.php">ajouter une contrat</a></button>
           </div>
            <table>
                <thead>
                    <tr>
                        <th>Num de Contrat</th>
                        <th>Date De Debut</th>
                        <th>Date De Fin</th>
                        <th>Duree</th>
                        <th>Num de Client</th>
                        <th>Num d'Immatriculation</th>
                        <th>Supprimer</th>
                        <th>Modifier</th>
                    </tr>
                </thead>
                <tbody>
                <?php
    include("C:/Users/ycode/location-de-voitures/configuration/connection.php");

    $sql = "SELECT * FROM contrat";
    $result = $conn->query($sql);

    if (!$result) {
        die('Erreur : ' . $conn->connect_error);
    }

    while ($row = $result->fetch_assoc()) {
        
        echo "
        <tr>
            <td>{$row['NumContrat']}</td>
            <td>{$row['DateDebut']}</td>
            <td>{$row['DateFin']}</td>
            <td>{$row['Duree']}</td>
            <td>{$row['Num']}</td>
            <td>{$row['NumImmatriculation']}</td>
            <td>
                <a href='/contrats/delete.php?id={$row['NumContrat']}'>Supprimer</a>
            </td>
            <td>
                <a href='/contrats/update.php?id={$row['NumContrat']}'>Modifier</a>
            </td>
        </tr>
        ";
    }
?>

                </tbody>
            </table>
        </div>
    </section>
</body>

</html>