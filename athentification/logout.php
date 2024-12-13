<?php
// Supprimer les cookies en les réinitialisant à une date passée
setcookie('token', '', time() - 3600, '/'); // Expire immédiatement
// Redirection vers la page d'accueil ou une autre page
header('Location: /athentification/login.php');
exit;
?>
