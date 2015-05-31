<?php 
	include_once('./func/sqlconn.php');
	$bldg=$_GET['bldg'];
	$room=$_GET['room'];
	//$memon = "zzz";
	$MC_SERVER = 'localhost';
	$MC_PORT = 11211;
	if(class_exists('Memcache')){	
		$mc = new Memcache;
		$mc->connect($MC_SERVER, $MC_PORT);
		$memon = "memthing";
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
	$tableasdivs;
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
		if($diff < 180){$stat="danger";$statlabel="In Use";}
		elseif($tstamp == 0){$stat="warning";$statlabel="unavailable";}
		else
		{
			if($row['SERVICE'] > 0){$stat="warning";$statlabel="unavailable";}
			elseif($row['SERVICE'] == 0){$stat="success";$statlabel="Available"; $avail++;}
		}			
		$total++;
		//laptops need a seperate count of total and available - two field in the computers table type and status - additional if laptop use status field for status or 30 min countdown to ready
		//if ($row['ROOM']!=="Laptop"){$tablestring = $tablestring . "<tr class=" . $stat . "><td>" . $row['BUILDING'] . "</td><td>" . $row['ROOM'] . "</td><td>" . $row['COMPNO'] . "</td><td>" . $row['OS'] . "</td></tr>";}
		if ($row['ROOM']!=="Laptop"){$tableasdivs = $tableasdivs . "<div class=" . $stat . ">" . $row['BUILDING'] . " " . $row['ROOM'] . " <big><b>" . $row['COMPNO'] . "</b></big> " . $statlabel . "</div>";}
		elseif($row['ROOM']=="Laptop"){$laptopsasdivs = $laptopsasdivs . "<div class=" . $stat . ">" . $row['BUILDING'] . " " . $row['ROOM'] . " <big><b>" . $row['COMPNO'] . "</b></big> " . $statlabel . "</div>";}
	}	

	mysqli_close($con);
?>
<!DOCTYPE html>
<html>
	<head>


		<title>Library PC Availability</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">	
		<meta name="apple-mobile-web-app-status-bar-style" content="black">	
		<link href="/newpage/css/ptsansnarrowfont/ptnarrowfont.css" type="text/css" rel="stylesheet"></link>
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
<style type="text/css">
<!--
.justaday { white-space: nowrap;}
.xdate {display:none;}
.regularday {display:none;}
.specialday {display:none;}
span.dayow::after {    content: " Hours: ";)}
.headerbar {background-color:white; !important}
.headerbar h1{font-family: pt_sans_narrowregular,"Arial Narrow",Arial,Helvetica,sans-serif;}
.pcdivbox {margin-left:1px;display:block; width:100%;padding: 4px;
}
div.success {width: 190px;height: 30px;margin: 4px;float: left;
    color:darkgreen;background-color:palegreen;padding: 0px; text-align: center;
	display: table-cell;
    vertical-align: middle }
div.danger {width: 190px;height: 30px;margin: 4px;float: left;
    color:darkgray;background-color:#e8e8e8;padding: 0px;display: table-cell; vertical-align: middle;text-align: center;
	}
div.warning {width: 190px;height: 30px;margin: 4px;float: left;
    color:lightgray;background-color:white;padding: 0px;display: table-cell; vertical-align: middle;text-align: center;
	}
.hours 	{display:inline-block;float:right;width:auto;}
-->
</style>
		<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1','packages':['corechart']}]}"></script>
		<script type="text/javascript">
			google.setOnLoadCallback(drawChart);
	      function drawChart() {
	      google.load("visualization", "1", {packages:["corechart"]});
	        var data = google.visualization.arrayToDataTable([
	          ['# Computers', 'Availability'],
	          ['Available',   <?php echo $avail; ?>  ],
	          ['Unavailable',  <?php echo $total - $avail; ?>    ]
	        ]);
				
	        var options = {
			    fontSize: 12,
			    chartArea:{
				    left:5,
					top:0, 
					width:'92%', 
					height:'92%',
					},
				//pieStartAngle: 120,
	            legend: 'bottom',
	            pieSliceText: 'value',
				pieSliceTextStyle:{
				    fontSize: 14,
					 bold: true,
				    },
	          is3D: true,
			  colors: ['lightgreen', 'gray']
	        };
	        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
	        chart.draw(data, options);
	      }
		</script>
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
			ga('create', 'UA-23564112-1', 'auto');
			ga('send', 'pageview');
		</script>
	</head>
	<body>
		<div class="container">
		<div class="colorbar"><img src="css/colorbar.jpg" width="100%" height="24" alt="" /></div>
			<div class="headerbar"><script src="/LibraryHoursScript.js" type="text/javascript"></script>
			<div id="hours" class="hours" style=""></div>			
			<script type="text/javascript">
			 var calarea=document.getElementById("hours");
             calarea.innerHTML=(buildCal(m , y , day , "days" , 1, 0 , 1));
            </script>
			<h1>Library PC Availability</h1><!-- <?Php  echo time(); ?> -->
        </div>

			<div class="content">
				<div class="row">
					<div class="col-md-3 col-sm-4">
						<!--<div class="row">
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
						</div> -->
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="panel panel-default">
									<div class="panel-heading"><center><h1 class="panel-title">CURRENT PC USAGE</h1></div>
									<div class="panel-body">
										<div style="text-align:center;"><?php echo "<b>" . $avail . "</b> PCs Available out of <b>" . $total . "</b> "; ?></div>
										<div id="piechart" style="width: 100%;"></div>
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-9 col-sm-8 col-xs-12">
						<div class="panel panel-default">
						<!-- list as DIVs floating --><center><b>For information only. You may not reserve PCs.</b></center>
						<div class="panel-heading"><center><h1 class="panel-title">Library PCs</h1></div>
						  <div class="panel-body">
						  <img src="css/computers.png" style="width:100%;">
						  <div class="pcdivbox"><?php echo $tableasdivs; ?></center></div>
						</div>
						<div class="panel-heading"><center><h1 class="panel-title">Library Laptops</h1></div>
						  <div class="panel-body">
                        <?php 
						$last_modified = filemtime("/var/www/html/contentfiles/userfiles/images/screenshot.png"); 
						$difference=time()-$last_modified;
						If ($difference>=600){print('<center><h2>Laptop availablity is currently unavailable</h2></center>');}
						else {print('<center><img id="laptopimg" alt="The laptop charger program screen" src="/contentfiles/userfiles/images/screenshot.png" style="width:100%"></center>');}
						?> 
						</div>
							<!-- <div class="panel-heading"><center><h1 class="panel-title"><?php echo $head; ?></h1></div> 
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
							</div>	-->
						</div>
					</div>	
					<!--	<?php echo $memon ?>	-->
				</div>
			</div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		
	</body>
</html>
