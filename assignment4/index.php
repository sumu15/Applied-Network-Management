<html> 
<h1><center>ASSIGNMENT4</h1>
<style>
#section {margin: auto ;}
</style>
<body background="01.jpg">

<?php 

 $path= dirname(__FILE__);
                        $path=substr($path, 0, -11);
                        $file="db2.conf";
                        $path=$path.$file;
                        $k= explode("\n",file_get_contents($path));
                        $hostname=substr($k[0],7,-2);
                        $port=substr($k[1],7,-2);
                        $database=substr($k[2],11,-2);
                        $username=substr($k[3],11,-2);
                        $password=substr($k[4],11,-2);
                        
                        //connection to the database
                        $db = mysql_connect($hostname, $username, $password)
                         or die("Unable to connect to MySQL $hostname");
                        
                        
                        //select a database to work with
                        $s = mysql_select_db($database,$db)
                          or die("Could not select $port");
			
if (!$s)
{
  die('! Connection Failed: ' . mysql_error());
echo$path;
}

echo"<br>";

print "<center><table border with cellpadding=5 ></center>"; 
print "<tr>";
print "<th>ID</th>";
print "<th>IP</th> ";
print "<th>PORT</th> ";
print "<th>COMMUNITY</th> ";
print "<th>STATUS</th> ";
print "<th>CLICK HERE</th>";
print "</tr>";

$query2=mysql_query( "SELECT MAX(id) AS MAX_ID FROM `sur4`"); 
$fetch=mysql_fetch_array($query2);

$max_id="$fetch[MAX_ID]";
 
for($i=1;$i<=$max_id;$i++) 
{
$query3=mysql_query( "SELECT * FROM `sur4` WHERE id='$i'"); 
$value=mysql_fetch_array( $query3);

$count=$value[FAIL1];

if ($count==0 )
{
print "<td><font >".$value['id']."</font></td>";
print "<td><font >".$value['IP']."</font></td>";
print "<td><font >".$value['PORT']."</font></td>";
print "<td><font >".$value['COMMUNITY']."</font></td>";
print "<td bgcolor=#FFFFFF></td>";
print "<td><font ><html><a href='A4.php?id=$value[id]'>CLICK HERE</a></html></font></td>";
?>
<?php
print "</tr>";
}
elseif($count==1)
{
print "<td><font >".$value['id']."</font></td>";
print "<td><font >".$value[IP]."</font></td>";
print "<td><font >".$value[PORT]."</font></td>";
print "<td><font >".$value[COMMUNITY]."</font></td>";
print "<td bgcolor=#FFEEEE></td>";
print "<td><font ><html><a href='A4.php?id=$value[id]'>CLICK HERE</a></html></font></td>";
?>
<?php
print "</tr>";
}
elseif($count==2)
{
print "<td><font >".$value[id]."</font></td>";
print "<td><font >".$value[IP]."</font></td>";
print "<td><font >".$value[PORT]."</font></td>";
print "<td><font >".$value[COMMUNITY]."</font></td>";
print "<td bgcolor=#FFEBEB></td>";
print "<td><font ><html><a href='A4.php?id=$value[id]'>CLICK HERE</a></html></font></td>";
?>
<?php
print "</tr>";
}
elseif($count==3)
{
print "<td><font >".$value[id]."</font></td>";
print "<td><font >".$value[IP]."</font></td>";
print "<td><font >".$value[PORT]."</font></td>";
print "<td><font >".$value[COMMUNITY]."</font></td>";
print "<td bgcolor=#FFD6D6></td>";
print "<td><font ><html><a href='A4.php?id=$value[id]'>CLICK HERE</a></html></font></td>";
?>
<?php
print "</tr>";
}
elseif($count==4)
{
print "<td><font >".$value[id]."</font></td>";
print "<td><font >".$value[IP]."</font></td>";
print "<td><font >".$value[PORT]."</font></td>";
print "<td><font >".$value[COMMUNITY]."</font></td>";
print "<td bgcolor=#FFC2C2></td>";
print "<td><font ><html><a href='A4.php?id=$value[id]'>CLICK HERE</a></html></font></td>";
?>
<?php
print "</tr>";
}
elseif($count==5)
{
print "<td><font >".$value[id]."</font></td>";
print "<td><font >".$value[IP]."</font></td>";
print "<td><font >".$value[PORT]."</font></td>";
print "<td><font >".$value[COMMUNITY]."</font></td>";
print "<td bgcolor=#FFADAD></td>";
print "<td><font ><html><a href='A4.php?id=$value[id]'>CLICK HERE</a></html></font></td>";
?>
<?php
print "</tr>";
}
elseif($count<=9)
{
print "<td><font >".$value[id]."</font></td>";
print "<td><font >".$value[IP]."</font></td>";
print "<td><font >".$value[PORT]."</font></td>";
print "<td><font >".$value[COMMUNITY]."</font></td>";
print "<td bgcolor=#FF9999></td>";
print "<td><font ><html><a href='A4.php?id=$value[id]'>CLICK HERE</a></html></font></td>";
?>
<?php
print "</tr>";
}
elseif($count==10)
{
print "<td><font >".$value[id]."</font></td>";
print "<td><font >".$value[IP]."</font></td>";
print "<td><font >".$value[PORT]."</font></td>";
print "<td><font >".$value[COMMUNITY]."</font></td>";
print "<td bgcolor=#FF9999></td>";
print "<td><font ><html><a href='A4.php?id=$value[id]'>CLICK HERE</a></html></font></td>";
?>
<?php
print "</tr>";
}
elseif($count<=15)
{
print "<td><font >".$value[id]."</font></td>";
print "<td><font >".$value[IP]."</font></td>";
print "<td><font >".$value[PORT]."</font></td>";
print "<td><font >".$value[COMMUNITY]."</font></td>";
print "<td bgcolor=#FF8585></td>";
print "<td><font ><html><a href='A4.php?id=$value[id]'>CLICK HERE</a></html></font></td>";
?>
<?php
print "</tr>";
}
elseif($count<=18)
{
print "<td><font >".$value[id]."</font></td>";
print "<td><font >".$value[IP]."</font></td>";
print "<td><font >".$value[PORT]."</font></td>";
print "<td><font >".$value[COMMUNITY]."</font></td>";
print "<td bgcolor=#FF7070></td>";
print "<td><font ><html><a href='A4.php?id=$value[id]'>CLICK HERE</a></html></font></td>";
?>
<?php
print "</tr>";
}
elseif($count<=20)
{
print "<td><font >".$value[id]."</font></td>";
print "<td><font >".$value[IP]."</font></td>";
print "<td><font >".$value[PORT]."</font></td>";
print "<td><font >".$value[COMMUNITY]."</font></td>";
print "<td bgcolor=#FF7070></td>";
print "<td><font ><html><a href='A4.php?id=$value[id]'>CLICK HERE</a></html></font></td>";
?>
<?php
print "</tr>";
}
elseif($count<=25)
{
print "<td><font >".$value[id]."</font></td>";
print "<td><font >".$value[IP]."</font></td>";
print "<td><font >".$value[PORT]."</font></td>";
print "<td><font >".$value[COMMUNITY]."</font></td>";
print "<td bgcolor=#FF5C5C></td>";
print "<td><font ><html><a href='A4.php?id=$value[id]'>CLICK HERE</a></html></font></td>";
?>
<?php
print "</tr>";
}
elseif($count<=28)
{
print "<td><font >".$value[id]."</font></td>";
print "<td><font >".$value[IP]."</font></td>";
print "<td><font >".$value[PORT]."</font></td>";
print "<td><font >".$value[COMMUNITY]."</font></td>";
print "<td bgcolor=#FF4747></td>";
print "<td><font ><html><a href='A4.php?id=$value[id]'>CLICK HERE</a></html></font></td>";
?>
<?php
print "</tr>";
}
elseif($count==29)
{
print "<td><font >".$value[id]."</font></td>";
print "<td><font >".$value[IP]."</font></td>";
print "<td><font >".$value[PORT]."</font></td>";
print "<td><font >".$value[COMMUNITY]."</font></td>";
print "<td bgcolor=#FF4747></td>";
print "<td><font ><html><a href='A4.php?id=$value[id]'>CLICK HERE</a></html></font></td>";
?>
<?php
print "</tr>";
}
elseif($count==30)
{
print "<td><font >".$value[id]."</font></td>";
print "<td><font >".$value[IP]."</font></td>";
print "<td><font >".$value[PORT]."</font></td>";
print "<td><font >".$value[COMMUNITY]."</font></td>";
print "<td bgcolor=#FF3333></td>";
print "<td><font ><html><a href='A4.php?id=$value[id]'>CLICK HERE</a></html></font></td>";
?>
<?php
print "</tr>";
}
elseif($count>30)
{
print "<td><font >".$value[id]."</font></td>";
print "<td><font >".$value[IP]."</font></td>";
print "<td><font >".$value[PORT]."</font></td>";
print "<td><font >".$value[COMMUNITY]."</font></td>";
print "<td bgcolor=#FF0000></td>";
print "<td><font ><html><a href='A4.php?id=$value[id]'>CLICK HERE</a></html></font></td>";
?>
<?php
print "</tr>";
}
}
 ?>
</html>





