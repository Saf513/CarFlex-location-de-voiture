<?php
setcookie('token', '', time() - 3600, '/'); header('Location: /athentification/login.php');
exit;
?>
