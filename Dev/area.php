<!doctype html>
<head>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js"></script>
  <script src="js/morris.js"></script>
  <script src="lib/example.js"></script>
  <link rel="stylesheet" href="lib/example.css">
  <link rel="stylesheet" href="css/morris.css">
</head>
<body>
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
      //echo $str;
      mysql_close();
?>
<h1>Area charts</h1>
<div id="graph"></div>
<pre id="code" hidden>
// Use Morris.Area instead of Morris.Line
Morris.Area({
  element: 'graph',
  data: [
  <?php
      echo $str;
  ?>
  xkey: 'x',
  ykeys: ['y', 'z'],
  labels: ['Upload', 'Download']
}).on('click', function(i, row){
  console.log(i, row);
});
</pre>
</body>
