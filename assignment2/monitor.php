<html>
<head><style>
h1 {text-align:center;}
#section {
    width:350px;
    float:left;
    padding:10px;	 	 
}
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
<body>
<script type="text/javascript">
checked=false;
function checkedAll (form1) {var aa= document.getElementById('form1'); if (checked == false)
{
checked = true
}
else
{
checked = false
}for (var i =0; i < aa.elements.length; i++){ aa.elements[i].checked = checked;}
}
</script>

<ul>
<li><a  href="index.php">Add Device</a></li>
  <li><a href="addserver.php">Add Server</a></li>
  <li><a  href="deletedevice.php">Remove Device</a></li>
  <li><a  href="deleteserver.php">Remove Server</a></li>
  <li><a class="active" href="monitor.php">Monitor</a></li>
  <li><a  href="getting.php">Device graph</a></li>
  <li><a  href="gettingserver.php">Server graph</a></li>
 </ul> 

<?php
//$host = "localhost";
//$username = "root";
//$password = "5";
//$database = "devices";
//$port="161";
#require "find.php";
$myfile = fopen("../db.conf", "r") or die("Unable to open file!");
eval(fread($myfile,filesize("../db.conf")));
fclose($myfile);


// Create connection
$conn = mysqli_connect($host,$username, $password,$database,$port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";

$sql = "SELECT id,IP, PORT, COMMUNITY,interfaces FROM sur2_devices";
$result = $conn->query($sql);
#echo "<div id=\"section\">";
echo "<div style=\"width: 100%;\">";
echo "<div style=\"float:left; width: 50%\">";
echo "<h2>devices</h2>";
echo "<form id ='form1' action='getting.php' method='post'>";
    // output data of each row
    while($row = $result->fetch_assoc()) 
    {
        //echo "ip: " . $row["IP"]. " port: " . $row["PORT"]. " community" . $row["COMMUNITY"]."interfaces".$row["interfaces"]."\n";
       	$id=$row["id"];
        $ip=$row["IP"];
        $port=$row["PORT"];
        $community=$row["COMMUNITY"];
				$interface=$row["interfaces"];
				$pieces = explode("&", $interface);
				$grapharray = array("hourly","daily", "monthly", "yearly");
				$graphvalue= array("-1h","-1d","-1m","-1y");
echo "$id";
echo "<input type='checkbox' name='check_list1[]' value=device$id> $ip<br>";


echo "<p style=\"text-indent: 5em\">INTERFACES</p>";
				foreach($pieces as $i => $value)
									{
									$z=$pieces[$i];
											echo "<p style=\"text-indent: 5em\"><input type='checkbox' name='device$id-check_list2[]'  value=device+$id+$ip+$port+$community+$z> $z<br></p>";
									
									}
								#	echo "<p style=\"text-indent: 5em\"><input type='checkbox' name='device$id-check_list2[]' onclick='checkedAll(form1);'>selectAll<br>";
									echo "<p style=\"text-indent: 5em\"><input type='checkbox' name='device$id-check_list2[]'  value=device+$id+$ip+$port+$community>all<br></p>";
									$l++;

}
echo "<p >Period for graph</p>";
foreach($grapharray as $f => $values)
									{
											$k=$grapharray[$f];
												$p=$graphvalue[$f];
											echo "<p style=\"text-indent: 5em\"><input type='checkbox' name='check_listtime[]'  value=$p> $k<br></p>";
									
									}
echo "<input type=\"submit\" value=\"device\">";
echo "</form>";
echo "</div>";
#echo "<div id=\"section\">";
echo "<div style=\"float:left;\">";
echo "<h2>servers</h2>";
$sql = "SELECT id,server FROM sur2_servers";
$result = $conn->query($sql);
   $detailsarray = array("cpuusage", "requestspersec", "transfbytespersec" , "bytesperrequest");
echo "<form action='gettingserver.php' method='post'>";
while($row = $result->fetch_assoc()) 
    {
    $grapharray = array("hourly","daily", "monthly", "yearly");
    $servername=$row["server"];
    $ids=$row["id"];
    echo "$ids";
    echo "<input type='checkbox' name='serverlist[]' value=$servername+$ids> $servername<br>";
    }
    
    echo "<p>Parameters</p>";
    /*foreach($detailsarray as $j => $values)
									{
											$h=$detailsarray[$j];
											echo "<p style=\"text-indent: 5em\"><input type='checkbox' name='server_parameter[]'  value=$h> $h<br></p>";
									
									}*/
									
echo "<p style=\"text-indent: 5em\"><input type='checkbox' name='server_parameter[]'  value=cpuusage> CPU Utilization<br></p>";
echo "<p style=\"text-indent: 5em\"><input type='checkbox' name='server_parameter[]'  value=requestspersec> Request Per second<br></p>";
echo "<p style=\"text-indent: 5em\"><input type='checkbox' name='server_parameter[]'  value=transfbytespersec> Transfered bytes per second<br></p>";
echo "<p style=\"text-indent: 5em\"><input type='checkbox' name='server_parameter[]'  value=bytesperrequest> Bytes per request<br></p>";
    
    echo "<p >Period for graph</p>";
 foreach($grapharray as $f => $values)
									{
											$k=$grapharray[$f];
											$p=$graphvalue[$f];
											echo "<p style=\"text-indent: 5em\"><input type='checkbox' name='server_time[]'  value=$p> $k<br></p>";
									
									}
echo "<input type=\"submit\" value=\"server\">";
echo "</form>";
echo "</div>";

echo "</div>";
#echo "<input type=\"submit\" value=\"compare\">";
?>
</body>
</html>
