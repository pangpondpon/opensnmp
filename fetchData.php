#!/usr/bin/php
<?php
  //Get Data Pass
  $session = new SNMP(SNMP::VERSION_1, "192.168.1.1", "public");


  //$sysdescr = $session->walk("ifTable");
  //$sysdescr = $session->walk("1.3.6.1.2.1.2.2.1.10.23");

  // 3bb card
  $in_3bb = $session->get("ifInOctets.21");
  $in_3bb = str_replace('Counter32: ', '', $in_3bb);
  //echo $in_3bb."\n"; // From 3bb to card

  $out_3bb = $session->get("ifOutOctets.21");
  $out_3bb = str_replace('Counter32: ', '', $out_3bb);
  //echo $out_3bb."\n"; // from card Out to 3bb

  // lan card
  $in_lan = $session->get("ifInOctets.19");
  $in_lan = str_replace('Counter32: ', '', $in_lan);
  //echo $in_lan."\n"; // from lan to card

  $out_lan = $session->get("ifOutOctets.19");
  $out_lan = str_replace('Counter32: ', '', $out_lan);
  //echo $out_lan."\n"; // from card to lan

  //echo "$sysdescr\n";
  //$sysdescr = $session->get(array("sysDescr.0"));
  //echo $sysdescr["IF-MIB::ifOutOctets.23"];
  	
  	//Prepare Variable
  	$servername = "127.0.0.1";
	$username = "root";
	$password = "root";
	$dbname = "opensnmp";

	// Create connection
	$conn = mysql_connect($servername, $username, $password);
	mysql_select_db($dbname, $conn);

	$out_3bb_int = intval($out_3bb);
	$in_3bb_int = intval($in_3bb);
	$in_lan_int = intval($in_lan);
	$out_lan_int = intval($out_lan);
	$sql = "INSERT INTO ops_up_down (out_to_3bb, in_from_3bb, out_to_lan, in_from_lan) 
			VALUES ($out_3bb_int, $in_3bb_int, $out_lan_int, $in_lan_int)";
	$retval = mysql_query( $sql, $conn );
	mysql_close();

?>