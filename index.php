

<?php
    include "./athentification/userValidation.php";
    include "./configuration/connection.php";
    $user = userValidation($conn);
    if(!$_COOKIE['token']) {
        header("Location: http://localhost:3000/athentification/login.php");
    }
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarFlex</title>
    <link     rel="stylesheet" href="/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

</head>
<body>
<nav class="navbar" id="desktop">
        <div class="logo"><a href="/index.php"><img src="/img/CarFlex.png" alt=""></a></div>
       
        <div class="login">
            <div class="logo-login">
                <?php
                if (isset($_COOKIE['token'])) {
                    // L'utilisateur est connecté
                    echo '<p >Bonjour, ' . htmlspecialchars( $user['nom']) . ' | <a class="deconnect" href="athentification/logout.php">Se déconnecter</a></p>';
                } else {
                    // L'utilisateur n'est pas connecté
                    echo '<p ><a href="/athentification/login.php"><i class="fa-solid fa-right-to-bracket fa-2x" style="color: #19191a;"></i></a></p>';
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
                    echo '<p >Bonjour, ' . htmlspecialchars($_COOKIE['nom']) . ' | <a class="deconnect" href="athentification/logout.php">Se déconnecter</a></p>';
                } else {
                    echo '<p ><a href="/athentification/login.php"><i class="fa-solid fa-right-to-bracket fa-2x" style="color: #19191a;"></i></a></p>';
                }
                ?>
            </div>
            <div class="burgerMenu">
            <button><i class="fa-solid fa-bars fa-2x" style="color: #0d0d0d;"></i></button>
        </div>
        </div>
       
    </nav>
    
  <div class="home-page">
  <section class="hero">
    <div class="hero-content">
        <h1>Louez une voiture pour votre prochaine aventure</h1>
        <p>Choisissez parmi une large gamme de véhicules disponibles.</p>
        <a href="#reservation" class="btn">Réservez maintenant</a>
    </div>
</section>

<section class="search-form" id="reservation">
    <h2>Trouver votre voiture en quelques clics</h2>
    <form>
        <input type="date" name="start-date" placeholder="Date de début" required>
        <input type="date" name="end-date" placeholder="Date de fin" required>
        <input type="text" name="location" placeholder="Lieu de prise en charge" required>
        <button type="submit" class="btn">Rechercher</button>
    </form>
</section>

<section class="featured-cars">
    <h2>Nos voitures populaires</h2>
    <div class="car-list">
        <div class="car-item">
            <img src="/img/car1.jpg" alt="Voiture 1">
            <h3>Voiture 1</h3>
            <p>À partir de 50€/jour</p>
            <a href="/reservation.php" class="btn">Réservez maintenant</a>
        </div>
        <div class="car-item">
            <img src="/img/car2.jpg" alt="Voiture 2">
            <h3>Voiture 2</h3>
            <p>À partir de 70€/jour</p>
            <a href="/reservation.php" class="btn">Réservez maintenant</a>
        </div>
        <div class="car-item">
            <img src="/img/car3.jpg" alt="Voiture 3">
            <h3>Voiture 3</h3>
            <p>À partir de 90€/jour</p>
            <a href="/reservation.php" class="btn">Réservez maintenant</a>
        </div>
    </div>
</section>

<section class="why-choose-us">
    <h2>Pourquoi choisir CarFlex ?</h2>
    <div class="benefits">
        <div class="benefit">
            <h3>Fiabilité</h3>
            <p>Toutes nos voitures sont vérifiées et en parfait état de marche.</p>
        </div>
        <div class="benefit">
            <h3>Service client 24/7</h3>
            <p>Notre équipe est disponible à tout moment pour répondre à vos besoins.</p>
        </div>
        <div class="benefit">
            <h3>Prix compétitifs</h3>
            <p>Des prix transparents et abordables, sans frais cachés.</p>
        </div>
    </div>
</section>

<footer>
    <p>&copy; 2024 CarFlex - Location de voitures. Tous droits réservés.</p>
</footer>
  </div>
<script src="/app.js"></script>

</body>
</html>

