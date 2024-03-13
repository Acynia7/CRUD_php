<?php
    function connect(){
            $servername="localhost"; // Nom du serveur
            $username="root"; // Utilisateur
            $password="root"; // Mot de passe
            $dbname="login"; // Nom de la base de données

            try{
                $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password); // Effectue la connexion à la base de données
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $conn; // Retourne la connexion
            }
            catch (PDOException $e){
                return null; // Retourne null en cas d'échec de connexion
            }
    }
?>