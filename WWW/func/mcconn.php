<?php
$mc = new Memcache;
foreach($MC_SERVERS as &$tmp){
    $mc->addServer($tmp, 11211); 
}
?>
