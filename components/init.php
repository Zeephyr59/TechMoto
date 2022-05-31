<?php 
        require_once './components/functions.php';

        session_start();

        $db = new PDO('mysql:dbname=techmoto;host=localhost', 'root', '', array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        ));

        $connectedUser = reloadUserFormDatabase();
?>