<?php
      $servername = "127.0.0.1";
      $username = "root";
      $password = "root";
      $dbname = "opensnmp";

      // Create connection
      $conn = mysql_connect($servername, $username, $password);
      mysql_select_db($dbname, $conn);

      $sql = "SELECT time,out_to_3bb,in_from_3bb FROM `ops_log` ";
      $retval = mysql_query( $sql, $conn );
      $time = "";
      $out = "";
      $in = "";
      $str = "";
      while($row = mysql_fetch_array($retval, MYSQL_ASSOC)) {
        $time = $row["time"];
        $out= intval($row["out_to_3bb"]);
        $out = intval($out/6)/1000000000;
        $out = number_format($out, 2, '.', '');
        $in = intval($row["in_from_3bb"]);
        $in = intval($in/6)/1000000000;
        $in = number_format($in, 2, '.', '');
        $str .= "{x:'".$time."', y:".$out.", z:".$in."},";
      }
      //$str = substr($str, 0, -1);
      $str = rtrim($str, ",");
      $str .= "],";
      echo $str;
      mysql_close();
?>