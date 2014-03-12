<?php
$PageTitle="Flush Cache";
function customPageHeader(){?>
<script type="text/JavaScript">
	<!--
	setTimeout("location.href = '../admin/index.php';",1500);
	-->
	</script>
<?php }
include_once('../admin/header.php');
if(class_exists('Memcache'))
{
    $mc = new Memcache;
    $mc->connect('localhost', 11211);
    $mc->flush();
    echo "Cache Flushed";
    $mc->close();
}
else
{
    echo "Memcache not installed.";
}
include_once('footer.php'); ?>