<?php
 
/*
 * 
 * http://editablegrid.net
 *
 * Copyright (c) 2011 Webismymind SPRL
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://editablegrid.net/license
 */
      
require_once('config.php');         

// Database connection                                   
$mysqli = mysqli_init();
$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5);
$mysqli->real_connect($config['db_host'],$config['db_user'],$config['db_password'],$config['db_name']); 

// Get all parameter provided by the javascript
$id = $mysqli->real_escape_string(strip_tags($_POST['id']));
$tablename = $mysqli->real_escape_string(strip_tags($_POST['tablename']));

// This very generic. So this script can be used to update several tables.
$return=false;
if ($tablename == 'employee')
{
	if ( $stmt = $mysqli->prepare("DELETE FROM ".$tablename."  WHERE EmployeeID = ?"))
	{
	$stmt->bind_param("i", $id);
	$return = $stmt->execute();
	$stmt->close();
	} 
}
elseif ($tablename == 'promo')
{
	if ( $stmt = $mysqli->prepare("DELETE FROM ".$tablename."  WHERE PromoID = ?"))
	{
	$stmt->bind_param("i", $id);
	$return = $stmt->execute();
	$stmt->close();
	} 
}
elseif ($tablename == 'shipment')
{
	if ( $stmt = $mysqli->prepare("DELETE FROM ".$tablename."  WHERE ShipmentID = ?"))
	{
	$stmt->bind_param("i", $id);
	$return = $stmt->execute();
	$stmt->close();
	} 
}
elseif ($tablename == 'supplier')
{
	if ( $stmt = $mysqli->prepare("DELETE FROM ".$tablename."  WHERE SupplierID = ?"))
	{
	$stmt->bind_param("i", $id);
	$return = $stmt->execute();
	$stmt->close();
	} 
}
            
$mysqli->close();        

echo $return ? "ok" : "error";

      

