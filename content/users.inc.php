<?php
	if (!defined("IN_SYSTEM"))
	{
		header("Location: ../index.php");
		die();
	}

	if (isset($_POST["submit"]))
	{
		//user wants to add or remove software
		if ($_POST["submit"] == "Gebruiker Toevoegen")
		{
			?>
			<form action="?p=users" method="post">
				Gebruikersnaam: <input type="text" name="username"><br>
				Wachtwoord: <input type="password" name="password"><br>
				Wachtwoord Bevestigen: <input type="password" name="passwordConf"><br>
				Voornaam: <input type="text" name="voornaam"><br>
				Achternaam: <input type="text" name="achternaam"><br>
				Email: <input type="text" name="email"><br>
				Administrator: <input type="checkbox" name="admin" value="true"><br>
				Actief: <input type="checkbox" name="active" value="true"><br>
				<input type="submit" name="submit" value="Voeg Toe">
			</form>
			<?php
		}
		if ($_POST["submit"] == "Voeg Toe")
		{
			if ((isset($_POST["username"]) != "") && (isset($_POST["email"]) != "") && ($_POST["password"] != "") && ($_POST["passwordConf"] != "") && ($_POST["voornaam"] != "") && ($_POST["achternaam"] != ""))
			{
				if ($_POST["password"] == $_POST["passwordConf"])
				{
					$level;
					
					if ((isset($_POST["active"])) && (!isset($_POST["admin"])))
					{
						$level = 1;
					}
					elseif ((isset($_POST["active"])) && (isset($_POST["admin"])))
					{
						$level = 2;
					}
					else
					{
						$level = 0;
					}

					//add to database
					$result = addUser($_POST["username"], $_POST["password"], $_POST["email"], $level, $_POST["voornaam"], $_POST["achternaam"]);
					switch ($result){
						case 1:
							?>
							Gebruiker succesvol toegevoegd.
							<?
							break;
						case 2:
							echo $dbConn -> error;
							break;
						case 3:
							echo "Deze gebruikersnaam bestaat al!";
							break;
					}
				}
				else
				{
					echo "Passwords do not match";
				}
			}
		}
	}
	else
	{
		if ($_SESSION["level"] == 2)
		{
		?>
			
		<form action="?p=users" method="post">
			<input type="submit" value="Gebruiker Toevoegen" name="submit">
		</form>
			
		<?php
		}		
		//haal huidige gebruikers op
		$query = $dbConn->prepare("SELECT user_id, username, email, level FROM user WHERE level > 0 ORDER BY level, user_id ASC");
		$query -> execute();
		$query -> bind_result($uID, $username, $email, $level);

		echo "<table>";
		?>
		<table>
			<tr>
				<td>ID</td>
				<td>Username</td>
				<td>E-Mail</td>
				<td>Level</td>
				<td></td>
			</tr>
		<?

		while($query -> fetch())
		{
			?>
			<tr>
				<td><? echo $uID; ?></td>
				<td><? echo $username; ?></td>
				<td><? echo $email; ?></td>
				<td><? echo $level; ?></td>
				<td>Edit</td>
			</tr>
			<?
		}

		echo "</table>";
		
	}
?>