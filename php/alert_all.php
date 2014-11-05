<?php
	$servername = "127.0.0.1";
	$username = "root";
	$password = "root";
	$dbname = "opensnmp";

	// Create connection
	$conn = mysql_connect($servername, $username, $password);
	mysql_select_db($dbname, $conn);

	$sql = "SELECT time,type,description FROM `ops_log` 
			ORDER BY id DESC";
	$retval = mysql_query( $sql, $conn );
	$time = "";
	$type= "";
	$desc = "";

	while($row = mysql_fetch_array($retval, MYSQL_ASSOC)) {
		$time = $row["time"];
		$type= $row["type"];
		$desc = $row["description"];
		if(strcmp($type, 'Fine')==0){ // Alert is Fine
			echo '<div class="alert alert-success" role="alert">Time : '.$time.'<br/>
					  Message : '.$desc.'<br/>
					</div>';
		}else{ // Alert is Error
			echo '<div class="alert alert-danger" role="alert">Time : '.$time.'<br/>
					  Message : '.$desc.'<br/>
					</div>';
		}
  	}
	mysql_close();
?>

<!-- <div class="alert alert-success" role="alert">Time : 28/25/2014 08:10:00<br/>
  Message : Everyting is fine for now.<br/>
</div>
<div class="alert alert-danger" role="alert">Time : 28/25/2014 08:10:00<br/>
  Message : Seem like we have problem here.<br/>
</div> -->