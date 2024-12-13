

<?php
    include "./configuration/connection.php";
    include "./athentification/userValidation.php";

    if(!$_COOKIE['token']) {
        header("Location: http://localhost:3000/athentification/login.php");
    }
    $user = userValidation($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation de Voiture</title>
    <link rel="stylesheet" href="/reservation.css">
    <link rel="stylesheet" href="/style.css">
</head>

<body>
    <nav class="navbar" id="desktop">
        <div class="logo"><a href="/index.php"><img src="/img/CarFlex.png" alt=""></a></div>
        

        <div>
            <?php  ?>
            <p style="margin-right: 30px;">Bienvenue, <?php echo $user['nom'] ?? ''; ?> | <a href="athentification\logout.php">Se déconnecter</a></p>
        </div>
    </nav>
    

    <section>
        <div class="container">
            <h1>Réservez votre voiture</h1>
            <form action="" method="POST">
                <div class="input-group">
                    <label for="name">Nom complet :</label>
                    <input type="text" id="name" name="name" required placeholder="Entrez votre nom">
                </div>
                <div class="input-group">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" required placeholder="Entrez votre email">
                </div>
                <div class="input-group">
                    <label for="car_model">Modèle de la voiture :</label>
                    <select id="car_model" name="car_model" required>
                        <option value="">Sélectionner une voiture</option>
                        <option value="Toyota Camry">Toyota Camry</option>
                        <option value="Honda Civic">Honda Civic</option>
                        <option value="BMW 3 Series">BMW 3 Series</option>
                        <option value="Audi A4">Audi A4</option>
                    </select>
                </div>
                <div class="input-group">
                    <label for="start_date">Date de début :</label>
                    <input type="date" id="start_date" name="start_date" required>
                </div>
                <div class="input-group">
                    <label for="end_date">Date de fin :</label>
                    <input type="date" id="end_date" name="end_date" required>
                </div>
                <button type="submit">Réserver</button>
            </form>
        </div>
    </section>
    <script src="/app.js"></script>

</body>

</html>