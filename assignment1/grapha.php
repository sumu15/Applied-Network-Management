<html>
<body>
<body style="background-image:url('http://seanwphoto.com/bentley/v1site_images/backgrounds/website%20background%20pattern.jpg');">

<div style="background-color:#4682B4; color:white; padding:20px;">
<center><h1 style="font-family:verdana">Assignment 1</h1>
</div> 
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
$dev=$_GET["dev"];
$INTERFACE=$_GET["interface"];
#$id=$_GET["id"];
#echo "$dev";
#echo "$INTERFACE";
#echo "$id";
$list=explode('_',$dev);
#print_r ($list);

	$opts_d = array( "--start", "-1d", "--vertical-label=bytes per second",
                 "DEF:inoctets=$dev.rrd:in$INTERFACE:AVERAGE",
		 "DEF:outoctets=$dev.rrd:out$INTERFACE:AVERAGE",
		 
                 "AREA:inoctets#00FF00:In traffic",
		 "LINE1:outoctets#0000FF:Out traffic",
		 "--dynamic-labels",
			 "--title=Daily graph",
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
		$ret_d = rrd_graph("day$INTERFACE.png", $opts_d);
		if( !$ret_d )
  		{
    		$err = rrd_error();
    		echo "rrd_graph() ERROR: $err\n";
  		}



	$opts_w = array( "--start", "-1w", "--vertical-label=bytes per second",
                 "DEF:inoctets=$dev.rrd:in$INTERFACE:AVERAGE",
		 "DEF:outoctets=$dev.rrd:out$INTERFACE:AVERAGE",
		 
                 "AREA:inoctets#00FF00:In traffic",
		 "LINE1:outoctets#0000FF:Out traffic",
		 "--dynamic-labels",
			 "--title=Weekly graph",
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
		$ret_w = rrd_graph("week$INTERFACE.png", $opts_w);
		if( !$ret_w )
  		{
    		$err = rrd_error();
    		echo "rrd_graph() ERROR: $err\n";
  		}


	$opts_m = array( "--start", "-1m", "--vertical-label=bytes per second",
                 "DEF:inoctets=$dev.rrd:in$INTERFACE:AVERAGE",
		 "DEF:outoctets=$dev.rrd:out$INTERFACE:AVERAGE",
		 
                 "AREA:inoctets#00FF00:In traffic",
		 "LINE1:outoctets#0000FF:Out traffic",
		 "--dynamic-labels",
			 "--title=Monthly graph",
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
		$ret_m = rrd_graph("month$INTERFACE.png", $opts_m);
		if( !$ret_m )
  		{
    		$err = rrd_error();
    		echo "rrd_graph() ERROR: $err\n";
  		}


	$opts_y = array( "--start", "-1y", "--vertical-label=bytes per second",
                 "DEF:inoctets=$dev.rrd:in$INTERFACE:AVERAGE",
		 "DEF:outoctets=$dev.rrd:out$INTERFACE:AVERAGE",
		 
                 "AREA:inoctets#00FF00:In traffic",
		 "LINE1:outoctets#0000FF:Out traffic",
		 "--dynamic-labels",
			 "--title=Yearly graph",
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
		$ret_y = rrd_graph("year$INTERFACE.png", $opts_y);
		if( !$ret_y )
  		{
    		$err = rrd_error();
    		echo "rrd_graph() ERROR: $err\n";
  		}

echo "<img src=graph1.php?image=day$INTERFACE.png>";
echo "<img src=graph1.php?image=week$INTERFACE.png>";
echo "<img src=graph1.php?image=month$INTERFACE.png>";
echo "<img src=graph1.php?image=year$INTERFACE.png>";
?>
