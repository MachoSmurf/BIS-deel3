<?
	if (!defined("IN_SYSTEM"))
	{
		header("Location: ../index.php");
		die();
	}	
?>

<!DOCTYPE html>
<html>
<head>
	<title><? echo $title; ?></title>
	<link rel="stylesheet" type="text/css" href="./stylesheet.css">
</head>
<body>
<div class="wrapper">

	<div class="navigation">
		<div class="logoBox">
			<img id="logo" src="./img/logo2.gif" />
		</div>
		<div class="navBody">
			<ul>
				<li><a href="?p=home" class="active">Home</a></li>
				<li><a href="?p=systeem">Systeemregistratie</a></li>
				<li><a href="?p=licentie">Licentiebeheer</a></li>
				<li><a href="?p=voorraad">Voorraadbeheer</a></li>
			</ul>
		</div>
		<div class="navFooter">
			<div id="footerSettingsButton">
				<a href="?p=settings"><img src="./img/settings.png" width="16" height="16" alt="settings"></a>
			</div>
			<div id="footerLogoutButton">
				<a href="?p=logout"><img src="./img/power.png" width="16" height="16" alt="settings"></a>
			</div>
		</div>
	</div>

	<div class="content">

		<div class="contentNav">
			
		</div>

		<div class="pageContent">			
		<!--Content starts here-->