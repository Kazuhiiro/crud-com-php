<?php

    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "atividade";
    $port = 3306;

    //conexão com a porta
    $conn = new PDO("mysql:host=$host;port=$port;dbname=".$dbname, $user, $pass);

    //conexao sem a porta
    //$conn = new PDO("mysql:host=$host;dbname=".$dbname, $user, $pass);
?>