<?php
            $servername = 'localhost';
            $username = 'root';
            $password = 'root';
            $dbname = "location-voitures";
            
         
            $conn = new mysqli($servername, $username, $password,$dbname);
            
         
            if($conn->connect_error){
                die('Erreur : ' .$conn->connect_error);
            }
        ?>