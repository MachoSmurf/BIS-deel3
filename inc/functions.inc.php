<?php
	if (!defined("IN_SYSTEM"))
	{
		header("Location: ../index.php");
		die();
	}


/**
	*	checks whether the user is logged in through the PHP session
	*
	*	@return boolean returns true or false on the login
	*/
	function checkLogin()
	{
		global $settings;

		$loggedIn = false;
		if (isset($_SESSION["login"]))
		{
			if (($_SESSION["login"] == true) && (($_SESSION["lasttime"] + $settings["timeout"]) >= time()))
			{
				//user is logged in and timeout hasn't passed yet
				$_SESSION["lasttime"] 	= time();
				$loggedIn 				= true;
			}
			else
			{
				//user hasn't logged in or timeout has passed
				$_SESSION = array();
				if (!$_SESSION["login"]){
					header("Location: index.php");
				}
				else{
					//logout was due to a session timeout. Show this to avoid user confusion
					header("Location: index.php?timeout=true");
				}
			}
		}	
		return $loggedIn;
	}

/**
	*	checks user credentials and sets session vars if ok
	*
	*	@return boolean returns true or false on the login
	*/
	function preformLogin($username, $password)
	{
		$login = false;
		global $settings;
		global $dbConn;

		//fetch the salt for this user from the database
		$query = $dbConn->prepare("SELECT `salt`, `password`, `username`, `user_id` FROM `user` WHERE `username` = ?");
		$query -> bind_param("s", $username);
		$query -> execute();
		$query -> bind_result($salt, $passwordHash, $username, $uID);
		$query -> fetch();

		if  (($passwordHash != hash("sha256", $password . $salt)) || ($salt == null))
		{
			return $login;
		}
		else
		{
			//set session variables
			$_SESSION["login"]		=	true;
			$_SESSION["lasttime"]	=	time();
			$_SESSION["username"]	=	$username;
			$_SESSION["uID"]		=	$uID;
			return true;
		}		
	}

	/**
	*	fetches page information and calls the correct file
	*/

	function handlePage()
	{
		global $settings;
		global $dbConn;

		$page = "";
		if (isset($_GET["p"]))
		{
			$page = $_GET["p"];
		}

		switch ($page) {
			case 'home':
				include "./content/home.inc.php";
				break;

			case 'logout':
				include "./inc/logout.inc.php";
				break;

			case 'voorraad':
				include "./content/vrd_beheer.inc.php";
				break;

			case 'licentie':
				include "./content/lic_beheer.inc.php";
				break;

			case 'systeem':
				include "./content/sys_registratie.inc.php";
				break;

			default:
				include "./content/home.inc.php";
				break;
		}
	}

?>