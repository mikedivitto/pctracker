<?php
$PageTitle="Admin Console";
function customPageHeader(){?>
<?php }
include_once('header.php');

if(class_exists('Memcache'))
{
	$mc = new Memcache;
	$mc->connect('localhost', 11211);
	if(!$html = $mc->get('openlabs_admin_index')){
		include_once('indexb.php');
		$mc->set('openlabs_admin_index', $html2, 0, time()+60);
	}
	$mc->close();
}
else {include_once('indexb.php');}
if(strlen($html) === 0)
	$html = $html2;
echo $html;

include_once('footer.php'); ?>
