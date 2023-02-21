<?php echo "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><meta http-equiv='X-UA-Compatible' content='IE=edge'><meta name='viewport' content='width=device-width, initial-scale=1.0'><title>Consulta DB</title><link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD' crossorigin='anonymous'><script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js' integrity='sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN' crossorigin='anonymous'></script><style>@import url('https://fonts.googleapis.com/css2?family=Nunito&display=swap');body{background-color:#545a6b;color:white;font-family: 'Nunito', sans-serif;} ul{list-style:none;}</style></head><body>";

if (isset($_GET['valor'])) {
    echo '<div class="container">';
    echo '<div class="row mt-4">';
    echo '<p style="color:red;" class="justify-content-center d-flex">' . $_GET['valor'] . '</p>';
    echo '</div>';
    echo '</div>';
}
if (isset($_GET['consultar']) || isset($_GET['xmlConsult'])) {

    if (isset($_GET['xmlConsult'])) {
        try {
            if (isset($_GET['valor'])) {
                echo '<div class="row">';
                echo '<p style="color:red;">' . $_GET['valor'] . '</p>';
                echo '</div>';
            }
            $xml = new SimpleXMLElement($_GET['xmlData']);
            echo "<div class='container'>";
            echo '<div class="row">';
            echo '<a style="text-decoration:none;" class="justify-content-center d-flex" href="./consultasdb.php"><img src="https://cdn-icons-png.flaticon.com/512/8244/8244444.png" width="40" height="40"><input type="button" class="btn btn-dark m-1" value="RETURN TO HOME PAGE"></a>';
            echo '</div>';
            echo "<div class='row' style='background-color:gray;color:white;'>";
            echo '<h2 class="justify-content-center d-flex col-12 mt-2 p-4 shadow" style="background-color:gray;color:white;">XML CONSULT RESULTS </h2>';
            echo "<table class='table table-dark text-center'>";
            echo "<tr><th>TYPE ELEMENT</th><th>ELEMENT INFORMATION</th></tr>";
            foreach ($xml->xpath($_GET['consultXPATH']) as $child) {
                echo "<tr>";
                echo "<td>" . gettype($child) . "</td>";
                echo "<td>" . $child . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "</div>";
            echo '<div class="d-flex row justify-content-center shadow mb-4" style="background-color:gray;color:black;">';
            echo '<h2 class="d-flex justify-content-center col-12 shadow" style="background-color:gray;color:white;">XPATH CONSULT XML</h2>';
            echo '<form action="" method="GET">';
            echo '<div class="row">';
            echo '<label for="dbName" class="form-label justify-content-center d-flex">XML TEXT </label>';
            echo "<textarea class='form-control' name='xmlData' rows='6'>" . $_GET['xmlData'] . "</textarea>";
            echo '</div>';
            echo '<div class="row">';
            echo '<label for="consulta" class="form-label justify-content-center d-flex">CONSULT XPATH </label>';
            echo '<input class="form-control" name="consultXPATH" type="text" value=' . $_GET['consultXPATH'] . '>';
            echo '</div>';
            echo '<div class="row mt-3 mb-3">';
            echo '<input type="submit" class="btn btn-success" name="xmlConsult" value="XML CONSULT SEND">';
            echo '</div>';
            echo '</form>';
            echo "</div>";
            echo '<div class="d-flex row justify-content-center shadow mb-4" style="background-color:gray;color:black;">';
            echo '<h2 class="justify-content-center d-flex col-12 mt-2 p-4 shadow" style="background-color:gray;color:white;">XML STRUCTURE </h2>';
            $debug = debug_backtrace();
            echo "<pre>";
            print_r($xml);
            echo "</pre>";
            echo "</div>";
            echo "</div>";
        } catch (Exception $r) {
            header("Location: ./consultasdb.php?valor=You have entered some incorrect data, please try again.");
        }
    } else {
        try {
            $host = $_GET['host'];
            $user = $_GET['user'];
            $password = $_GET['password'];
            $dbName = $_GET['dbName'];
            $connection = mysqli_connect($host, $user, $password, $dbName);
            $consultUserSQL = $_GET['consulta'];
            $tablesSQL = "SHOW TABLES;";
            echo '<div class="row">';
            echo '<a style="text-decoration:none;" class="justify-content-center d-flex" href="./consultasdb.php"><img src="https://cdn-icons-png.flaticon.com/512/8244/8244444.png" width="40" height="40"><input type="button" class="btn btn-dark m-1" value="RETURN TO HOME PAGE"></a>';
            echo '</div>';
            if ($_GET['consulta'] == null) {
                header("Location: ./consultasdb.php?consulta=" . $_GET['consultAnterior'] . "&host=" . $host . "&user=" . $user . "&password=" . $password . "&dbName=" . $dbName . "&consultar=New+consult");
            }
            $selects = mysqli_query($connection, $consultUserSQL);
            $tablesDB = mysqli_query($connection, $tablesSQL);
            echo "<div class='container'>";
            echo "<div class='row' style='background-color:gray;color:white;'>";
            echo '<h2 class="justify-content-center d-flex col-12 mt-2 p-4 shadow" style="background-color:gray;color:white;">INFORMATION AND DATABASE CONSULTS  </h2>';
            echo '<div class="d-flex col-12 justify-content-center shadow mb-4">';
            echo "<table class='table table-dark text-center'>";
            if (str_contains($_GET['consulta'], 'UPDATE') || str_contains($_GET['consulta'], 'INSERT') || str_contains($_GET['consulta'], 'DELETE') || str_contains($_GET['consulta'], 'CREATE') || str_contains($_GET['consulta'], 'DROP')) {
                header("Location: ./consultasdb.php?consulta=" . $_GET['consultAnterior'] . "&host=" . $host . "&user=" . $user . "&password=" . $password . "&dbName=" . $dbName . "&consultar=New+consult");
                die();
            }
            while ($select = mysqli_fetch_row($selects)) {
                echo "<tr >";
                for ($i = 0; $i < sizeof($select); $i++) {
                    echo "<td>" . $select[$i] . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
            echo '</div>';
            echo '<div class="d-flex col-12 justify-content-center shadow mb-4" style="background-color:gray;color:black;">';
            echo '<form action="" method="GET" class="col-12 mb-5">';
            echo '<div class="d-flex col-12 justify-content-center shadow">';
            echo '<input type="button" onClick="Select()" class="btn btn-success w-25 m-1 select" name="select" value="SELECT">';
            echo '<input type="button" onClick="Insert()" class="btn btn-success w-25 m-1 insert" name="insert" value="INSERT">';
            echo '<input type="button" onClick="Update()" class="btn btn-success w-25 m-1 update" name="update" value="UPDATE">';
            echo '<input type="button" onClick="Delete()" class="btn btn-success w-25 m-1 delete" name="delete" value="DELETE">';
            echo '</div>';
            echo '<label for="consulta" class="form-label"></label>';
            echo '<textarea class="form-control" id="nonmon" name="consulta" rows="5" 
            >' . $_GET['consulta'] . '</textarea>';
            echo '<input type="hidden" value="' . $host . '" name="host">';
            echo '<input type="hidden" value="' . $user . '" name="user">';
            echo '<input type="hidden" value="' . $password . '" name="password">';
            echo '<input type="hidden" value="' . $dbName . '" name="dbName">';
            echo '<input type="hidden" value="' . $consultUserSQL . '" name="consultAnterior">';
            echo '<div class="d-flex col-12 justify-content-center shadow">';
            echo '<input type="submit" class="btn btn-dark w-100 mt-5" name="consultar" value="New consult">';
            echo '</div>';
            echo '</form>';
            echo '</div>';
            echo "</div>";
            $i = 1;
            echo "<div class='row'>";
            while ($table = mysqli_fetch_assoc($tablesDB)) {
                echo "<ul class='col-6 border shadow mb-2 p-4 justify-content-center d-flex'>";
                echo "<li><br><b style='font-size:20px;color:#B58B00;' class='justify-content-center d-flex'>" . strtoupper($table["Tables_in_" . $_GET['dbName']]) . "</b>";
                echo "<ol class='shadow p-5'>";
                $describeTable = "DESCRIBE " . $table["Tables_in_" . $_GET['dbName']] . ";";
                $tablesInfo = mysqli_query($connection, $describeTable);
                while ($tableInfo = mysqli_fetch_assoc($tablesInfo)) {
                    if ($tableInfo["Key"] == "PRI") {
                        echo "<li class=''> " . $tableInfo["Field"] . " <b style='font-size:20px;color:#B58B00;'>*PK*</b></li>";
                    }
                    if ($tableInfo["Key"] == "MUL") {
                        echo "<li class=''>" . $tableInfo["Field"] . " <b style='font-size:20px;color:#B58B00;'>*FK*</b></li>";
                    }
                    if ($tableInfo["Key"] == "") {
                        echo "<li class=''>" . $tableInfo["Field"] . "</li>";
                    }
                }
                echo "</ol></li></ul>";
            }
            echo "</div>";
        } catch (Exception $e) {
            header("Location: ./consultasdb.php?valor=You have entered some incorrect data, please try again.");
        }
    }
} else {
    echo "<div class='container'>";
    echo "<div class='row'>";
    echo '<div class="row col-12 d-flex justify-content-center shadow h-100">';
    echo '<h2 class="d-flex justify-content-center col-12 shadow" style="background-color:gray;color:white;">SQL CONSULT DATABASE  </h2>';
    echo '<form action="" method="GET">';
    echo '<div class="row">';
    echo '<label for="host" class="form-label justify-content-center d-flex">HOST </label>';
    echo '<input type="text" class="form-control" name="host" required>';
    echo '</div>';
    echo '<div class="row">';
    echo '<label for="user" class="form-label justify-content-center d-flex">USER </label>';
    echo '<input type="text" class="form-control" name="user" required>';
    echo '</div>';
    echo '<div class="row">';
    echo '<label for="password" class="form-label justify-content-center d-flex">PASSWORD </label>';
    echo '<input type="text" class="form-control" name="password">';
    echo '</div>';
    echo '<div class="row">';
    echo '<label for="dbName" class="form-label justify-content-center d-flex">DATABASE NAME </label>';
    echo '<input type="text" class="form-control" name="dbName" required>';
    echo '</div>';
    echo '<div class="row">';
    echo '<label for="consulta" class="form-label justify-content-center d-flex">SQL CONSULT </label>';
    echo '<textarea class="form-control" name="consulta" rows="5" required></textarea>';
    echo '</div>';
    echo '<div class="row mt-3 mb-3">';
    echo '<input type="submit" class="btn btn-success" name="consultar" value="SQL CONSULT SEND">';
    echo '</div>';
    echo '</form>';
    echo '</div>';
    echo '<div class="row col-12 h-100 d-flex justify-content-center shadow">';
    echo '<h2 class="d-flex justify-content-center col-12 shadow" style="background-color:gray;color:white;">XPATH CONSULT XML</h2>';
    echo '<form action="" method="GET">';
    echo '<div class="row">';
    echo '<label for="dbName" class="form-label justify-content-center d-flex">XML TEXT </label>';
    echo '<textarea class="form-control" name="xmlData" rows="14" required></textarea>';
    echo '</div>';
    echo '<div class="row">';
    echo '<label for="consulta" class="form-label justify-content-center d-flex">CONSULT XPATH </label>';
    echo '<input class="form-control" name="consultXPATH" type="text" required>';
    echo '</div>';
    echo '<div class="row mt-3 mb-3">';
    echo '<input type="submit" class="btn btn-success" name="xmlConsult" value="XML CONSULT SEND">';
    echo '</div>';
    echo '</form>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}
echo "<script>";
echo 'function Select(){
    var text = document.createTextNode("SELECT (camp_name) AS (alias_name) FROM (table_name);");                                    
    document.getElementById("nonmon").appendChild(text); 
}';
echo 'function Insert(){
    var text = document.createTextNode("INSERT INTO table_name(camp_name1, camp_name2) VALUES (value_camp1, value_camp2);");                                    
    document.getElementById("nonmon").appendChild(text); 
}';
echo 'function Update(){
    var text = document.createTextNode("UPDATE table_name SET column_name = new_value WHERE condition;");                                    
    document.getElementById("nonmon").appendChild(text); 
}';
echo 'function Delete(){
    var text = document.createTextNode("DELETE FROM ntable_name WHERE column_name = value;");                                    
    document.getElementById("nonmon").appendChild(text); 
}';
echo "</script>";
echo "</body></html>";
