<?php 

$host = "localhost";
$db = "sitio";
$user = "root";
$pass = "";
try {
    // PDO va a conectar la base de datos - crear una coneccion
    $conection = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    // if ($conection){echo "conectado a sistema\n";}
} catch ( Exception $ex) {
    echo $ex->getMessage();
}

?>