<?php
// Vérifier si l'utilisateur est connecté
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php"); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}
?>

<!doctype html>
<html>
    <head>
        <title> Création </title>
        <link rel="stylesheet" href="assets/styles2.css">
    </head>

    <body>
        <h1 class="create"> Création d'un nouveau compte </h1>

        <form class="create" action="add.php" method="post">
            Nom d'utilisateur: <br>
            <input type="text" name="login"></input> <br> <br>

            Mot de passe: <br>
            <input type="password" name="mdp"></input> <br> <br>

            <input type="submit" name="send" value="Créer"> <br> <br>
        </form>
    </body>


<?php

if(!empty($_POST)){
    include ('includes/db.php');
    $conn = connect();

    $_POST['mdp'] = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

    $req = $conn->prepare("INSERT INTO `login` (`Login`, `Password`) VALUES (:login, :mdp);");

    $login = $_POST['login'];
    $mdp = $_POST['mdp'];

    // Liaison des paramètres
    $req -> bindParam(':login', $login);
    $req -> bindParam(':mdp', $mdp);

    // Exécution de la requête
    $result = $req -> execute();

    if ($result){
            header("location: welcome.php");
    }
        else {
            echo "Erreur lors de la création de compte";
    }
}
?>