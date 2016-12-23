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
?>
<html>
<head>
<script>
function fun_del(val)
{
var x=confirm("Do you want to delete: ");
if(x)
{
location.href="delete.php?"+val;
}
else
{
location.href="del.php";
}
}
</script>
</head>
<body>
<form method="get" action="">
<table border=1 align="center"   bgcolor=lightblue style="border-radius:10px;padding:10px" >
<div><h2 style="background-color:lightblue; color:white; padding:20px;" align=center style="font-family:verdana;color:blue">Tick here to delete the device</h2></div>
<tr>
<th> IP address </th>
<th> Port number </th>
<th> Community </th>
<th></th>
</tr>

<?php
$qry="select * from DEVICES";
$x=mysql_query($qry);
if(!$x)
die(mysql_error());
while($y=mysql_fetch_array($x))
{
?>
<tr>
<!--<td><?php echo $y[0]?></td>-->
<td><?php echo $y[1]?></td>
<td><?php echo $y[2]?></td>
<td><?php echo $y[3]?></td>
<td> <input type="checkbox" value="<?php echo $y[0]?>" onclick="fun_del(this.value)"></td></tr>
<?php
}?>
</table>
</form>
<body>
</html>
