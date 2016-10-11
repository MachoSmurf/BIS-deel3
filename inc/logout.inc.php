<?php
	if (!defined("IN_SYSTEM"))
	{
		header("Location: ../index.php");
		die();
	}

	$_SESSION["login"]		=	false;
	$_SESSION["timeout"]	=	0;
	$_SESSION["username"]	=	"";
	$_SESSION["uID"]		=	0;
	$loggedIn 				= 	false;

?>