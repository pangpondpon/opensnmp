<!DOCTYPE html>
<!-- saved from url=(0040)http://getbootstrap.com/examples/navbar/ -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="http://getbootstrap.com/favicon.ico">

    <title>Navbar Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://getbootstrap.com/examples/navbar/navbar.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="./Navbar Template for Bootstrap_files/ie-emulation-modes-warning.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js"></script>
    <script src="js/morris.js"></script>
    <script src="lib/example.js"></script>
    <link rel="stylesheet" href="lib/example.css">
    <link rel="stylesheet" href="css/morris.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
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

      $sql = "SELECT time,out_to_lan,in_from_lan FROM `ops_log` ";
      $retval = mysql_query( $sql, $conn );
      $time = "";
      $out = "";
      $in = "";
      $str = "";
      while($row = mysql_fetch_array($retval, MYSQL_ASSOC)) {
        $time = $row["time"];
        $out= intval($row["out_to_lan"]);
        $out = intval($out/6)/1000000000;
        $out = number_format($out, 2, '.', '');
        $in = intval($row["in_from_lan"]);
        $in = intval($in/6)/1000000000;
        $in = number_format($in, 2, '.', '');
        $str .= "{x:'".$time."', y:".$in.", z:".$out."},";
      }
      //$str = substr($str, 0, -1);
      $str = rtrim($str, ",");
      $str .= "],";
      //echo $str;
      mysql_close();
?>
    <div class="container">

      <!-- Static navbar -->
      <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="http://getbootstrap.com/examples/navbar/#">OpenSNMP</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="dropdown ">
                <a href="http://getbootstrap.com/examples/navbar/#" class="dropdown-toggle" data-toggle="dropdown">Alert <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li ><a href="index.php">All</a></li>
                  <li ><a href="Alert_Fine.php">Fine</a></li>
                  <li><a href="Alert_Error.php">Error</a></li>
                </ul>
              </li>
              <li class="dropdown">
                <a href="http://getbootstrap.com/examples/navbar/#" class="dropdown-toggle" data-toggle="dropdown">Bandwidth <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li class="active"><a href="#">Lan Card</a></li>
                  <li><a href="Bandwidth_3bb.php">3BB Card</a></li>
                </ul>
              </li>
            </ul>
            
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>Lan Bandwidth</h1>
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
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="./Navbar Template for Bootstrap_files/jquery.min.js"></script>
    <script src="./Navbar Template for Bootstrap_files/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="./Navbar Template for Bootstrap_files/ie10-viewport-bug-workaround.js"></script>
  

</body></html>