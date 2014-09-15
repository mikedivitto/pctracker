<?php
$PageTitle="User Management";	
function customPageHeader(){?>
<?php }	
include_once('header.php');
include_once('../func/sqlconn.php');

if($_SESSION['level'] != 0)
{
	$_SESSION['message'] = "Not Authorized!";
	header("Location: index.php");
	exit();
}

$tmp = mysqli_query($con,"SELECT * FROM `" . $DB_USERINFO . "`");
$result = array();
while ($row = mysqli_fetch_assoc($tmp)) {
	array_push($result, $row);	
}
$resultstr = "";
foreach ($result as &$row)
{
	$resultstr = $resultstr . "<tr><td>" . $row['EMAIL'] . "</td><td><a href='users.php?req=edit&id=" . $row['ID'] . "'>Edit</a></td><td><a href='users.php?req=remv&id=" . $row['ID'] . "'>Remove</a></td></tr>";
}

?>


<div class="centered-panel">
	<div class="panel panel-default">
		<div class="panel-heading"><center><h1 class="panel-title">Users</h1></center></div>
		<div class="panel-body">
			<table class="table">
				<thead>
					<tr>
						<th>Username</th>
						<th colspan="2">Options</th>
					</tr>
				</thead>
				<tbody>
					<?php echo $resultstr; ?>
				</tbody>
			</table>
		</div>	
	</div>
</div>


<?
include_once('footer.php');
?>