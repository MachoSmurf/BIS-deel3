<?php
	if (!defined("IN_SYSTEM"))
	{
		header("Location: ../index.php");
		die();
	}

	$_SESSION 	=	array();
	header("Location: index.php");

?>