<?php
    include "../configuration/connection.php";

function userValidation($conn) {
    $token = $_COOKIE['token'];

    if(isset($token)) {
        $sql = 'SELECT * FROM users WHERE token = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $token);
        $stmt->execute();
    
        $data = $stmt->get_result();
        $user = $data->fetch_assoc();
    
        if($user) {
            return $user;
        } else {
            return null;
        }
    }
}
?>