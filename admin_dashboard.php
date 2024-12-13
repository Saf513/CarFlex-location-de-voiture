<?php
    include "./configuration/connection.php";
    include "./athentification/userValidation.php";

    if(!$_COOKIE['token']) {
        header("Location: http://localhost:3000/athentification/login.php");
    }
    $user = userValidation($conn);
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        
:root {
    --orange: #ff7f00;
    --noir: #19191a;
    --blanc: #ffffff;
    --gris-clair: #f4f4f4;
    --gris-foncé: #333333;
}

/* Style global du corps de la page */
body {
    font-family: 'Arial', sans-serif;
    background-color: var(--gris-clair);
    margin: 0;
    padding: 0;
    color: var(--gris-foncé);
}

/* Navbar */
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: var(--noir);
    color: var(--blanc);
    width: 100%;
    padding-top: 10px;
    padding-bottom: 15px;
}

.navbar h2 {
    font-size: 24px;
    font-weight: bold;
}

.navbar p {
    font-size: 16px;
}

.navbar a {
    color: var(--orange);
    text-decoration: none;
    font-weight: bold;
}

.navbar a:hover {
    text-decoration: underline;
}

/* Conteneur principal du tableau de bord */
.container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    padding: 40px;
    background-color: var(--blanc);
}

/* Card (Boîte contenant chaque section du tableau de bord) */
.card {
    background-color: var(--orange);
    color: var(--blanc);
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.15);
}

.card h3 {
    font-size: 22px;
    margin-bottom: 15px;
}

.card p {
    font-size: 16px;
    margin-bottom: 20px;
}

.card a {
    color: var(--blanc);
    text-decoration: none;
    background-color: var(--noir);
    padding: 10px 20px;
    border-radius: 5px;
    font-weight: bold;
}

.card a:hover {
    background-color: var(--orange);
    color: var(--noir);
}

/* Footer */
footer {
    background-color: var(--noir);
    color: var(--blanc);
    text-align: center;
    padding: 20px;
    position: fixed;
    width: 100%;
    bottom: 0;
}

footer p {
    font-size: 14px;
}

/* Mobile responsive */
@media (max-width: 768px) {
    .container {
        grid-template-columns: 1fr;
        padding: 20px;
    }

    .navbar {
        flex-direction: column;
        text-align: center;
    }

    .card {
        padding: 15px;
    }
}

    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div>
            <h2>CarFlex Admin</h2>
        </div>
        <div>
            <?php  ?>
            <p style="margin-right: 30px;">Bienvenue, <?php echo $user['nom'] ?? ''; ?> | <a href="athentification\logout.php">Se déconnecter</a></p>
        </div>
    </nav>

    <!-- Tableau de bord -->
    <div class="container">
        <!-- Section Voitures -->
        <div class="card">
            <h3>Gestion des Voitures</h3>
            <p>Ajoutez, modifiez ou supprimez des voitures disponibles à la location.</p>
            <a href="/voitures/voitures.php">Accéder à la gestion des voitures</a>
        </div>

        <!-- Section Clients -->
        <div class="card">
            <h3>Gestion des Clients</h3>
            <p>Gérez les clients inscrits et consultez leurs informations.</p>
            <a href="/Clients/clients.php">Accéder à la gestion des clients</a>
        </div>

        <!-- Section Contrats -->
        <div class="card">
            <h3>Gestion des Contrats</h3>
            <p>Visualisez et gérez les contrats de location des voitures.</p>
            <a href="/contrats/contrat.php">Accéder à la gestion des contrats</a>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 CarFlex - Tableau de bord administrateur</p>
    </footer>

</body>

</html>