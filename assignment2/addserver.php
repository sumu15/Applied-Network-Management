<!DOCTYPE html>
<html>
<head>

<style>
ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    border: 1px solid #e7e7e7;
    background-color: #f3f3f3;
}

li {
    float: left;
}

li a {
    display: block;
    color: #666;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

li a:hover:not(.active) {
    background-color: #ddd;
}

li a.active {
    color: white;
    background-color: #3399FF;
}
h1 {text-align:center;}
#section {
    width:350px;
    float:left;
    padding:10px;	 	 
}

</style>
<center>
<body background="01.jpg">
<h1>Assignment2</h1>
</head>
<ul>
<li><a  href="index.php">Add device</a></li>
  <li><a class="active" href="addserver.php">Add Server</a></li>
  <li><a  href="deletedevice.php">Remove Device</a></li>
  <li><a  href="deleteserver.php">Remove Server</a></li>
  <li><a href="monitor.php">Monitor</a></li>
 </ul> 
 <h3> Enter the ip of the server to monitor</h3> 
<form action="addserver.php" method="post">
ip:        <input type="text" name="serverip" required><br>
<input type="submit" value="add server">
</form>
<?php
if(!empty($_POST["serverip"])) {
 $x= $_POST["serverip"];  


#require "find.php";
$myfile = fopen("../db.conf", "r") or die("Unable to open file!");
eval(fread($myfile,filesize("../db.conf")));
fclose($myfile);



$conn = mysqli_connect($host,$username, $password,$database,$port);

// Check connection
if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully<br>";
mysqli_select_db($conn,"$database");

$tbl = "CREATE TABLE IF NOT EXISTS sur2_servers ( 
                id INT(11) NOT NULL AUTO_INCREMENT,
                server VARCHAR(255) NOT NULL,
                
                PRIMARY KEY (id),
                UNIQUE (id,server) 
                )"; 
$query = mysqli_query($conn, $tbl); 
if ($query === TRUE) {
	#echo "<h3>blockedusers table created OK :) </h3>"; 
} else {
	echo "<h3>blockedusers table NOT created :( </h3>"; 
}
$sqls = "INSERT INTO sur2_servers (server)
VALUES (\"$x\")";

if (mysqli_query($conn, $sqls)) {
    echo "New server '$x' added succesfully";
} else {
 echo "error server already exists";
    echo "Error: " . $sqls . "<br>" . mysqli_error($conn);
}
}

?>

</html>
