    <?php echo "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><meta http-equiv='X-UA-Compatible' content='IE=edge'><meta name='viewport' content='width=device-width, initial-scale=1.0'><title>Consulta DB</title><link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD' crossorigin='anonymous'><script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js' integrity='sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN' crossorigin='anonymous'></script><style>body{background-color:#545a6b;color:white;} ul{list-style:none;}</style></head><body>";
    if (!isset($_GET['send'])) {
        if (isset($_GET['consultar'])) {
            if(str_contains($_GET['consultar'], 'INSERT') || str_contains($_GET['consultar'], 'UPDATE') || str_contains($_GET['consultar'], 'DELETE')){
                echo "Mal";
            }
            $host = $_GET['hostdb'];
            $user = $_GET['userdb'];
            $password = $_GET['passdb'];
            $dbName = $_GET['namedb'];
            $connection = mysqli_connect($host, $user, $password, $dbName);
            $consultUserSQL = $_GET['consulta'];
            $tablesSQL = "SHOW TABLES;";
            try {
                $selects = mysqli_query($connection, $consultUserSQL);
                $tablesDB = mysqli_query($connection, $tablesSQL);
                echo "<div class='container'>";
                echo "<div class='row' style='background-color:gray;color:white;'>";
                echo '<h2 class="justify-content-center d-flex col-12 mt-2 p-4 shadow" style="background-color:gray;color:white;">INFORMATION AND DATABASE CONSULTS  </h2>';
                echo '<div class="d-flex col-12 justify-content-center shadow mb-4">';
                echo "<table class='table table-dark text-center'>";
                if(!str_contains($_GET['consulta'], "INSERT") || !str_contains($_GET['consulta'], "UPDATE") || !str_contains($_GET['consulta'], "DELETE")){
                    while ($select = mysqli_fetch_row($selects)) {
                    echo "<tr >";
                    for ($i = 0; $i < sizeof($select); $i++) {
                        echo "<td>" . $select[$i] . "</td>";
                    }
                    echo "</tr>";
                }
                }else{
                    header("");
                }
                echo "</table>";
                echo '</div>';
                echo '<div class="d-flex col-12 justify-content-center shadow mb-4" style="background-color:gray;color:black;">';
                echo '<form action="" method="GET" class="col-12 mb-5">';
                echo '<label for="consulta" class="form-label"></label>';
                echo '<textarea class="form-control" name="consulta" rows="5" 
                placeHolder="' . $_GET['consulta'] . '"></textarea>';
                echo '<input type="hidden" value="' . $host . '" name="hostdb">';
                echo '<input type="hidden" value="' . $user . '" name="userdb">';
                echo '<input type="hidden" value="' . $password . '" name="passdb">';
                echo '<input type="hidden" value="' . $dbName . '" name="namedb">';
                echo '<div class="d-flex col-12 justify-content-center shadow">';
                echo '<input type="submit" class="btn btn-dark w-100 mt-5" name="consultar" value="New consult">';
                echo '</div>';
                echo '</form>';
                echo '</div>';
                echo "</div>";
                $i = 1;
                echo "<div class='row'>";
                while ($table = mysqli_fetch_assoc($tablesDB)) { ?>
                    <ul class='col-6 border shadow mb-2 p-4 justify-content-center d-flex'>
                        <li> <b>Table: &nbsp;<?php echo $table["Tables_in_" . $_GET['namedb']]; ?></b>
                            <ol class='shadow p-5'>
                                <?php $describeTable = "DESCRIBE " . $table["Tables_in_" . $_GET['namedb']] . ";";
                                $tablesInfo = mysqli_query($connection, $describeTable);
                                while ($tableInfo = mysqli_fetch_assoc($tablesInfo)) {
                                    if ($tableInfo["Key"] == "PRI") {
                                        echo "<li class=''> " . $tableInfo["Field"] . " <b>*PK*</b></li>";
                                    }
                                    if ($tableInfo["Key"] == "MUL") {
                                        echo "<li class=''>" . $tableInfo["Field"] . " <b>*FK*</b></li>";
                                    }
                                    if ($tableInfo["Key"] == "") {
                                        echo "<li class=''>" . $tableInfo["Field"] . "</li>";
                                    }
                                } ?></ol>
                        </li>
                    </ul>
    <?php }
                echo "</div>";
            } catch (Exception $e) {
                echo "<div class='container'>";
                echo "<p class='justify-content-center d-flex mt-5 shadow border p-5 strong'>Consulta introducida incorrecta.</p>";
                echo '<div class="d-flex col-12 justify-content-center shadow mb-4">';
                echo '<form action="" method="GET" class="col-12 mb-5">';
                echo '<label for="consulta" class="form-label"></label>';
                echo '<textarea class="form-control" name="consulta" rows="5" 
                placeHolder="' . $_GET['consulta'] . '"></textarea>';
                echo '<input type="hidden" value="' . $host . '" name="hostdb">';
                echo '<input type="hidden" value="' . $user . '" name="userdb">';
                echo '<input type="hidden" value="' . $password . '" name="passdb">';
                echo '<input type="hidden" value="' . $dbName . '" name="namedb">';
                echo '<div class="d-flex col-12 justify-content-center shadow">';
                echo '<input type="submit" class="btn btn-dark w-100 mt-5" name="consultar" value="New consult">';
                echo '</div>';
                echo '</form>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "<div class='container'>";
            echo '<div class="d-flex justify-content-center shadow">';
            echo '<form action="" method="GET">';
            echo '<label for="user" class="form-label">User: </label>';
            echo '<input type="text" class="form-control" name="user">';
            echo '<label for="password" class="form-label">Password: </label>';
            echo '<input type="text" class="form-control" name="password">';
            echo '<label for="dbName" class="form-label">Database name: </label>';
            echo '<input type="text" class="form-control" name="dbName">';
            echo '<input type="submit" class="btn btn-success" name="send">';
            echo '</form>';
            echo '</div>';
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
    echo "</body></html>";
    ?>