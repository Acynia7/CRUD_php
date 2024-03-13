<!doctype html>
<html>
    <head>
        <title> Enregistrement </title>
        <link rel="stylesheet" href="assets/styles.css">
    </head>

    <body>
        <form action="register.php" method="POST">
            <p> Bonjour, veuillez créer un compte </p>
            Login: <br>
            <input type="text" name="login" placeholder="Entrer le nom d'utilisateur"></input> <br> <br>

            Password: <br>
            <input type="password" name="mdp" placeholder="Entrer le mot de passe"></input> <br> <br>

            <input type="submit" name="send" value="Créer"> <br> <br>
        </form>

    </body>
    <?php
        if (!empty($_POST)){
            include ('includes/db.php');
            $conn = connect();
            
            // Transformation du mot de passe en hash
            $_POST['mdp'] = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

            // Préparation de la requête
            $req = $conn->prepare("INSERT INTO `login` (`Login`, `Password`) VALUES (:login, :mdp);");
            
            // Récupération des données du formulaire
            $login = $_POST['login'];
            $mdp = $_POST['mdp'];

            // Liaison des paramètres
            $req -> bindParam(':login', $login);
            $req -> bindParam(':mdp', $mdp);

            // Exécution de la requête
            $result = $req -> execute();

            if ($result)
            {
                header("location: welcome.php");
            }
            else {
                echo "Erreur lors de la création de compte";
            }
        }
    ?>
</html>