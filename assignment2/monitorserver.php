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
<?php
echo "<div style=\"float:left;\">";
echo "<h2>servers</h2>";
$sql = "SELECT id,server FROM sur2_servers";
$result = $conn->query($sql);
   $detailsarray = array("cpuusage", "requestspersec", "transfbytespersec" , "bytesperrequest");
echo "<form action='gettingserver.php' method='post'>";
while($row = $result->fetch_assoc()) 
    {
    $grapharray = array("daily", "monthly", "yearly");
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
?>
