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
			if (($_SESSION["login"] == true) && ($_SESSION["timeout"]) < time() + $settings["timeout"])
			{
				//user is logged in and timeout hasn't passed yet
				$_SESSION["timeout"] 	= time() + $settings["timeout"];
				$loggedIn 				= true;
			}
			else
			{
				//user hasn't logged in or timeout has passed
				$_SESSION["login"]		=	false;
				$_SESSION["timeout"]	=	0;
				$_SESSION["username"]	=	"";
				$_SESSION["uID"]		=	0;
				$loggedIn 				= 	false;
				header("Location: index.php");
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
			$_SESSION["timeout"]	=	time() + $setting["timeout"];
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
		$page = "";
		if (isset($_GET["p"]))
		{
			$page = $_GET["p"];
		}

		switch ($page) {
			case 'home':
				outputHeader("Home");
				include "./content/home.inc.php";
				break;

			case 'logout':
				include "./inc/logout.inc.php";
				break;

			case 'voorraad':
				outputHeader("Voorraad Beheer");
				include "./content/vrd_beheer.inc.php";
				break;

			case 'licentie':
				outputHeader("Licentie Beheer");
				include "./content/lic_beheer.inc.php";
				break;

			case 'systeem':
				outputHeader("Systeem Registratie");
				include "./content/sys_registratie.inc.php";
				break;

			default:
				outputHeader("Home");
				include "./content/home.inc.php";
				break;
		}
	}

	/**
	 * Outputs the HTML Header with stylesheet info and page title
	 * 
	 * @param string $pageTitle sets the title of the HTML title tag
	 * 
	 */
	function outputHeader($pageTitle)
	{
		global $settings;
		$title = $settings["page_title_prefix"] . $pageTitle;
		include './inc/header.inc.php';
	}

?>