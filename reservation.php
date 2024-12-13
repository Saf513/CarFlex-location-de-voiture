<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $name = $_POST['name'];
    $email = $_POST['email'];
    $car_model = $_POST['car_model'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Ajouter une logique de traitement ici (par exemple, insertion dans la base de données)

    // Exemple de message de confirmation (vous pouvez remplacer cela par une insertion dans la base de données)
    echo "<p>Réservation effectuée avec succès !</p>";
    echo "<p>Nom: $name</p>";
    echo "<p>Email: $email</p>";
    echo "<p>Voiture réservée: $car_model</p>";
    echo "<p>Date de début: $start_date</p>";
    echo "<p>Date de fin: $end_date</p>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation de Voiture</title>
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
                    echo '<p >Bonjour, ' . htmlspecialchars($_COOKIE['nom']) . ' | <a class="deconnect" href="athentification/logout.php">Se déconnecter</a></p>';
                } else {
                    // L'utilisateur n'est pas connecté
                    echo '<p  ><a href="athentification\login.php"><i class="fa-solid fa-right-to-bracket fa-2x" style="color: #19191a;"></i></a></p>';
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
                    // L'utilisateur est connecté
                    echo '<p >Bonjour, ' . htmlspecialchars($_COOKIE['nom']) . ' | <a class="deconnect" href="athentification/logout.php">Se déconnecter</a></p>';
                } else {
                    // L'utilisateur n'est pas connecté
                    echo '<p  ><a href="athentification\login.php"><i class="fa-solid fa-right-to-bracket fa-2x" style="color: #19191a;"></i></a></p>';
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