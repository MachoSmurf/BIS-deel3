<?php
	if (!defined("IN_SYSTEM"))
	{
		header("Location: ../index.php");
		die();
	}

	if (isset($_POST["submit"]))
	{
		$action	=	null;
		if (isset($_POST["action"]))
			{	$action 			=	$_POST["action"];	}

		//user wants to add or remove products
		if ($_POST["submit"] == "Nieuw Product Toevoegen")
		{
			?>
			<form action="?p=stock" method="post">
				Naam: <input type="text" name="name"><br>
				Model/Type: <input type="text" name="type"><br>
				Omschrijving: <input type="text" name="description"><br>
				<input type="hidden" name="action" value="newProduct">
				<input type="submit" name="submit" value="Voeg Toe">
			</form>
			<?php
		}

		
		if ($action == "newProduct")
		{
			if (isset($_POST["name"]) != "")
			{
				$name			=	$_POST["name"];
				$type 			=	null;	
				$description	=	null;

				if (isset($_POST["type"]))
					{	$type 			=	$_POST["type"];			}
				if (isset($_POST["description"]))
					{	$description 	=	$_POST["description"];	}


				//add to database
				$result = addProduct($name, $type, $description);
				switch ($result){
					case 1:
						?>
						Product succesvol toegevoegd.
						<?
						break;
					case 2:
						echo $dbConn -> error;
						break; 
					case 3:
						echo "Dit product bestaat al!";
						break;
				}
			}
			else
			{
				echo "Niet alle vereiste velden zijn ingevuld. Ga terug en probeer het nog eens.";
			}
		}


		//user wants to add or stock
		if ($_POST["submit"] == "Voorraad Toevoegen")
		{
			$stmt	=	$dbConn->prepare("SELECT DISTINCT(name) FROM product");
			$stmt	->	execute();
			$stmt	->	bind_result($n);

			?>	
			<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
			<script>
				function ajaxRequest(obj)
				  {
				    $('#select2').empty()
				    var dropDown = document.getElementById("select1");
				    var prodName = dropDown.options[dropDown.selectedIndex].value;
				    $.ajax({
				            type: "POST",
				            url: "/BIS-deel3/content/types.php",
				            data: { 'prodName': prodName  },
				            datatype: 'json',
				            async: false,
				            success: function(data){
							    $.each(data, function(index, element) {
						            $('#select2').append($('<option value =' + element.id + '>' + element.type + '</option>'));
						        });
				            }
				        });
				  }
			</script>		

			<form action="?p=stock" method="post">
				Naam: <select name="name" id="select1" onchange="ajaxRequest(this)">
									<option value=""></option>
						<?php
							while($stmt	->	fetch())
							{
								?>
									<option value="<? echo $n; ?>"><? echo $n; ?></option>
								<?
							}
						?>						
						</select><br>
				Model/Type: <select name="type" id="select2">						
								<option>Kies eerst een product</option>						
							</select>
				<br>
				Aantal: <input type="number" min="1" step="1" name="amount" value="1"><br>
				Garantie: <input type="text" name="warranty"><br>
				Service Tag: <input type="text" name="serviceTag"><br>
				<input type="hidden" name="action" value="newStock">
				<input type="submit" name="submit" value="Voeg Toe">
			</form>
			<?php
		}

		if ($action == "newStock")
		{
			if ((isset($_POST["name"]) != "") && (isset($_POST["amount"]) != ""))
			{
				$name			=	$_POST["name"];
				$typeID 		=	null;				
				$warranty		= 	null;
				$serviceTag		=	null;
				$amount			=	$_POST["amount"];

				if (isset($_POST["type"]))
					{	$typeID 			=	$_POST["type"];	}
				if (isset($_POST["warranty"]))
					{	$warranty 			=	$_POST["warranty"];	}
				if (isset($_POST["serviceTag"]))
					{	$serviceTag 		=	$_POST["serviceTag"];	}

				//add to database
				$result = addStock($name, $typeID, $amount, $warranty, $serviceTag);
				switch ($result){
					case 1:
						?>
						Product succesvol toegevoegd.
						<?
						break;
					case "2":
						echo $dbConn -> error;
						break; 
					case 3:
						echo "Dit product bestaat al!";
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
		<div>	
			<form action="?p=stock" method="post" style="display: inline;">
				<input type="submit" value="Nieuw Product Toevoegen" name="submit">
			</form>
			<form action="?p=stock" method="post" style="display: inline;">
				<input type="submit" value="Voorraad Toevoegen" name="submit">
			</form>
		</div>	
		<?php
		
		//haal huidige Lijst met voorraad op op
		$query = $dbConn->prepare("SELECT DISTINCT s.product_id, p.name, p.type, COUNT(s.product_id) FROM stock s, product p WHERE s.status=1 AND p.id=s.product_id GROUP BY s.product_id ORDER BY p.name, p.type ASC");
		$query -> execute();
		$query -> bind_result($emp_id, $voornaam, $achternaam, $email);

		echo "<table>";
		?>
		<table>
			<tr>
				<td>Product ID</td>
				<td>Product</td>
				<td>Model/Type</td>
				<td>Aantal op voorraad</td>
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
			</tr>
			<?
		}

		echo "</table>";
		
	}
?>