#!/usr/bin/php
<?php
  
  //Prepare Variable
  $servername = "127.0.0.1";
	$username = "root";
	$password = "root";
	$dbname = "opensnmp";

	// Create connection
	$conn = mysql_connect($servername, $username, $password);
	mysql_select_db($dbname, $conn);

  //Query
  $sql = "SELECT YEAR(time), DAYOFYEAR(time), HOUR(time), 
    sum(out_to_3bb) as out_to_3bb, sum(in_from_3bb) as in_from_3bb, 
    sum(out_to_lan) as out_to_lan, sum(in_from_lan) as in_from_lan 
    FROM ops_up_down WHERE YEAR(time)= (SELECT YEAR(time) 
    FROM ops_up_down ORDER BY id DESC LIMIT 1) 
    AND DAYOFYEAR(time) = (SELECT if(HOUR(time)=0,DAYOFYEAR(time)-1,DAYOFYEAR(time)) 
    FROM ops_up_down ORDER BY id DESC LIMIT 1) 
    AND HOUR(time) = (SELECT if(HOUR(time)=0,23,HOUR(time)-1) 
    FROM ops_up_down ORDER BY id DESC LIMIT 1)";
  $retval = mysql_query( $sql, $conn );

  //Declare variable
  $out_3bb_int = 0;
  $in_3bb_int = 0;
  $in_lan_int = 0;
  $out_lan_int = 0;

  //Loop to get data
  while($row = mysql_fetch_array($retval, MYSQL_ASSOC)) {
    /*echo $row["out_to_3bb"]."\n";
    echo $row["in_from_3bb"]."\n";
    echo $row["out_to_lan"]."\n";
    echo $row["in_from_lan"]."\n";*/
    $out_3bb_int = intval($row["out_to_3bb"]);
    $in_3bb_int = intval($row["in_from_3bb"]);
    $in_lan_int = intval($row["in_from_lan"]);
    $out_lan_int = intval($row["out_to_lan"]);
  }

  /*echo $out_3bb_int."\n";
  echo $in_3bb_int."\n";
  echo $in_lan_int."\n";
  echo $out_lan_int."\n";*/

  //Crate variable for log
  $errdescr = "Everything is fine for now.";
  $errstatus = "Fine";

  //Check bottle neck problem
  if(floatval($in_lan_int)>floatval($out_3bb_int)*2){
    $errstatus = "Error";
    $errdescr = "Seem like we have bottle neck problam at this time.";
  }

  //Check upload > download problem
  if(floatval($in_lan_int)>floatval($out_lan_int)){
    $errstatus = "Error";
    $errdescr = "Seem like we have upload package more than download here.";
  }

  //Create Log
  $sql = "INSERT INTO ops_log (type, description, out_to_3bb, in_from_3bb, out_to_lan, in_from_lan) 
      VALUES ('$errstatus', '$errdescr',$out_3bb_int,$in_3bb_int,$out_lan_int,$in_lan_int)";
  $log = mysql_query( $sql, $conn );

  //Close connection
	mysql_close();

?>