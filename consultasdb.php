<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta DB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</head>

<body>
    <?php
    if (!isset($_GET['send'])) {
        if (isset($_GET['consultar'])) {
            $host = $_GET['hostdb'];
            $user = $_GET['userdb'];
            $password = $_GET['passdb'];
            $dbName = $_GET['namedb'];
            $connection = mysqli_connect($host,$user,$password,$dbName);
            $sql = $_GET['consulta'];
            try{
                $selects = mysqli_query($connection, $sql);
                echo '<h2 class="justify-content-center d-flex">Your consult: </h2>';
                $i = 1;
                while ($select = mysqli_fetch_assoc($selects)) {
                echo '<p class="justify-content-center d-flex"> ID = '.($i+$i)."Retorna->". $selects . '</p>';
            }
            }catch(Exception $e){
                echo "Error->".$e;
            }
            
            
           
        } else {
            echo '<div class="d-flex justify-content-center shadow">';
            echo '<form action="" method="GET">';
            echo '<label for="user" class="form-label">Usuario: </label>';
            echo '<input type="text" class="form-control" name="user">';
            echo '<label for="password" class="form-label">Password: </label>';
            echo '<input type="text" class="form-control" name="password">';
            echo '<label for="dbName" class="form-label">Database name: </label>';
            echo '<input type="text" class="form-control" name="dbName">';
            echo '<input type="submit" class="btn btn-success" name="send">';
            echo '</form>';
            echo '</div>';
        }
    } else {
        $host = "localhost";
        $user = $_GET['user'];
        $password = $_GET['password'];
        $dbName = $_GET['dbName'];
        echo '<div class="d-flex justify-content-center shadow">';
        echo '<form action="" method="GET">';
        echo '<label for="consulta" class="form-label">Consulta: </label>';
        echo '<input type="textarea" class="form-control" name="consulta">';
        echo '<input type="hidden" value="' . $host . '" name="hostdb">';
        echo '<input type="hidden" value="' . $user . '" name="userdb">';
        echo '<input type="hidden" value="' . $password . '" name="passdb">';
        echo '<input type="hidden" value="' . $dbName . '" name="namedb">';
        echo '<input type="submit" class="btn btn-success" name="consultar">';
        echo '</form>';
        echo '</div>';
    }
    ?>
    <?php

    ?>
</body>

</html>