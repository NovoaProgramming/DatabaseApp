<?php
	session_start();
	require('/includes/loggedInHeader.php');
	if (isset($_SESSION['username']))
	{
		echo '<p>Logged in as ' . $_SESSION['username'] . '.</p>';
		echo '<p>The sections above contain the following information:</p>';
		echo '<ol><li>Home: Brings you back to this page.</li>';
		echo '<li>Sales: Related to the sales team, including invoices and products.</li>';
		echo '<li>Management: Related to the management staff. Only management and owners can view this page.</li>';
		echo '<li>Customer Management: Related to the customers, including member information and shipments.</li>';
		echo '<li>Stored Procedures: Used to execute stored procedures for display of information.</li>';
		echo '<li>Log Out: Logs you out. Brings you back to the login page.</li></ol>';
	}
	else
	{
		header("Location: /index.php");
	}
	require('/includes/loggedInFooter.php');
?>