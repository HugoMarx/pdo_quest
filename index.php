<?php
header("HTTP/1.1");

require_once('_connec.php');

$pdo = new pdo(DSN, USER, PASS);

$query = 'SELECT * FROM friend';
$statement = $pdo->query($query);
$results = $statement->fetchAll();



?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friends PDO</title>
</head>

<body>
    <h2>Friends in Database : </h2>
    <ul>
        <?php

        foreach ($results as $friends) {
            echo '<li>' . $friends['firstname'] . ' ' . $friends['lastname'] . '</li>';
        }
        ?>
    </ul>

    <h3>Add friends to DB</h3>
    <form method="POST">
        <label for="firstname">Firstname</label>
        <input type="text" name="firstname" required>
        <label for="lastname">Lastname</label>
        <input type="text" name="lastname" required>

        <input type="submit" value="Add">

    </form>

    <?php
    
    if (isset($_POST) && @$_POST['firstname'] != '' ){
        
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];

        $addfriend = "INSERT INTO friend (firstname, lastname)
        VALUES (:firstname, :lastname)";
        $statement_1 = $pdo->prepare($addfriend);

        $statement_1->bindValue(':firstname', $firstname);
        $statement_1->bindValue(':lastname', $lastname);

        $statement_1->execute();

        echo '<h1>Request successfull</h1>';
        header('Location: /index.php');
    } 


    
    ?>

</body>

</html>