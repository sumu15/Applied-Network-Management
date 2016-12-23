<html><body style="background-image:url('http://seanwphoto.com/bentley/v1site_images/backgrounds/website%20background%20pattern.jpg');">
<div style="background-color:#4682B4; color:white; padding:20px;">
<center><h1 style="font-family:verdana">Assignment 1</h1>
</div> 
</html>
<?php
$dr=dirname(_FILE_);
$path=realpath($dr.'/..');
$target=$path.'/db.conf';
$finalpath=file($target);

$j=0;
while($j<=4)
{
$line=explode('"',$finalpath[$j]);
$output[$j]="$line[1]";
$j++;
}
$host=$output[0];
$port=$output[1];
$database=$output[2];
$username=$output[3];
$password=$output[4];
#echo $host;
#echo $port;
#connection for db

$con=mysql_connect("$host:$port","$username","$password");
if(!$con)
{
die("cannot connect".mysql_error());
}
$db=mysql_select_db($database,$con);

$sql = "SELECT * FROM sur1_interfacelist";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result))
{
	#echo "$row[0]";
	$value = $row[2];
    	$list = explode(', ', $value);
	$c = 1;
        #print_r($list);
	#echo"($list)";
#$device=$
foreach ($list as $item)
    	{
$m=explode('-',$item);
	  echo "<br>Traffic Analysis for $item -- $row[0]</br>";
  	 $opts_d = array( "--start", "-1d", "--vertical-label=bytes per second",
         "DEF:inoctets=$row[0].rrd:in$m[0]:AVERAGE",
	 "DEF:outoctets=$row[0].rrd:out$m[0]:AVERAGE",
         "AREA:inoctets#00FF00:In traffic",
	 "LINE1:outoctets#0000FF:Out traffic",

	 "--dynamic-labels",
		"--title=DailyGraph",
	  	"--color=BACK#CCCCCC",      
		"--color=CANVAS#CCFFFF",    
		"--color=SHADEB#9999CC",
	  "COMMENT:\\n",
		"GPRINT:inoctets:LAST:Current In \: %6.2lf %SBps",
		"COMMENT:  ", 
		"GPRINT:outoctets:LAST:Current Out \: %6.2lf %SBps",
		"COMMENT:\\n",       
		"GPRINT:inoctets:MAX:Maximum In \: %6.2lf %SBps",
		"COMMENT:  ",
		"GPRINT:outoctets:MAX:Maximum Out \: %6.2lf %SBps",
		"COMMENT:\\n", 
		"GPRINT:inoctets:AVERAGE:Average In \: %6.2lf %SBps",
		"COMMENT:  ",
		"GPRINT:outoctets:AVERAGE:Average Out \: %6.2lf %SBps",
		"COMMENT:\\n",
		);
		$ret_d = rrd_graph("$m[0].png", $opts_d);
		if( !$ret_d )
  		{
    		$err = rrd_error();
    		echo "rrd_graph() ERROR: $err\n";
  		}

		echo "<a href=grapha.php?dev=$row[0]&interface=$m[0]>";
		echo "<img src=graph1.php?image=$m[0].png>";
		echo "</a>";
$c++;
	}

}

?>
</body>
</html>
