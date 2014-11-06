<!DOCTYPE html>
<!-- saved from url=(0040)http://getbootstrap.com/examples/navbar/ -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="ico/ico.ico">

    <title>Error Alert</title>

    <!-- Bootstrap core CSS -->
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://getbootstrap.com/examples/navbar/navbar.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="./Navbar Template for Bootstrap_files/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

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
            <a class="navbar-brand" href="index.php">OpenSNMP</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="dropdown ">
                <a href="http://getbootstrap.com/examples/navbar/#" class="dropdown-toggle" data-toggle="dropdown">Alert <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li ><a href="index.php">All</a></li>
                  <li><a href="Alert_Fine.php">Fine</a></li>
                  <li class="active"><a href="#">Error</a></li>
                </ul>
              </li>
              <li class="dropdown">
                <a href="http://getbootstrap.com/examples/navbar/#" class="dropdown-toggle" data-toggle="dropdown">Bandwidth <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="Bandwidth_Lan.php">Lan Card</a></li>
                  <li><a href="Bandwidth_3bb.php">3BB Card</a></li>
                </ul>
              </li>
            </ul>
            
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>Error Alert</h1>
        <div class="preloadphp">
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
                if(strcmp($type, 'Error')==0){ // Alert is Fine
                  echo '<div class="alert alert-danger" role="alert">Time : '.$time.'<br/>
                        Message : '.$desc.'
                      </div>';
                }
              }
              mysql_close();
            ?>
        </div>
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