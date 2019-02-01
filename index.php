<?php
//start session
session_start();	

//Add controller & classes
require_once "controller/pageswitch.php";
require_once "model/classes/database.php";
require_once "model/classes/document.php";
require_once "inc/phpFunctions.php";


if(!isset($_GET["action"]))
{
	$_GET["action"] = "home";
}

$controller = new PageSwitch(); //create instance of class PageSwitch
echo $controller->selectPage($_GET["action"]); //Call method to select the page
?>
