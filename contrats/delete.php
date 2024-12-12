<?php 
    include("C:/Users/ycode/location-de-voitures/configuration/connection.php");

    // Vérifier si le paramètre "id" est défini et s'il est numérique
    if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
        $id = $_GET["id"];

        // Étape 1 : Supprimer d'abord les contrats associés dans la table "contrat"
        $deleteContratSql = "DELETE FROM contrat WHERE Num = ?";
        $stmt = $conn->prepare($deleteContratSql);
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            echo "Erreur lors de la suppression des contrats : " . $stmt->error;
            exit;
        }

        // Étape 2 : Supprimer le client de la table "clients"
        $deleteClientSql = "DELETE FROM clients WHERE Num = ?";
        $stmt = $conn->prepare($deleteClientSql);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            // Rediriger vers la page des clients après la suppression réussie
            header("Location: /contrats/contrat.php");
            exit;
        } else {
            // Si une erreur se produit, afficher l'erreur
            echo "Erreur lors de la suppression du client : " . $stmt->error;
        }

        // Fermer la requête préparée
        $stmt->close();
    } else {
        // Si "id" n'est pas défini ou n'est pas numérique, rediriger vers la page des clients
        header("Location: /contrats/contrat.php");
        exit;
    }

    // Fermer la connexion à la base de données
    $conn->close();
?>
