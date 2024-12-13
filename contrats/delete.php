<?php 
    include("C:/Users/ycode/location-de-voitures/configuration/connection.php");

        if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
        $id = $_GET["id"];

                $deleteContratSql = "DELETE FROM contrat WHERE Num = ?";
        $stmt = $conn->prepare($deleteContratSql);
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            echo "Erreur lors de la suppression des contrats : " . $stmt->error;
            exit;
        }

                $deleteClientSql = "DELETE FROM clients WHERE Num = ?";
        $stmt = $conn->prepare($deleteClientSql);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
                        header("Location: /contrats/contrat.php");
            exit;
        } else {
                        echo "Erreur lors de la suppression du client : " . $stmt->error;
        }

                $stmt->close();
    } else {
                header("Location: /contrats/contrat.php");
        exit;
    }

        $conn->close();
?>
