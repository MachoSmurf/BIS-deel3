<?php
	if (!defined("IN_SYSTEM"))
	{
		header("Location: ../index.php");
		die();
	}

	if (isset($_POST["submit"]))
	{
		//user wants to add or remove software
		if ($_POST["submit"] == "Medewerker Toevoegen")
		{
			?>
			<form action="?p=employees" method="post">
				Voornaam: <input type="text" name="voornaam"><br>
				Achternaam: <input type="text" name="achternaam"><br>
				Email: <input type="text" name="email"><br>
				<input type="submit" name="submit" value="Voeg Toe">
			</form>
			<?php
		}
		if ($_POST["submit"] == "Voeg Toe")
		{
			if ((isset($_POST["voornaam"]) != "") && (isset($_POST["achternaam"]) != "") && (isset($_POST["achternaam"]) != ""))
			{
				
				//add to database
				$result = addEmployee($_POST["voornaam"], $_POST["achternaam"], $_POST["email"]);
				switch ($result){
					case 1:
						?>
						Medewerker succesvol toegevoegd.
						<?
						break;
					case 2:
						echo $dbConn -> error;
						break;
					case 3:
						echo "Deze medewerker bestaat al!";
						break;
				}
			}
			else
			{
				echo "Niet alle vereiste velden zijn ingevuld. Ga terug en probeer het nog eens.";
			}
		}
	}
	else
	{
		?>
			
		<form action="?p=employees" method="post">
			<input type="submit" value="Medewerker Toevoegen" name="submit">
		</form>
			
		<?php
	
		//haal huidige Lijst met medewerkers op op
		$query = $dbConn->prepare("SELECT ID, voornaam, achternaam, email FROM employee WHERE status > 0 ORDER BY ID ASC");
		$query -> execute();
		$query -> bind_result($emp_id, $voornaam, $achternaam, $email);

		echo "<table>";
		?>
		<table>
			<tr>
				<td>ID</td>
				<td>Voornaam</td>
				<td>Achternaam</td>
				<td>Email</td>
				<td></td>
			</tr>
		<?

		while($query -> fetch())
		{
			?>
			<tr>
				<td><? echo $emp_id; ?></td>
				<td><? echo $voornaam; ?></td>
				<td><? echo $achternaam; ?></td>
				<td><? echo $email; ?></td>
				<td>Edit</td>
			</tr>
			<?
		}

		echo "</table>";
		
	}
?>