<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarFlex</title>
</head>
<body>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Connexion</title>
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

    <div class="container1">
    
       <div class="inter-container">
         
       <form action="#" method="POST">
        <h2>Inscription</h2>
            <div class="input-group">
                <label for="username">Nom complet</label>
                <input type="text" id="username" name="username" required placeholder="Votre nom complet">
            </div>

            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required placeholder="Votre adresse email">
            </div>

            <div class="input-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required placeholder="Votre mot de passe">
            </div>

            <div class="input-group">
                <label for="confirm-password">Confirmer le mot de passe</label>
                <input type="password" id="confirm-password" name="confirm-password" required placeholder="Confirmer le mot de passe">
            </div>

            <button type="submit" class="btn">S'inscrire</button>

            <p class="login-link">Vous avez déjà un compte ? <a href="login.html">Connectez-vous</a></p>
        </form>
       </div>
    </div>

    <script>
        // Validation basique du formulaire
        const form = document.getElementById('signup-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            let valid = true;

            // Validation du nom d'utilisateur
            const username = document.getElementById('username');
            const usernameError = document.getElementById('username-error');
            if (username.value.trim() === '') {
                valid = false;
                usernameError.style.display = 'block';
            } else {
                usernameError.style.display = 'none';
            }

            // Validation de l'email
            const email = document.getElementById('email');
            const emailError = document.getElementById('email-error');
            const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            if (!emailRegex.test(email.value)) {
                valid = false;
                emailError.style.display = 'block';
            } else {
                emailError.style.display = 'none';
            }
            

            // Validation du mot de passe
            const password = document.getElementById('password');
            const passwordError = document.getElementById('password-error');
            if (password.value.trim() === '') {
                valid = false;
                passwordError.style.display = 'block';
            } else {
                passwordError.style.display = 'none';
            }

            // Validation de la confirmation du mot de passe
            const confirmPassword = document.getElementById('confirm-password');
            const confirmPasswordError = document.getElementById('confirm-password-error');
            if (confirmPassword.value !== password.value) {
                valid = false;
                confirmPasswordError.style.display = 'block';
            } else {
                confirmPasswordError.style.display = 'none';
            }

            // Si le formulaire est valide
            if (valid) {
                alert('Inscription réussie!');
                // Ici, vous pouvez ajouter la logique pour envoyer les données à votre serveur
            }
        });
    </script>
</body>

</html>