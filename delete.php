<?php
// Vérifier si l'utilisateur est connecté
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php"); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

if(isset($_GET['id'])) {
    $id = $_GET['id'];
}

include ('includes/db.php');
$conn = connect();

if(!empty($_GET['id']) && is_numeric($_GET['id'])) {

    $id = $_GET['id'];

    $sql = "DELETE FROM `login` WHERE id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->execute(array($id));

    header("Location: welcome.php");
    exit;
}

else {
    echo "ID incorrect!";
}
?>