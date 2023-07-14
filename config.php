<?php 
$host ="localhost";
$dbname="class4";
$dbuser="root";
$dbpassword="";


try{
    $pdo = new PDO("mysql:host={$host}; dbname={$dbname}", $dbuser, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $Ex){
    echo "Connection ERROR :".$Ex->getMessage();
}



?>