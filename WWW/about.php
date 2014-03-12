<?php
$PageTitle="About";
function customPageHeader(){?>
<?php }
include_once('header.php');
if(class_exists('Memcache'))
{
	$mc = new Memcache;
	$mc->connect('localhost', 11211);
	if(!$html = $mc->get('openlabs_home_about')){
		include_once('aboutb.php');
		$mc->set('openlabs_home_about', $html2, 0, time()+60);
	}
	$mc->close();
}
else {include_once('aboutb.php');}
if(strlen($html) === 0)
	$html = $html2;
echo $html;
 include_once('footer.php'); ?>
 
 

