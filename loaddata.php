<?php     

/**
 * This script loads data from the database and returns it to the js
 *
 */
 
// Determine user and role based on that user
session_start();
$username = $_SESSION['username'];
$role = '';
switch ($username)
{
	case 'AAnderson':
		$role = 'owner';
		break;
	case 'JMartinez':
		$role = 'manager';
		break;
}
       
require_once('config.php');      
require_once('EditableGrid.php');            

/**
 * fetch_pairs is a simple method that transforms a mysqli_result object in an array.
 * It will be used to generate possible values for some columns.
*/
function fetch_pairs($mysqli,$query){
	if (!($res = $mysqli->query($query)))return FALSE;
	$rows = array();
	while ($row = $res->fetch_assoc()) {
		$first = true;
		$key = $value = null;
		foreach ($row as $val) {
			if ($first) { $key = $val; $first = false; }
			else { $value = $val; break; } 
		}
		$rows[$key] = $value;
	}
	return $rows;
}


// Database connection
$mysqli = mysqli_init();
$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5);
$mysqli->real_connect($config['db_host'],$config['db_user'],$config['db_password'],$config['db_name']); 
                    
// create a new EditableGrid object
$grid = new EditableGrid();

/* 
* public function addColumn($name, $label, $type, $values = NULL, $editable = true, $field = NULL, $bar = true, $hidden = false)
*/
$mydb_tablename = (isset($_GET['db_tablename'])) ? stripslashes($_GET['db_tablename']) : 'employee';
error_log(print_r($_GET,true));


if ($mydb_tablename == 'employee' && $role == 'manager')
{
	$grid->addColumn('EmployeeID', 'ID', 'integer', NULL, false); 
	$grid->addColumn('ReportsTo', 'Manager ID', 'integer');  
	$grid->addColumn('HireDate', 'Hire Date', 'date');  
	$grid->addColumn('FirstName', 'First Name', 'string(50)');
	$grid->addColumn('LastName', 'Last Name', 'string(50)'); 
	$grid->addColumn('Title', 'Personal Title', 'string(10)');  
	$grid->addColumn('DateOfBirth', 'Date of Birth', 'date');  
	$grid->addColumn('JobTitle', 'Job Title', 'string(50)');  
	$grid->addColumn('Address', 'Address', 'string(100)');                                               
	$grid->addColumn('City', 'City', 'string(30)');  
	$grid->addColumn('State', 'State', 'string(2)');  
	$grid->addColumn('Zip', 'Zip Code', 'string(10)');  
	$grid->addColumn('Country', 'Country', 'string(50)'); 
	$grid->addColumn('Phone', 'Phone', 'string(15)'); 
	$grid->addColumn('Email', 'Email', 'string(100)');
}
elseif ($mydb_tablename == 'employee' && $role == 'owner')
{
	$grid->addColumn('EmployeeID', 'ID', 'integer', NULL, false); 
	$grid->addColumn('ReportsTo', 'Manager ID', 'integer', NULL, false);  
	$grid->addColumn('HireDate', 'Hire Date', 'date', NULL, false);  
	$grid->addColumn('FirstName', 'First Name', 'string(50)', NULL, false);
	$grid->addColumn('LastName', 'Last Name', 'string(50)', NULL, false); 
	$grid->addColumn('Title', 'Personal Title', 'string(10)', NULL, false);  
	$grid->addColumn('DateOfBirth', 'Date of Birth', 'date', NULL, false);  
	$grid->addColumn('JobTitle', 'Job Title', 'string(50)', NULL, false);  
	$grid->addColumn('Address', 'Address', 'string(100)', NULL, false);                                               
	$grid->addColumn('City', 'City', 'string(30)', NULL, false);  
	$grid->addColumn('State', 'State', 'string(2)', NULL, false);  
	$grid->addColumn('Zip', 'Zip Code', 'string(10)', NULL, false);  
	$grid->addColumn('Country', 'Country', 'string(50)', NULL, false); 
	$grid->addColumn('Phone', 'Phone', 'string(15)', NULL, false); 
	$grid->addColumn('Email', 'Email', 'string(100)', NULL, false);
}
elseif ($mydb_tablename == 'promo' && $role == 'manager')
{
	$grid->addColumn('PromoID', 'ID', 'integer', NULL, false); 
	$grid->addColumn('PremiumPromotion', 'Premium', 'boolean');  
	$grid->addColumn('Category', 'Category', 'string(50)');  
	$grid->addColumn('Requirements', 'Requirements', 'string(1000)');
	$grid->addColumn('StartDate', 'Start Date', 'date'); 
	$grid->addColumn('EndDate', 'End Date', 'date');  
	$grid->addColumn('Effect', 'Effect', 'string(100)');
}
elseif ($mydb_tablename == 'promo' && $role == 'owner')
{
	$grid->addColumn('PromoID', 'ID', 'integer', NULL, false); 
	$grid->addColumn('PremiumPromotion', 'Premium', 'boolean', NULL, false);  
	$grid->addColumn('Category', 'Category', 'string(50)', NULL, false);  
	$grid->addColumn('Requirements', 'Requirements', 'string(1000)', NULL, false);
	$grid->addColumn('StartDate', 'Start Date', 'date', NULL, false); 
	$grid->addColumn('EndDate', 'End Date', 'date', NULL, false);  
	$grid->addColumn('Effect', 'Effect', 'string(100)', NULL, false);
}
elseif ($mydb_tablename == 'shipment' && $role == 'manager')
{
	$grid->addColumn('ShipmentID', 'ID', 'integer', NULL, false); 
	$grid->addColumn('SupplierID', 'Supplier ID', 'integer');  
	$grid->addColumn('EmployeePlacedOrder', 'Employee Placed', 'integer');  
	$grid->addColumn('EmployeeReceivedOrder', 'Employee Received', 'integer');
	$grid->addColumn('OrderStatus', 'Order Status', 'string(30)'); 
	$grid->addColumn('TrackingNumber', 'Tracking #', 'string(50)');
	$grid->addColumn('ShippedDate', 'Shipped Date', 'date');
	$grid->addColumn('ExpectedArrivalDate', 'Expected Date', 'date');
	$grid->addColumn('ActualArrivalDate', 'Actual Date', 'date');
	$grid->addColumn('TotalCost', 'Total Cost', 'decimal(13,2)');
	$grid->addColumn('ShippingCost', 'Shipping Cost', 'decimal(13,2)');
}
elseif ($mydb_tablename == 'shipment' && $role == 'owner')
{
	$grid->addColumn('ShipmentID', 'ID', 'integer', NULL, false); 
	$grid->addColumn('SupplierID', 'Supplier ID', 'integer', NULL, false);  
	$grid->addColumn('EmployeePlacedOrder', 'Employee Placed', 'integer', NULL, false);  
	$grid->addColumn('EmployeeReceivedOrder', 'Employee Received', 'integer', NULL, false);
	$grid->addColumn('OrderStatus', 'Order Status', 'string(30)', NULL, false); 
	$grid->addColumn('TrackingNumber', 'Tracking #', 'string(50)', NULL, false);
	$grid->addColumn('ShippedDate', 'Shipped Date', 'date', NULL, false);
	$grid->addColumn('ExpectedArrivalDate', 'Expected Date', 'date', NULL, false);
	$grid->addColumn('ActualArrivalDate', 'Actual Date', 'date', NULL, false);
	$grid->addColumn('TotalCost', 'Total Cost', 'decimal(13,2)', NULL, false);
	$grid->addColumn('ShippingCost', 'Shipping Cost', 'decimal(13,2)', NULL, false);
}
elseif ($mydb_tablename == 'supplier' && $role == 'manager')
{
	$grid->addColumn('SupplierID', 'Supplier ID', 'integer', NULL, false); 
	$grid->addColumn('CompanyName', 'Company Name', 'string(75)');  
	$grid->addColumn('Address', 'Address', 'string(100)');  
	$grid->addColumn('City', 'City', 'string(30)');
	$grid->addColumn('State', 'State', 'string(2)'); 
	$grid->addColumn('Zip', 'Zip Code', 'string(10)');  
	$grid->addColumn('Country', 'Country', 'string(50)');  
	$grid->addColumn('Website', 'Website', 'website');  
	$grid->addColumn('ContactFirstName', 'Contact fName', 'string(50)');                                               
	$grid->addColumn('ContactLastName', 'Contact lName', 'string(50)');   
	$grid->addColumn('ContactTitle', 'Contact Title', 'string(10)');  
	$grid->addColumn('Phone', 'Phone', 'string(15)');  
	$grid->addColumn('Ext', 'Phone Extension', 'string(10)'); 
	$grid->addColumn('Email', 'Email', 'stirng(100)'); 
	$grid->addColumn('PreferredMethodOfContact', 'Preferred Contact', 'string(20)');
}
elseif ($mydb_tablename == 'supplier' && $role == 'owner')
{
	$grid->addColumn('SupplierID', 'Supplier ID', 'integer', NULL, false); 
	$grid->addColumn('CompanyName', 'Company Name', 'string(75)');  
	$grid->addColumn('Address', 'Address', 'string(100)');  
	$grid->addColumn('City', 'City', 'string(30)');
	$grid->addColumn('State', 'State', 'string(2)'); 
	$grid->addColumn('Zip', 'Zip Code', 'string(10)');  
	$grid->addColumn('Country', 'Country', 'string(50)');  
	$grid->addColumn('Website', 'Website', 'website');  
	$grid->addColumn('ContactFirstName', 'Contact fName', 'string(50)');                                               
	$grid->addColumn('ContactLastName', 'Contact lName', 'string(50)');   
	$grid->addColumn('ContactTitle', 'Contact Title', 'string(10)');  
	$grid->addColumn('Phone', 'Phone', 'string(15)');  
	$grid->addColumn('Ext', 'Phone Extension', 'string(10)'); 
	$grid->addColumn('Email', 'Email', 'stirng(100)'); 
	$grid->addColumn('PreferredMethodOfContact', 'Preferred Contact', 'string(20)');
	$grid->addColumn('action', 'Action', 'html', NULL, false, 'SupplierID'); 
}



$query = 'SELECT * FROM '.$mydb_tablename ;
$queryCount = 'SELECT count(*) as nb FROM '.$mydb_tablename;

$totalUnfiltered =$mysqli->query($queryCount)->fetch_row()[0];
$total = $totalUnfiltered;


/* SERVER SIDE */
/* If you have set serverSide : true in your Javascript code, $_GET contains 3 additionnal parameters : page, filter, sort
 * this parameters allow you to adapt your query  
 *
 */
$page=0;
if ( isset($_GET['page']) && is_numeric($_GET['page'])  )
  $page =  (int) $_GET['page'];


$rowByPage=15;

$from= ($page-1) * $rowByPage;

if ( isset($_GET['filter']) && $_GET['filter'] != "" ) {
  $filter =  $_GET['filter'];
  if ($mydb_tablename == 'employee')
  {
	$query .= '  WHERE LastName like "%'.$filter.'%" OR FirstName like "%'.$filter.'%"';
	$queryCount .= '  WHERE LastName like "%'.$filter.'%" OR FirstName like "%'.$filter.'%"';
	$total =$mysqli->query($queryCount)->fetch_row()[0];
  }
  elseif ($mydb_tablename == 'promo')
  {
	$query .= '  WHERE Category like "%'.$filter.'%" OR Effect like "%'.$filter.'%"';
	$queryCount .= '  WHERE Category like "%'.$filter.'%" OR Effect like "%'.$filter.'%"';
	$total =$mysqli->query($queryCount)->fetch_row()[0];
  }
  elseif ($mydb_tablename == 'shipment')
  {
	$query .= '  WHERE OrderStatus like "%'.$filter.'%" OR TrackingNumber like "%'.$filter.'%"';
	$queryCount .= '  WHERE OrderStatus like "%'.$filter.'%" OR TrackingNumber like "%'.$filter.'%"';
	$total =$mysqli->query($queryCount)->fetch_row()[0];
  }
  elseif ($mydb_tablename == 'supplier')
  {
	$query .= '  WHERE CompanyName like "%'.$filter.'%"';
	$queryCount .= '  WHERE CompanyName like "%'.$filter.'%"';
	$total =$mysqli->query($queryCount)->fetch_row()[0];
  }
}

if ( isset($_GET['sort']) && $_GET['sort'] != "" )
  $query .= " ORDER BY " . $_GET['sort'] . (  $_GET['asc'] == "0" ? " DESC " : "" );


$query .= " LIMIT ". $from. ", ". $rowByPage;

error_log("pageCount = " . ceil($total/$rowByPage));
error_log("total = " .$total);
error_log("totalUnfiltered = " .$totalUnfiltered);

$grid->setPaginator(ceil($total/$rowByPage), (int) $total, (int) $totalUnfiltered, null);

/* END SERVER SIDE */ 

error_log($query);

                                                                       
$result = $mysqli->query($query );

$mysqli->close();





// send data to the browser

$grid->renderJSON($result,false, false, !isset($_GET['data_only']));

