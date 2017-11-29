<?php
	session_start();
	// storing the users name to decide what to display/do depending on whether or not they
	// were attempting to logout of if they just visited this page.
	if (!empty($_SESSION['username']))
	{
		@ $usersName = $_SESSION['username'];
		// terminating the session for the user. 
		unset($_SESSION['username']);
		session_destroy();
		$justLoggedOut = true;
	}
	else 
	{
			$justLoggedOut = false;
	}
?>
<html>
<head>
	<title>VirtualTechGamingStore Database Home</title>
	<link rel="stylesheet" type="text/css" href="/styles/homepage.css">
</head>
<body oncontextmenu="return false;"
	<?php
		if(isset($_POST['username']))
		{
			echo ' OnLoad="document.loginForm.password.focus();">';
		}
		else
		{
			echo ' onLoad="document.loginForm.username.focus();">';
		}
	?>
	<form action="/loginProcess.php" method="post" name="loginForm" >
		<div class="imageContainer">
			<img src="/images/MySql256x256.png" alt="MySQLImage" class="image">
		</div>
		<p><b>VirtualTechGamingStore Login</b></p>
		<?php
			if ($justLoggedOut == true)
			{
				echo "<p>You have successfully been logged out</p>";
			}
			else
			{
				echo "<p><i>Please note that usernames and passwords are case sensitive</i></p>";
			}
		?>
		<div class="container">
			<label><b>Username:</b></label>
			<input type="text" placeholder="Enter Username" name="username"
				<?php
					if(isset($_POST['username']))
					{
						echo 'value="' . $_POST['username'] . '"';
					}
				?>
				required >
			<label><b>Password:</b></label>
			<input type="password" placeholder="Enter Password" name="password" required >
			<button type="submit">Login</button>
		</div>
	</form>
</body>
</html>