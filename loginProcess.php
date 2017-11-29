<?php
	// Starts a session or continues a session if it's already started
	session_start();
	
	// checks that the user arrived here with a username and password entered
	// for an attempted login from the index.php page form
	if(isset($_POST['username']) && isset($_POST['password']))
	{
		// Places the values from the form in variables
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		// cleans the user input from having back slashes which can result in bad data
		$username = stripcslashes($username);
		$password = stripcslashes($password);
		
		// attempts to connect to the local virtual tech database using the username and password
		@ $db = new mysqli('localhost', $username, $password, 'virtualtechgamingstore');
		
		// Checks if an error has occured with the connection attempt.
		if (mysqli_connect_errno()) {
			echo '<h3 style="color:red;">Error: Database connection could not be made.
										 Please verify you have the correct username and password.</h3>';
			echo '<form action="index.php" method="post">
					<input type="submit" value="Go Back"></input>';
			echo '<input type="hidden" value="' . $_POST['username'] . '" name="username" ></input></form>';
		}
		else 
		{
			$_SESSION['username'] = $username;
			$_SESSION['password'] = $password;
			header('Location: /home.php');
		}
	}
?>