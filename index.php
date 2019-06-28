<?php
// Start session
session_start();

//Include Config
require('config.php');

require('classes/Messages.php');
require('classes/Bootstrap.php');
require('classes/Controller.php');
require('classes/Model.php');

require('controllers/home.php');
require('controllers/cities.php');
require('controllers/countries.php');


require('models/home.php');
require('models/city.php');
require('models/country.php');

$bootstrap = new Bootstrap($_GET);
$controller = $bootstrap->createController();
if($controller){
	$controller->executeAction();
}