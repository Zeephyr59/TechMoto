<?php
require_once './components/init.php';
require_once './components/head.php';

logout();
addFlash('success', 'Vous êtes bien déconnecté');
header('Location: http://localhost/D%C3%A9veloppement/Amigraf_PHP/Projets/Techmoto');
die();
