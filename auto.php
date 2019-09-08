<?php 

	date_default_timezone_set('Asia/Manila');

	$host = 'localhost';
	$user = 'root';
	$pass = '';
	$dbname = 'test';



	$conn = new mysqli($host, $user , $pass , $dbname);
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}


		//getting table structures
		// loop all tables
		$tables = select_all_tables();

		
		$outsql = '';
		foreach ($tables as $key => $table) {

		    // Prepare SQLscript for creating table structure
		    $sql = "SHOW CREATE TABLE $table";
		    $query = $conn->query($sql);

		    $row = $query->fetch_row();
		    
		    $outsql .= "\n\n" . $row[1] . ";\n\n";
		    
		    $sql = "SELECT * FROM $table";
		    $query = $conn->query($sql);
		    
		    $columnCount = $query->field_count;

		    // Prepare SQLscript for dumping data for each table
		    for ($i = 0; $i < $columnCount; $i ++) {
		        while ($row = $query->fetch_row()) {
		            $outsql .= "INSERT INTO $table VALUES(";
		            for ($j = 0; $j < $columnCount; $j ++) {
		                $row[$j] = $row[$j];
		                
		                if (isset($row[$j])) {
		                    $outsql .= '"' . $row[$j] . '"';
		                } else {
		                    $outsql .= '""';
		                }
		                if ($j < ($columnCount - 1)) {
		                    $outsql .= ',';
		                }
		            }
		            $outsql .= ");\n";
		        }
		    }
		    
		    $outsql .= "\n"; 
	    }


	    $date = date('Y-m-d_H_i_s');
	    $backup_file_name = 'database_backup/'.$date.'_'.$dbname.'_backup.sql';
	    $fileHandler = fopen($backup_file_name, 'w+');
	    $fwrite = fwrite($fileHandler, $outsql);
	    $fclose = fclose($fileHandler);

	    if ($fileHandler AND $fwrite AND $fclose ) {
   			echo 'SUCCESS DATABASE BACK UP!';
	    }else{
	    	echo "ERROR {$dbname} DATABASE BACK UP !";
	    }


	    // readfile($backup_file_name);
	    // exec('rm ' . $backup_file_name);


   		function current_db(){
   			GLOBAL $conn;
   			$sql = "SELECT DATABASE()";
   			$result = $conn->query($sql);
   			if ($row = $result->fetch_array()) {
   				echo $row[0];
   			}
   		}



   		function select_all_tables(){
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