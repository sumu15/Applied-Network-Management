<?php


$graph=$_GET["image"];
$fp = fopen($graph, 'rb');

// send the right headers
header("Content-Type: image/png");
header("Content-Length: " . filesize($graph));


$im=fpassthru($fp);

unlink($graph);

?>


