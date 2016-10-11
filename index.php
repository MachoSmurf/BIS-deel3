<?
	session_start();
	define("IN_SYSTEM", true);
	require "./inc/settings.inc.php";
	require "./inc/functions.inc.php";
	require "./inc/db.inc.php";

	$showlogin = true;

	$dbConn = DB_connect();

	if (checklogin())
	{
		//show content		
		handlePage();
	}
	else
	{
		if ((isset($_POST["submit"])) && (isset($_POST["username"])) && (isset($_POST["password"])))
		{
			//user is trying to login
			if (preformLogin($_POST["username"], $_POST["password"]))
			{
				header("Location: ./index.php");
			}
			else
			{
				//wrong credentials
				echo "wrong credentials";
			}
		}
		else
		{
			//show login screen
			?>
			<form action = "" method="post">
				Username: <input type="text" name="username"><br>
				password: <input type="password" name="password"><br>
				<input type="submit" value="Login" name="submit">
			</form>
			<?
		}
	}

	DB_close($dbConn);
?>