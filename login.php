<!DOCTYPE html>
<html>
    <head>
        <title> Login </title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="assets/styles.css">
    </head>

    <body>
        <form action="login.php" method="POST">
            <p> Bonjour, veuillez vous identifier </p>
            Login: <br>
            <input type="text" name="login" placeholder="Entrer le nom d'utilisateur"> <br> <br>

            Password: <br>
            <input type="password" name="mdp" placeholder="Entrer le mot de passe"> <br> <br>

            <input type="submit" name="send" value="Envoyer"> <br> <br>
        </form>
        <p class="text">Pas de compte? <a href="register.php">Créer un compte </a> </p>

    </body>
</html>

<?php
    session_start();
    if (!empty($_POST)) {
        
        include ('includes/db.php');
        $conn = connect();

        
        $username = $_POST['login'];
        $password = $_POST['mdp'];

        
        $req = "SELECT login, password FROM login WHERE login=:login";
        $stmt = $conn->prepare($req);
        $stmt->bindParam(':login', $username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && password_verify($password, $result['password'])) {
            
            $_SESSION['login'] = $username;
            header("Location: welcome.php");
            exit; // Assure que le script s'arrête ici
        }  
        else 
        {
            echo "<p class=text> /!\ Nom d'utilisateur ou mot de passe incorrect. </p>";
        }

        $conn = null; 
    }
?>
