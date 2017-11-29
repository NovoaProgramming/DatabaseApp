<?php
	session_start();
	require('/includes/sqlQueryFunctions.php');
	require('/includes/loggedInHeader.php');
	if (!isset($_SESSION['username']))
	{
		header("Location: /index.php");
	}
	elseif ($_SESSION['username'] != 'AAnderson' AND $_SESSION['username'] != 'JMartinez')
	{
		echo '<b>You are not a manager or owner.</b>';
		echo '<i>Please return to another area of this site using the above menu</i>';
		require('/includes/loggedInFooter.php');
		die();
	}
	else
	{
?>
	<div class="wrapper">
	<div class="sidenav">
				<b>Choose a subject to work with:</b>
				<a href="/managementPage.php">View Instructions Again</a>
				<a href="/managementPage.php?table=employees">Employees</a>
				<a href="/managementPage.php?table=promos">Promos</a>
				<a href="/managementPage.php?table=shipments">Shipments</a>
				<a href="/managementPage.php?table=suppliers">Suppliers</a>			
	</div>
	<div class="mainContentArea">
		<?php
		if (empty($_GET['table']))
		{
			echo '<p><b>Instructions:</b></p>';
			echo '<p>&nbsp &nbsp &nbsp &nbsp The purpose of this area is to display table data
					and allow you to make edits where possible. You can also add or remove rows if you 
					have sufficient privileges.</p>';
			echo '<p>&nbsp &nbsp &nbsp &nbsp To do this just select a table from the left that you 
					would like to view. After this the table will display and wherever you have the 
					privileges to edit you can just directly click in the field and make the 
					appropriate edits. If you do not have the ability to make edits on that column then
					the column will not allow changes. The row will flash green if the change was 
					successfully made. The row will flash red if the change was not successfully made.</p>';
			echo '<p>&nbsp &nbsp &nbsp &nbsp You will also be provided a filter to sort rows, a button to 
					add new rows, and a column with a button to delete rows. All of these functions are 
					provided on the basis that you have the privilege to complete those actions in 
					the database.</p>';
			echo '<p><b>If you are unable to complete a desired action please contact 
					the database administrator.</b></p>';
		}
		elseif ($_GET['table'] == 'employees')
		{
			echo '<iframe src="/databaseTables.php?table=employee" frameBorder="1"></iframe>';
		}
		elseif ($_GET['table'] == 'promos')
		{
			echo '<iframe src="/databaseTables.php?table=promo" frameBorder="1"></iframe>';
		}
		elseif ($_GET['table'] == 'shipments')
		{
			echo '<iframe src="/databaseTables.php?table=shipment" frameBorder="1"></iframe>';
		}
		elseif ($_GET['table'] == 'suppliers')
		{
			echo '<iframe src="/databaseTables.php?table=supplier" frameBorder="1"></iframe>';
		}
		?>
	</div>
	</div>
<?php
	require('includes/loggedInFooter.php');
	}
?>