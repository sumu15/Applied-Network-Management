<!DOCTYPE html>
<html>
<body>
<body style="background-image:url('http://seanwphoto.com/bentley/v1site_images/backgrounds/website%20background%20pattern.jpg');">

<div style="background-color:#4682B4; color:white; padding:20px;">
<center><h1 style="font-family:verdana">Assignment 1</h1>
</div> 


<!-- Connection to database -->
<?php

$directory = dirname(__FILE__);
$route = realpath($directory. '/..');
$target=$route .'/db.conf';
$final = file($target);
$a=0;
while($a<=4)
{
$join=explode('"',$final[$a]);
$unit[$a]="$join[1]";
$a++;

}
$host = $unit[0];
$port = $unit[1];
$database = $unit[2];
$username = $unit[3];
$password = $unit[4];
$connect = mysql_connect("$host:$port",$username,$password);

if (!$connect)
{
die('cannot connect:'.mysql_error());
}
mysql_select_db($database,$connect);
$y=$_SERVER[QUERY_STRING];
$res=mysql_query("delete from DEVICES where id=$y");
if(!$res)
die(mysql_error());
else
header("location:del.php");
?>
