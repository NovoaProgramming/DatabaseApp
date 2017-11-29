<?php
	session_start();
	require('/includes/sqlQueryFunctions.php');
	if (!isset($_SESSION['username']))
	{
		header("Location: /index.php");
	}
	elseif ($_SESSION['username'] != 'AAnderson' AND $_SESSION['username'] != 'JMartinez')
	{
		echo '<b>You cannot view this table.</b>';
		require('/includes/loggedInFooter.php');
		die();
	}
	else
	{
		// storing the table name, from the table variable that is passed from the managementPage to 
		// this page.
		$table = $_GET['table'];
		// intializing a role variable to track what to display to the user based on their role.
		$role = '';
		switch ($_SESSION['username'])
		{
			case 'AAnderson':
				$role = 'owner';
				break;
			case 'JMartinez':
				$role = 'manager';
				break;
		}
		echo '
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Database Tables Page</title>
		<link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
		<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
		<link rel="stylesheet" href="css/font-awesome-4.7.0/css/font-awesome.min.css" type="text/css" media="screen">

    </head>
    <body>';
		// creating filter text
		$filterText = '';
		switch ($table)
		{
			case 'employee':
				$filterText = 'Filter: By First or Last Name';
				break;
			case 'supplier':
				$filterText = 'Filter: By Company Name';
				break;
			case 'promo':
				$filterText = 'Filter: By Category or Effect';
				break;
			case 'shipment':
				$filterText = 'Filter: By Order Status or Tracking Number';
				break;
		}
?>
      	<div id="message"></div>
		<div id="wrap">
		<h1><?php echo ucfirst($table.'s'); ?> Table</h1>
		<div id="toolbar">
			<input type="text" id="filter" name="filter" placeholder="<?php echo $filterText;?>"  />
<?php 
	// Placing tables that should display the add row button for different rows
	// in arrays, based on whether or not the role has insert privileges on those tables.
	$ownerInsertableTableNames = array('supplier');
	$managerInsertableTableNames = array('shipment', 'promo', 'employee');
	// comparing the table to be displayed with the tables allowable for inserts
	// based on role.
	// if inserts are allowed on the table for the role, then display the button for
	// adding a new row
	if	( ($role == 'owner' && in_array($table, $ownerInsertableTableNames))
			OR
		  ($role == 'manager' && in_array($table, $managerInsertableTableNames))
		)
	{
		echo '<a id="showaddformbutton" class="button green"><i class="fa fa-plus"></i>Add new row</a>';
	}
?>
        </div>
		<!-- Grid contents will be generated here -->
		<div id="tablecontent"></div>
		<!-- Paginator control will be generated here -->
		<div id="paginator"></div>
		</div>  
		
		<!-- scripts that are needed for the interactivity of the editablegrid -->
		<script src="js/jquery-1.11.1.min.js" ></script>
		<script src="js/editablegrid-2.1.0-49.js"></script>   
        <!-- EditableGrid test if jQuery UI is present.	If present, a datepicker is automatically used for date type -->
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
		<script src="js/createEditableGrid.js" ></script>
		<?php
		if ($table == 'employee')
		{
		?>
		<script type="text/javascript">
		
            var datagrid; 
            
            window.onload = function() { 
              datagrid = new DatabaseGrid("employee");



                // key typed in the filter field
                $("#filter").keyup(function() {
                  datagrid.editableGrid.filter( $(this).val());
                  });

                $("#showaddformbutton").click( function()  {
                  showAddForm();
                });
                $("#cancelbutton").click( function() {
                  showAddForm();
                });

                $("#addbutton").click(function() {
                  datagrid.addRow();
                });
				} 
			$(function () { });
		</script>
		<div id="addform">
			<p>Scroll to the bottom to apply or cancel</p>
            <div class="row">
                <input type="number" id="ReportsTo" name="ReportsTo" placeholder="Manager's ID" maxlength=10 min=1 />
            </div>
			<p>Enter Hire Date Below:</p>
            <div class="row">
                <input type="date" id="HireDate" name="HireDate" />
            </div>
			<div class="row">
                <input type="text" id="FirstName" name="FirstName" placeholder="First Name" maxlength=50 />
            </div>
			<div class="row">
                <input type="text" id="LastName" name="LastName" placeholder="Last Name" maxlength=50 />
            </div>
			<div class="row">
                <input type="text" id="Title" name="Title" placeholder="Personal Title" maxlength=10 />
            </div>
			<p>Enter Date of Birth Below:</p>
			<div class="row">
                <input type="date" id="DateOfBirth" name="DateOfBirth" />
            </div>
			<div class="row">
                <input type="text" id="JobTitle" name="JobTitle" placeholder="Job title" maxlength=50 />
            </div>
			<div class="row">
                <input type="text" id="Address" name="Address" placeholder="Address" maxlength=100/>
            </div>
			<div class="row">
                <input type="text" id="City" name="City" placeholder="City" maxlength=30 />
            </div>
			<div class="row">
                <input type="text" id="State" name="State" placeholder="State" maxlength=2 />
            </div>
			<div class="row">
                <input type="text" id="Zip" name="Zip" placeholder="Zip Code" maxlength=10 />
            </div>
			<div class="row">
                <input type="text" id="Country" name="Country" placeholder="Country" maxlength=50 />
            </div>
			<div class="row">
                <input type="text" id="Phone" name="Phone" placeholder="Phone Number" maxlength=15 />
            </div>
			<div class="row">
                <input type="text" id="Email" name="Email" placeholder="Email Address" maxlength=100 />
            </div>
            <div class="row tright">
              <a id="addbutton" class="button green" ><i class="fa fa-save"></i>Apply</a>
              <a id="cancelbutton" class="button delete">Cancel</a>
            </div>
        </div>
		<?php 
		}
		elseif ($table == 'promo')
		{
		?>
		<script type="text/javascript">
		
            var datagrid; 
            
            window.onload = function() { 
              datagrid = new DatabaseGrid("promo");



                // key typed in the filter field
                $("#filter").keyup(function() {
                  datagrid.editableGrid.filter( $(this).val());
                    // To filter on some columns, you can set an array of column index 
                    //datagrid.editableGrid.filter( $(this).val(), [0,3,5]);
                  });

                $("#showaddformbutton").click( function()  {
                  showAddForm();
                });
                $("#cancelbutton").click( function() {
                  showAddForm();
                });

                $("#addbutton").click(function() {
                  datagrid.addRow();
                });
				} 
			$(function () { });
		</script>
		<div id="addform">
			<p>Scroll to the bottom to apply or cancel</p>
			</br>
			<p>Is this a premium promotion?</p>
            <div class="row">
                <input type="checkbox" id="PremiumPromotion" name="PremiumPromotion" />
            </div>
			<div class="row">
                <input type="text" id="Category" name="Category" placeholder="Category" maxlength=50 />
            </div>
			<div class="row">
                <input type="text" id="Requirements" name="Requirements" placeholder="Requirements" maxlength=1000 />
            </div>
			<p>Enter Start Date Below:</p>
			<div class="row">
                <input type="date" id="StartDate" name="StartDate" />
            </div>
			<p>Enter End Date Below:</p>
			<div class="row">
                <input type="date" id="EndDate" name="EndDate" />
            </div>
			<div class="row">
                <input type="text" id="Effect" name="Effect" placeholder="Effect" maxlength=100 />
            </div>
            <div class="row tright">
              <a id="addbutton" class="button green" ><i class="fa fa-save"></i>Apply</a>
              <a id="cancelbutton" class="button delete">Cancel</a>
            </div>
        </div>
		<?php
		}
		elseif ($table == 'shipment')
		{
		?>
		<script type="text/javascript">
		
            var datagrid; 
            
            window.onload = function() { 
              datagrid = new DatabaseGrid("shipment");



                // key typed in the filter field
                $("#filter").keyup(function() {
                  datagrid.editableGrid.filter( $(this).val());
                    // To filter on some columns, you can set an array of column index 
                    //datagrid.editableGrid.filter( $(this).val(), [0,3,5]);
                  });

                $("#showaddformbutton").click( function()  {
                  showAddForm();
                });
                $("#cancelbutton").click( function() {
                  showAddForm();
                });

                $("#addbutton").click(function() {
                  datagrid.addRow();
                });
				} 
			$(function () { });
		</script>
		<div id="addform">
			<p>Scroll to the bottom to apply or cancel</p>
            <div class="row">
                <input type="number" id="SupplierID" name="SupplierID" placeholder="Supplier ID" maxlength=10 min=1/>
            </div>
			<div class="row">
                <input type="number" id="EmployeePlacedOrder" name="EmployeePlacedOrder" placeholder="Employee Who Placed Order" maxlength=10 min=1 />
            </div>
			<div class="row">
                <input type="number" id="EmployeeReceivedOrder" name="EmployeeReceivedOrder" placeholder="Employee Who Received the Order" maxlength=10 min=1 />
            </div>
			<div class="row">
                <input type="text" id="OrderStatus" name="OrderStatus" placeholder="Order Status" maxlength=30 />
            </div>
			<div class="row">
                <input type="text" id="TrackingNumber" name="TrackingNumber" placeholder="Tracking Number" maxlength=50 />
            </div>
			<p>Enter the Shipped Date Below</p>
			<div class="row">
                <input type="date" id="ShippedDate" name="ShippedDate" />
            </div>
			<p>Enter the Expected Arrival Date Below</p>
			<div class="row">
                <input type="date" id="ExpectedArrivalDate" name="ExpectedArrivalDate" />
            </div>
			<p>Enter the Actual Arrival Date Below</p>
			<div class="row">
                <input type="date" id="ActualArrivalDate" name="ActualArrivalDate" />
            </div>
			<div class="row">
                <input type="number" id="TotalCost" name="TotalCost" placeholder="Total Cost" step=0.01 min=0 />
            </div>
			<div class="row">
                <input type="number" id="ShippingCost" name="ShippingCost" placeholder="Shipping Cost" step=0.01 min=0 />
            </div>
            <div class="row tright">
              <a id="addbutton" class="button green" ><i class="fa fa-save"></i>Apply</a>
              <a id="cancelbutton" class="button delete">Cancel</a>
            </div>
        </div>
		<?php
		}
		elseif ($table == 'supplier')
		{
		?>
		<script type="text/javascript">
		
            var datagrid; 
            
            window.onload = function() { 
              datagrid = new DatabaseGrid("supplier");



                // key typed in the filter field
                $("#filter").keyup(function() {
                  datagrid.editableGrid.filter( $(this).val());
                    // To filter on some columns, you can set an array of column index 
                    //datagrid.editableGrid.filter( $(this).val(), [0,3,5]);
                  });

                $("#showaddformbutton").click( function()  {
                  showAddForm();
                });
                $("#cancelbutton").click( function() {
                  showAddForm();
                });

                $("#addbutton").click(function() {
                  datagrid.addRow();
                });
				} 
			$(function () { });
		</script>
		<div id="addform">
			<p>Scroll to the bottom to apply or cancel</p>
            <div class="row">
                <input type="text" id="CompanyName" name="CompanyName" placeholder="Company Name" maxlength=75 />
            </div>
			<div class="row">
                <input type="text" id="Address" name="Address" placeholder="Address" maxlength=100 />
            </div>
			<div class="row">
                <input type="text" id="City" name="City" placeholder="City" maxlength=30 />
            </div>
			<div class="row">
                <input type="text" id="State" name="State" placeholder="State" maxlength=2 />
            </div>
			<div class="row">
                <input type="text" id="Zip" name="Zip" placeholder="Zip" maxlength=10 />
            </div>
			<div class="row">
                <input type="text" id="Country" name="Country" placeholder="Country" maxlength=50 />
            </div>
			<div class="row">
                <input type="text" id="Website" name="Website" placeholder="Website" maxlength=300 />
            </div>
			<div class="row">
                <input type="text" id="ContactFirstName" name="ContactFirstName" placeholder="Contact First Name" maxlength=50 />
            </div>
			<div class="row">
                <input type="text" id="ContactLastName" name="ContactLastName" placeholder="Contact Last Name" maxlength=50 />
            </div>
			<div class="row">
                <input type="text" id="ContactTitle" name="ContactTitle" placeholder="Contact Title" maxlength=10 />
            </div>
			<div class="row">
                <input type="text" id="Phone" name="Phone" placeholder="Phone Number" maxlength=15 />
            </div>
			<div class="row">
                <input type="text" id="Ext" name="Ext" placeholder="Phone Extension" maxlength=10 />
            </div>
			<div class="row">
                <input type="text" id="Email" name="Email" placeholder="Email" maxlength=100 />
            </div>
			<div class="row">
                <input type="text" id="PreferredMethodOfContact" name="PreferredMethodOfContact" placeholder="Pref. Contact Method" maxlength=20 />
            </div>
            <div class="row tright">
              <a id="addbutton" class="button green" ><i class="fa fa-save"></i>Apply</a>
              <a id="cancelbutton" class="button delete">Cancel</a>
            </div>
        </div>
		<?php
		}
		?>
</body>
<?php
	}
?>
</html>
