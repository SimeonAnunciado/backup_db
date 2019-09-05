<?php 

$conn = new mysqli($host = 'localhost', $user = 'root', $pass = '', $dbname = 'shareposts');
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

function current_db(){
	GLOBAL $conn;
	$sql = "SELECT DATABASE()";
	$result = $conn->query($sql);
	if ($row = $result->fetch_array()) {
	echo $row[0];
	}
}



// echo current_db();
// echo '<pre>' .print_r(select_tbls(),TRUE) . '</pre>';



function select_tbls(){
	GLOBAL $conn;
	$tables = array();
	$sql = "SHOW TABLES";
	$query = $conn->query($sql);
	while($row = $query->fetch_row()){
		$tables[] = $row[0];
	}
	return $tables;
}



 ?>