<?php
include("C:/Users/ycode/location-de-voitures/configuration/connection.php");

if (isset($_GET["id"]) && is_string($_GET["id"])) {
    $id = $_GET["id"];

    $deleteContratSql = "DELETE FROM contrat WHERE NumImmatriculation = ?";
    $stmt = $conn->prepare($deleteContratSql);

    if (!$stmt) {
        echo "Erreur de préparation de la requête : " . $conn->error;
        exit;
    }

    $stmt->bind_param("s", $id);
    if (!$stmt->execute()) {
        echo "Erreur lors de la suppression des contrats : " . $stmt->error;
        $stmt->close();
        exit;
    }

    $deleteVoitureSql = "DELETE FROM voitures WHERE NumImmatriculation = ?";
    $stmt = $conn->prepare($deleteVoitureSql);

    if (!$stmt) {
        echo "Erreur de préparation de la requête : " . $conn->error;
        exit;
    }

    $stmt->bind_param("s", $id);
    if ($stmt->execute()) {
        header("Location: /voitures/voitures.php");
        exit;
    } else {
        echo "Erreur lors de la suppression de la voiture : " . $stmt->error;
    }

    $stmt->close();
} else {
    header("Location: /voitures/voitures.php");
    exit;
}

$conn->close();
