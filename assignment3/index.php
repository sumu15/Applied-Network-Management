<!DOCTYPE HTML>
<html>
<body>
<body style="background-image:url('http://seanwphoto.com/bentley/v1site_images/backgrounds/website%20background%20pattern.jpg');">

<div style="background-color:#4682B4; color:white; padding:20px;">
<center><h1 style="font-family:verdana">Assignment 3</h1>
</div> 

			

<!-- Connection to database -->
<?php
$path = dirname(__FILE__);

$path1 = explode("/",$path,-1);
$path1[count($path1)+1]='db.conf';
$finalpath = implode("/",$path1);

$file = file("$finalpath");
for($i=0;$i<=4;$i++)
	{
		$details=explode('"',$file[$i]);
		$array[$i]="$details[1]";
	}
$host = $array[0];
$port = $array[1];
$database = $array[2];
$username = $array[3];
$password = $array[4];
 
 
$link = new mysqli($host, $username, $password, $database,$port);
//echo "Connected successfully \n";
?>
<!-- Device input -->		
		<form method = "post">
		<table border=1 align="center"   bgcolor=lightblue style="border-radius:10px;padding:10px" >
		<div><h2 style="background-color:lightblue; color:white; padding:20px;" align=center style="font-family:verdana;color:blue">Enter the details of the device</h2></div>
<div>
		<tr><td>IP address:<br></td>
		<td><input type="text" name="ip" required></td></tr>
		<br>
		<tr><td>Port number:<br></td>
		<td><input type="text" name="port" required></td></tr>
		<br>
		<tr><td>Community:<br></td>
		<td><input type="text" name="community" required></td></tr>
		<input type="hidden" name="set" value="1">
		<br><br>
		<td><input type="submit" value="Submit"> </td></div></table>
		
		</form> 
		<?php 	

			$sql3 = "select * from `sur3_trapdevice`";
			$result3=$link->query($sql3);
			$row1 = mysqli_fetch_array($result3);
			
			#echo "<p style='text-align:center'>Present device: $row1[1]:$row1[2] $row1[3]</p>";
		?>		
<center>
		<form method="post">
		 <input type="hidden" name="reset" value="1">
		 <!--<input type="submit" value="Delete current device"> -->
		</form>
		

<?php

$ip = htmlspecialchars($_POST['ip']);
$port = htmlspecialchars($_POST['port']);
$com = htmlspecialchars($_POST['community']);
$set = htmlspecialchars($_POST['set']);
$reset = htmlspecialchars($_POST['reset']);

#Entering values into the database		
		$sql = "CREATE TABLE IF NOT EXISTS `sur3_trapdevice`(`id` int(11) NOT NULL,`ip` VARCHAR(100) NOT NULL,`port` VARCHAR(40) NOT NULL,`community` VARCHAR(100) NOT NULL,PRIMARY KEY( `id` ))";
		
		$link->query($sql);

if($set==1)		
{		#echo "Table created successfully\n";

		
		$link->query($sql);


		$sql1 = "INSERT INTO `sur3_trapdevice` ".
		       "(`ip`,`port`,`community`) ".
		       "VALUES ".
		       "('$ip','$port','$com')";
		
		$link->query($sql1);
		$set=0;
}		

if($reset==1){
	$sql2 = "TRUNCATE `sur3_trapdevice`";
		
		$link->query($sql2);

		$set=0;		

	     }

?>       


<!-- Printing the status of the agents--->

<h2>DEVICE STATUS</h2>
<?php

$sql4="SELECT * FROM sur3_traps";

$result2=$link->query($sql4);

echo '<table border=1 align="center"   bgcolor=lightblue style="border-radius:10px;padding:10px" >
<tr>
<th>ID</th>
<th>Status</th>
<th>IP Address</th>
<th>Time</th>
<th>Previous status</th>
<th>Previous time</th>
</tr>';

while($row = mysqli_fetch_array($result2))
{
echo "<tr>";
echo "<td>" . $row['id'] . "</td>";
echo "<td>" . $row['STATUS'] . "</td>";
echo "<td>" . $row['IP'] . "</td>";
echo "<td>" . $row['TIME'] . "</td>";
echo "<td>" . $row['PREVIOUS_STATUS'] . "</td>";
echo "<td>" . $row['PREVIOUS_TIME'] . "</td>";
echo "</tr>";
}
echo "</table>";

?>
</body>
</html>
