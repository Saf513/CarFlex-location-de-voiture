
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
    <style></style>
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
    <section>
        <div class="container">
           <div class="entete">
           <h1>Liste des clients:</h1>
           <button><a href="/Clients/create.php">ajouter un clients</a></button>
           </div>
            <table>
                <thead>
                    <tr>
                        <th>Num</th>
                        <th>Nom</th>
                        <th>Adresse</th>
                        <th>Telephone</th>
                        <th>Supprimer</th>
                        <th>Modifier</th>
                    </tr>
                </thead>
                <tbody>
                <?php
    include("C:/Users/ycode/location-de-voitures/configuration/connection.php");

    $sql = "SELECT * FROM clients";
    $result = $conn->query($sql);

    if (!$result) {
        die('Erreur : ' . $conn->connect_error);
    }

    while ($row = $result->fetch_assoc()) {
        echo "
        <tr>
            <td>{$row['Num']}</td>
            <td>{$row['Nom']}</td>
            <td>{$row['Adresse']}</td>
            <td>{$row['Tel']}</td>
            <td>
                <a href='/Clients/delete.php?id={$row['Num']}'>Supprimer</a>
            </td>
            <td>
                <a href='/Clients/update.php?id={$row['Num']}'>Modifier</a>
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