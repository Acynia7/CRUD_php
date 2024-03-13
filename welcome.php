<?php
// Vérifier si l'utilisateur est connecté
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php"); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue</title>
    <link rel="stylesheet" href="assets/styles.css">

</head>
<body>

<div class="container">
    <h1>Bienvenue, <?php echo $_SESSION['login']; ?> !</h1>
    <br/>
    <br/>
</div>
    <div class="logout">
        <a href="logout.php">Déconnexion</a>
    </div>
    <br/>

<div class="add">
    <a href="add.php">Créer</a>
    <br/>
</div>
<br/>

<?php
    include ('includes/db.php');
    $conn = connect();

    $req1= "SELECT id, login FROM login";
    $stmt1 = $conn->prepare($req1);
    $stmt1->execute();
    $result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
?>

<table class="table">
<thead>
    <tr>
        <th>Identifiant</th>
        <th>Modifier</th>
        <th>Supprimer</th>
    </tr>
</thead>

<tbody>
    <?php
    foreach($result1 as $row){
        echo "<tr>";
        echo "<td>" . $row['login'] . "</td>";
        ?>
        <td>
        <a href="modif.php?id=<?php echo $row['id']; ?>"> <img class='modif' src='assets/modif.png' style='width:20px;height:20px'> </a>
        </td>
        <td>
        <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')"> <img class='supp' src='assets/supprimer.png' style='width:25px;height:25px'>
            <i class="fas fa-trash-alt"></i>
        </a>
        </td>
    <?php
    }
    ?>
</tbody>
</table>
</body>
</html>

