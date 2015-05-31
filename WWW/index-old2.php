<?php 
	include_once('./func/sqlconn.php');
	$bldg=$_GET['bldg'];
	$room=$_GET['room'];
	if(class_exists('Memcache')){	
		$mc = new Memcache;
		$mc->connect($MC_SERVER, $MC_PORT);
		if(!$resultb = $mc->get('openlabs_home_bldgs')){
			$tmp = mysqli_query($con,"SELECT * FROM " . $DB_BUILDINGS . " ORDER BY NAME");
			$resultb = array();
			while ($row = mysqli_fetch_assoc($tmp)) {
				array_push($resultb, $row);	
			}
			$mc->set('openlabs_home_bldgs', $resultb, 0, 60);
		}     
		if(strlen($_GET['bldg']) > 0 && strlen($_GET['room']) == 0){            
            $key = 'openlabs_brws_' . $_GET['bldg'];
            if(!$result = $mc->get($key)){
                $tmp = mysqli_query($con,sprintf("SELECT * FROM `" . $DB_COMPUTERS . "` WHERE `BUILDING`=\"%s\" ORDER BY ROOM ASC,COMPNO ASC,HOSTNAME ASC",mysqli_real_escape_string($con,$bldg)));
                $result = array();
                while ($row = mysqli_fetch_assoc($tmp)) {
                    array_push($result, $row);	
                }
                $mc->set($key, $result, 0, 60);
            }        
		}        
		elseif (strlen($_GET['bldg']) > 0 && strlen($_GET['room']) > 0){
            $key = 'openlabs_brws_' . $_GET['bldg'] . '_' . $_GET['room'];
            if(!$result = $mc->get($key)){
                $tmp = mysqli_query($con,sprintf("SELECT * FROM `" . $DB_COMPUTERS . "` WHERE `BUILDING`=\"%s\" and `ROOM`=\"%s\" ORDER BY COMPNO ASC,HOSTNAME 
                    ASC",mysqli_real_escape_string($con,$bldg),mysqli_real_escape_string($con,$room)));
                $result = array();
                while ($row = mysqli_fetch_assoc($tmp)) {
                    array_push($result, $row);	
                }
                $mc->set($key, $result, 0, 60);
            }         
		}        
		else{
            if(!$result = $mc->get('openlabs_home_all')){
                $tmp = mysqli_query($con,"SELECT * FROM `" . $DB_COMPUTERS . "` ORDER BY BUILDING ASC,ROOM ASC,COMPNO ASC");
                $result = array();
                while ($row = mysqli_fetch_assoc($tmp)) {
                    array_push($result, $row);	
                }
                $mc->set('openlabs_home_all', $result, 0, 60);
            }            
		}		
		$mc->close();
	}
	else{     
        if(strlen($_GET['bldg']) > 0 && strlen($_GET['room']) == 0){            
            $tmp = mysqli_query($con,sprintf("SELECT * FROM `" . $DB_COMPUTERS . "` WHERE `BUILDING`=\"%s\" ORDER BY ROOM ASC,COMPNO ASC,HOSTNAME ASC",mysqli_real_escape_string($con,$bldg)));
            $result = array();
            while ($row = mysqli_fetch_assoc($tmp)) {
                array_push($result, $row);	
            }
        }        
        elseif (strlen($_GET['bldg']) > 0 && strlen($_GET['room']) > 0){           
           $tmp = mysqli_query($con,sprintf("SELECT * FROM `" . $DB_COMPUTERS . "` WHERE `BUILDING`=\"%s\" and `ROOM`=\"%s\" ORDER BY COMPNO ASC,HOSTNAME 
                    ASC",mysqli_real_escape_string($con,$bldg),mysqli_real_escape_string($con,$room)));
           $result = array();
           while ($row = mysqli_fetch_assoc($tmp)) {
               array_push($result, $row);	
           }
        }	    
        else{
           $tmp = mysqli_query($con,"SELECT * FROM `" . $DB_COMPUTERS . "` ORDER BY BUILDING ASC,ROOM ASC,COMPNO ASC");
           $result = array();
           while ($row = mysqli_fetch_assoc($tmp)) {
               array_push($result, $row);	
           }
        }
		$tmp = mysqli_query($con,"SELECT * FROM " . $DB_BUILDINGS . " ORDER BY NAME");
		$resultb = array();
		while ($row = mysqli_fetch_assoc($tmp)) {
			array_push($resultb, $row);	
		}
	}	
	$id = "browse";	
	$resultr = mysqli_query($con,sprintf("SELECT * FROM `" . $DB_ROOMS . "` WHERE `BUILDING`=\"%s\" ORDER BY ROOM",mysqli_real_escape_string($con,$bldg))); 
	
	//Listing Name --> $head
	if(strlen($bldg) > 0 || strlen($room) > 0) {$head = $bldg . " " . $room;}
	else {$head = "ALL COMPUTERS";}

	$time = time();
	$avail = 0;
	$total = 0;
	
	$tablestring;
	foreach($result as &$row){
		if($row == null) break;	
		if(class_exists('Memcache'))
		{
		  $mc = new Memcache;
		  $mc->connect($MC_SERVER, $MC_PORT);
		  $key = 'openlabs_comp_' . strtoupper($row['HOSTNAME']);
		  if(!$tstamp = $mc->get($key)){$tstamp = time() - 200;}
		  $mc->close();
		}
		else{$tstamp = $row['TIMESTAMP'];}
		$diff  = $time - $tstamp;
		$last= floor($diff/60);
		if($diff < 180){$stat="danger";}
		elseif($tstamp == 0){$stat="warning";}
		else
		{
			if($row['SERVICE'] > 0){$stat="warning";}
			elseif($row['SERVICE'] == 0){$stat="success"; $avail++;}
		}			
		$total++;
		$tablestring = $tablestring . "<tr class=" . $stat . "><td>" . $row['BUILDING'] . "</td><td>" . $row['ROOM'] . "</td><td>" . $row['COMPNO'] . "</td><td>" . $row['OS'] . "</td></tr>";		
	}	

	mysqli_close($con);
?>
<!DOCTYPE html>
<html>
	<head>
	
		<title>Sojourner Truth Library</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">	
		<meta name="apple-mobile-web-app-status-bar-style" content="black">	
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="css/openlabs.css" rel="stylesheet">
		<meta http-equiv="refresh" content="30" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="mobile-web-app-capable" content="yes">
		<link rel="apple-touch-icon" href="css/ico.png">
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->		
		<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1','packages':['corechart']}]}"></script>
		<script type="text/javascript">
			google.setOnLoadCallback(drawChart);
	      function drawChart() {
	
	        var data = google.visualization.arrayToDataTable([
	          ['# Computers', 'Availability'],
	          ['Available',   <?php echo $avail; ?>  ],
	          ['Unavailable',  <?php echo $total - $avail; ?>    ]
	        ]);
	
	        var options = {
	            legend: 'none',
	            pieSliceText: 'value',
	            colors: ['green', 'red']
	        };
	
	        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
	
	        chart.draw(data, options);
	      }
		</script>
	</head>
	<body>
		<div class="container">
			<div class="headerbar"><center><h1>STL Computer Availability</h1></div>
			<div class="colorbar"><img src="css/colorbar.jpg" width="100%" height="20" alt="" /></div>
			<div class="content">
				<div class="row">
					<div class="col-md-3 col-sm-4">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="panel panel-default">
									<div class="panel-heading"><center><h1 class="panel-title">FILTER</h1></div>
									<div class="panel-body">
										<form method=get action="index.php" class="form-horizontal">
											<div class="form-group">
												<select class="form-control" name='bldg' onchange='this.form.submit()'>
													<?php
														if(strlen($bldg) > 0){echo "<option value='$bldg'>$bldg</option>";}
														else{echo "<option value=''>Select Building</option>";}	
														foreach($resultb as &$value){echo "<option value=" . $value['NAME'] . ">" . $value['NAME'] . "</option>";}
													?>
												</select>
											</div>
											<div class="form-group">
												<select class="form-control" name='room' onchange='this.form.submit()'>
													<?php
														if(strlen($room > 0)) {echo "<option value=''>" . $room . "</option>";}
														else {echo "<option value=''>Select Room</option>";}
														while($row = mysqli_fetch_array($resultr)){echo "<option value=" . $row['ROOM'] . ">" . $row['ROOM'] . "</option>";}
													?>
												</select>
											</div>
											<noscript><input type="submit" value="Submit"></noscript>	
										</form>
										<div class="form-group"><form action="index.php"><input type="submit" value="Reset" class="btn btn-primary"></form></div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="panel panel-default">
									<div class="panel-heading"><center><h1 class="panel-title">CURRENT USAGE</h1></div>
									<div class="panel-body">
										<?php echo $avail . " / " . $total . " Computers Available"; ?>
										<div id="piechart" style="width: 100%;"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-9 col-sm-8 col-xs-12">
						<div class="panel panel-default">
							<div class="panel-heading"><center><h1 class="panel-title"><?php echo $head; ?></h1></div>
							<div class="panel-body">
								<table class="table">
									<thead>
										<tr>
											<th>Building</th>
											<th>Room</th>
											<th>Num.</th>
											<th>OS</th>
										</tr>
									</thead>
									<tbody>
										<?php echo $tablestring; ?>
									</tbody>
								</table>
							</div>	
						</div>
					</div>	
				</div>
			</div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>
