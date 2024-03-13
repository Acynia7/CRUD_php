<?php
// Vérifier si l'utilisateur est connecté
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php"); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

// Vérifier si l'ID est défini dans l'URL
if(isset($_GET['id'])) {
    $id = $_GET['id'];
} 
?>

<!DOCTYPE html>
<html>
<head>
    <title> Modifier l'utilisateur </title>
    <link rel="stylesheet" href="assets/styles2.css">
</head>
<body>
    <h1 class="create"> Modification de l'utilisateur </h1>

    <form class="create" action="modif.php?id=<?php echo $id ?>" method="post">
        Nouveau nom d'utilisateur: <br>
        <input type="text" name="login"></input> <br> <br>

        Nouveau mot de passe: <br>
        <input type="password" name="mdp1"></input> <br> <br>

        Confirmer le mot de passe: <br>
        <input type="password" name="mdp2"></input> <br> <br>

        <!-- Ajouter un champ caché pour l'ID de l'utilisateur -->
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>"></input>

        <input type="submit" name="send" value="Modifier"> <br> <br>
    </form>
</body>  
</html>

<?php

if (!empty($_POST)) {
    include ('includes/db.php');
    $conn = connect();

    // Vérification de la correspondance des mots de passe
    if ($_POST['mdp1'] != $_POST['mdp2']) {
        echo "Les mots de passe ne correspondent pas.";
        exit(); // Sortir du script si les mots de passe ne correspondent pas
    }

    // Vérification si le nom d'utilisateur existe déjà
    $login = $_POST['login'];
    $sql = "SELECT COUNT(*) AS count FROM `login` WHERE login = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$login]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        echo "Nom d'utilisateur déjà existant.";
        exit(); // Sortir du script si le nom d'utilisateur existe déjà
    }

    // Hashage sécurisé du mot de passe
    $password = password_hash($_POST['mdp1'], PASSWORD_DEFAULT);
    
    // Utilisez une requête UPDATE pour mettre à jour le nom d'utilisateur et le mot de passe
    $sql2 = "UPDATE login SET login = ?, password = ? WHERE id = ?";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->execute([$login, $password, $id]);
    header("Location: welcome.php");
    exit();
}
?>