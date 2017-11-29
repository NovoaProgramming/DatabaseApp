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

// initialize the return value as false, used to determine the success of the INSERT later
$return=false;
// Get all parameter provided by the javascript for the table
$tablename = $mysqli->real_escape_string(strip_tags($_POST['tablename']));
if ($tablename == 'employee')
{
	$ReportsTo = $mysqli->real_escape_string(strip_tags($_POST['ReportsTo']));
	$HireDate = $mysqli->real_escape_string(strip_tags($_POST['HireDate']));
	$FirstName = $mysqli->real_escape_string(strip_tags($_POST['FirstName']));
	$LastName = $mysqli->real_escape_string(strip_tags($_POST['LastName']));
	$Title = $mysqli->real_escape_string(strip_tags($_POST['Title']));
	$DateOfBirth = $mysqli->real_escape_string(strip_tags($_POST['DateOfBirth']));
	$JobTitle = $mysqli->real_escape_string(strip_tags($_POST['JobTitle']));
	$Address = $mysqli->real_escape_string(strip_tags($_POST['Address']));
	$City = $mysqli->real_escape_string(strip_tags($_POST['City']));
	$State = $mysqli->real_escape_string(strip_tags($_POST['State']));
	$Zip = $mysqli->real_escape_string(strip_tags($_POST['Zip']));
	$Country = $mysqli->real_escape_string(strip_tags($_POST['Country']));
	$Phone = $mysqli->real_escape_string(strip_tags($_POST['Phone']));
	$Email = $mysqli->real_escape_string(strip_tags($_POST['Email']));
	
	if ( $stmt = $mysqli->prepare("INSERT INTO ".$tablename."  (ReportsTo, HireDate, FirstName,
	LastName, Title, DateOfBirth, JobTitle, Address, City, State, Zip, Country, Phone, Email) 
	VALUES (  ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))
	{
	$stmt->bind_param("isssssssssssss", $ReportsTo, $HireDate, $FirstName, $LastName, $Title,
	$DateOfBirth, $JobTitle, $Address, $City, $State, $Zip, $Country, $Phone, $Email);
    $return = $stmt->execute();
	$stmt->close();
	}           
}
elseif ($tablename == 'promo')
{
	$PremiumPromotion = $mysqli->real_escape_string(strip_tags($_POST['PremiumPromotion']));
	$Category = $mysqli->real_escape_string(strip_tags($_POST['Category']));
	$Requirements = $mysqli->real_escape_string(strip_tags($_POST['Requirements']));
	$StartDate = $mysqli->real_escape_string(strip_tags($_POST['StartDate']));
	$EndDate = $mysqli->real_escape_string(strip_tags($_POST['EndDate']));
	$Effect = $mysqli->real_escape_string(strip_tags($_POST['Effect']));
	
	if ( $stmt = $mysqli->prepare("INSERT INTO ".$tablename."  (PremiumPromotion, Category, Requirements,
	StartDate, EndDate, Effect) 
	VALUES (  ?, ?, ?, ?, ?, ?)"))
	{
	$stmt->bind_param("isssss", $PremiumPromotion, $Category, $Requirements, $StartDate, $EndDate, $Effect);
    $return = $stmt->execute();
	$stmt->close();
	}           
}
elseif ($tablename == 'shipment')
{
	$SupplierID = $mysqli->real_escape_string(strip_tags($_POST['SupplierID']));
	$EmployeePlacedOrder = $mysqli->real_escape_string(strip_tags($_POST['EmployeePlacedOrder']));
	$EmployeeReceivedOrder = $mysqli->real_escape_string(strip_tags($_POST['EmployeeReceivedOrder']));
	$OrderStatus = $mysqli->real_escape_string(strip_tags($_POST['OrderStatus']));
	$TrackingNumber = $mysqli->real_escape_string(strip_tags($_POST['TrackingNumber']));
	$ShippedDate = $mysqli->real_escape_string(strip_tags($_POST['ShippedDate']));
	$ExpectedArrivalDate = $mysqli->real_escape_string(strip_tags($_POST['ExpectedArrivalDate']));
	$ActualArrivalDate = $mysqli->real_escape_string(strip_tags($_POST['ActualArrivalDate']));
	$TotalCost = $mysqli->real_escape_string(strip_tags($_POST['TotalCost']));
	$ShippingCost = $mysqli->real_escape_string(strip_tags($_POST['ShippingCost']));
	
	if ( $stmt = $mysqli->prepare("INSERT INTO ".$tablename."  (SupplierID, EmployeePlacedOrder, EmployeeReceivedOrder,
	OrderStatus, TrackingNumber, ShippedDate, ExpectedArrivalDate, ActualArrivalDate, TotalCost, ShippingCost) 
	VALUES (  ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))
	{
	$stmt->bind_param("iiisssssss", $SupplierID, $EmployeePlacedOrder, $EmployeeReceivedOrder,
	$OrderStatus, $TrackingNumber, $ShippedDate, $ExpectedArrivalDate, $ActualArrivalDate, $TotalCost, $ShippingCost);
    $return = $stmt->execute();
	$stmt->close();
	}           
}
elseif ($tablename == 'supplier')
{
	$CompanyName = $mysqli->real_escape_string(strip_tags($_POST['CompanyName']));
	$Address = $mysqli->real_escape_string(strip_tags($_POST['Address']));
	$City = $mysqli->real_escape_string(strip_tags($_POST['City']));
	$State = $mysqli->real_escape_string(strip_tags($_POST['State']));
	$Zip = $mysqli->real_escape_string(strip_tags($_POST['Zip']));
	$Country = $mysqli->real_escape_string(strip_tags($_POST['Country']));
	$Website = $mysqli->real_escape_string(strip_tags($_POST['Website']));
	$ContactFirstName = $mysqli->real_escape_string(strip_tags($_POST['ContactFirstName']));
	$ContactLastName = $mysqli->real_escape_string(strip_tags($_POST['ContactLastName']));
	$ContactTitle = $mysqli->real_escape_string(strip_tags($_POST['ContactTitle']));
	$Phone = $mysqli->real_escape_string(strip_tags($_POST['Phone']));
	$Ext = $mysqli->real_escape_string(strip_tags($_POST['Ext']));
	$Email = $mysqli->real_escape_string(strip_tags($_POST['Email']));
	$PreferredMethodOfContact = $mysqli->real_escape_string(strip_tags($_POST['PreferredMethodOfContact']));
	
	if ( $stmt = $mysqli->prepare("INSERT INTO ".$tablename."  (CompanyName, Address, City,
	State, Zip, Country, Website, ContactFirstName, ContactLastName, ContactTitle, Phone,
	Ext, Email, PreferredMethodOfContact) 
	VALUES (  ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))
	{
	$stmt->bind_param("ssssssssssssss", $CompanyName, $Address, $City,
	$State, $Zip, $Country, $Website, $ContactFirstName, $ContactLastName, $ContactTitle,
	$Phone, $Ext, $Email, $PreferredMethodOfContact);
    $return = $stmt->execute();
	$stmt->close();
	}           
}


  
$mysqli->close();        

echo $return ? "ok" : "error";

?>