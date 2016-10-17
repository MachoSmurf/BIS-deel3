<?php

if (!defined("IN_SYSTEM"))
	{
		header("Location: ../index.php");
		die();
	}

?>

<div class="loginWrapper">
	<div id="loginBox">
		<div id="loginText"><img src="./img/logo.gif" /></div>
		<div id="LoginInput">
			<form action="" method="post">
				<span class="loginBoxText">Username:</span><span class="loginBoxInput"><input type="text" name="username"></span><br>
				<span class="loginBoxText">Password:</span><span class="loginBoxInput"><input type="password" name="password"></span>
				<div class="loginButton">
					<input type="submit" value="Login" name="submit">
				</div>
			</form>
		</div>
	</div>
</div>

</body>
</html>