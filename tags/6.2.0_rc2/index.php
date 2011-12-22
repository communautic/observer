<?php 
include_once("config.php");

if(isset($_GET["path"]) || isset($_POST["path"])){
	$path = $_REQUEST["path"];
	include(CO_INC . "/" . $path . "/index.php");
} else {
	include_once(CO_INC . "/index.php");
}
?>