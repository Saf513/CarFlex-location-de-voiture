<?php
    include("C:/Users/ycode/location-de-voitures/configuration/connection.php");

    if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
        $id = $_GET["id"];

        $deleteContratSql = "DELETE FROM contrat WHERE Num = ?";
        $stmt = $conn->prepare($deleteContratSql);
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            echo "Erreur : " . $stmt->error;
            exit;
        }

        $deleteClientSql = "DELETE FROM clients WHERE Num = ?";
        $stmt = $conn->prepare($deleteClientSql);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            header("Location: /Clients/clients.php");
            exit;
        } else {
            echo "Erreur : " . $stmt->error;
        }

        $stmt->close();
    } else {
       
        header("Location: /Clients/clients.php");
        exit;
    }


    $conn->close();
?>
