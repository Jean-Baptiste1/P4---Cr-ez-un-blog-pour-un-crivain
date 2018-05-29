<?php session_start();

require 'lib/autoload.php';

$db = DBFactory::getMysqlConnexionWithPDO();
$manager = new NewsManagerPDO($db);


require 'App/Frontend/welcomeText.php'; 

//require 'App/Frontend/meteo.php'; 

require 'App/Frontend/imgIndex.php'; 

require 'App/Frontend/chapitrePageAcceuil.php'; 

require 'App/Frontend/message.php'; 

$content = ob_get_clean();

require 'App/Frontend/Templates/template.php';?>