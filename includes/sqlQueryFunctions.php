<?php
	function checkUserPrivilegesQuery($username) {
		@ $db = new mysqli('localhost', 'root', 'DefaultRootPass123!', 'virtualtechgamingstore');
		
		$result = mysqli_query($db,
			"SELECT tp.db AS `Database`, tp.`user` AS Username, tp.table_name AS 'Table Name',
				IF(tp.table_priv IS NULL OR tp.table_priv = '', 'N/A', tp.table_priv) AS 'Privileges on Whole Table',
				IF(tp.column_priv IS NULL OR tp.column_priv = '', 'Same as table privileges', tp.column_priv) AS 'Column Privileges',
				IF(cp.column_name IS NULL OR cp.column_name = '', 'all', cp.column_name) AS 'Column With Privilege'
			FROM mysql.tables_priv AS tp LEFT JOIN mysql.columns_priv AS cp
			ON tp.`user` = cp.`user` AND tp.column_priv = cp.column_priv
			WHERE tp.user = '".$username."'
			ORDER BY tp.table_name ASC;");
		
		return $result;
	}
	function viewTableQuery($tableName, $username, $password) {
		@ $db = new mysqli('localhost', $username, $password, 'virtualtechgamingstore');
		
		$result = mysqli_query($db,'SELECT * FROM ' . $tableName . ' ;');
		
		return $result;
	}
?>