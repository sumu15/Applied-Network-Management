#! /usr/local/bin/perl
use DBI;
use Net::SNMP;
use Data::Dumper;
use FindBin '$Bin';

my @path=split('/', $Bin);
pop @path;
push(@path, "db2.conf");
$path=join('/', @path);
open FILE, "$path" or die $!;

my @line=<FILE>; 
my @host=split('"', $line[0]);
my @port=split('"', $line[1]);
my @database=split('"', $line[2]);
my @username=split('"', $line[3]);
my @password=split('"', $line[4]);

$database=$database[1];
$host=$host[1];
$port=$port[1];
$username=$username[1];
$password=$password[1];
my $driver="mysql";


my $dsn="DBI:mysql:$database;host=$host;port=$port";

my $dbh=DBI->connect($dsn, $username, $password) 
	or die $DBI::errstr;
print"connected db";
my $ddl="CREATE TABLE IF NOT EXISTS `sur4` (`id` int(11) NOT NULL AUTO_INCREMENT, 
					  `IP` tinytext NOT NULL,
					  `PORT` int(11) NOT NULL,
					  `COMMUNITY` tinytext NOT NULL,
					  `UPTIME` tinytext NOT NULL,
					  `SUCCESS` int(11) NOT NULL,
					  `FAIL` int(11) NOT NULL,
					  `FAIL1` int(11) NOT NULL, 
					  `TOTAL_REQ` int(11) NOT NULL, 
					  `TIME` mediumtext NOT NULL,
					   PRIMARY KEY (id) )
					  ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
$dbh->do($ddl);

my $sth=$dbh->prepare("SELECT IP, PORT, COMMUNITY FROM `DEVICES` ");

$sth->execute() or die $DBI::errstr;


while (my @row=$sth->fetchrow_array())
{
my ($IP, $PORT, $COMMUNITY)=@row;
print "IP = $IP, PORT = $PORT, COMMUNITY = $COMMUNITY \n";

my $session=Net::SNMP->session( -hostname=>$IP,
				-port=>$PORT,
      			        -community=>$COMMUNITY,
			        -nonblocking=>1,
				-timeout=>1,
			        -version=>'snmpv2c',
			        ); 

if(!defined $session)
{
 print "session Irresponsive\n";
}

my $oid_uptime='1.3.6.1.2.1.1.3.0';

my $systemuptime=$session->get_request ( -varbindlist=>[$oid_uptime], -callback=>[\&uptime_callback, $IP,$PORT,$COMMUNITY,$oid_uptime] );

if(!defined $systemuptime)
{
 print "Irresponsive\n";
}

}

snmp_dispatcher();


sub uptime_callback
{
my $time=localtime();
my ($session,$IP,$PORT,$COMMUNITY,$oid_uptime)=@_;
my $result=$session->var_bind_list($oid_uptime);
my $sysuptime=$result->{$oid_uptime};

if (defined $sysuptime)
{printf "\n systemuptime for $IP,$PORT,$COMMUNITY=$sysuptime\n";

my $sth1=$dbh->prepare("SELECT * FROM sur4 where IP='$IP' AND PORT='$PORT' AND COMMUNITY='$COMMUNITY' ");
$sth1->execute();

while(my $row1=$sth1->fetchrow_hashref())
{
$exist=1;
}

if ($exist!=1)
{
#print"not existed\n";
$sth2=$dbh->prepare("INSERT INTO `sur4` (`IP`,`PORT`,`COMMUNITY`,`UPTIME`, `SUCCESS`,`FAIL1`, `TOTAL_REQ`, `TIME`) VALUES ('$IP', '$PORT', '$COMMUNITY', '$sysuptime', '1', 0,'1', '$time')");
$sth2->execute();
}
else
{#print "existed\n"; 
$sth3=$dbh->prepare("SELECT `SUCCESS`, `TOTAL_REQ` FROM `sur4` WHERE IP='$IP' AND PORT='$PORT' AND COMMUNITY='$COMMUNITY' ");
$sth3->execute();

my @row2=$sth3->fetchrow_array();
my($SUCCESS,$TOTAL_REQ)=@row2;
$SUCCESS++;
$TOTAL_REQ++;

$sth4=$dbh->prepare("UPDATE `sur4` SET SUCCESS=$SUCCESS, TOTAL_REQ=$TOTAL_REQ, FAIL1='0' WHERE IP='$IP' AND PORT='$PORT' AND COMMUNITY='$COMMUNITY' ");
$sth4->execute();
}
}

else
{
 $sth5=$dbh->prepare("SELECT * FROM sur4 where IP='$IP' AND PORT='$PORT' AND COMMUNITY='$COMMUNITY' ");
$sth5->execute();

while( $row3 = $sth5->fetchrow_hashref())
{
$exist=1;
}

if ($exist!=1)
{
#print" '$IP', '$PORT', '$COMMUNITY' not existed\n";
$sth6=$dbh->prepare("INSERT INTO `sur4` (`IP`,`PORT`,`COMMUNITY`,`UPTIME`, `FAIL`,`FAIL1`,`TOTAL_REQ`, `TIME`) VALUES ('$IP', '$PORT', '$COMMUNITY', 'NOT_DEFINED', '1','1', '1', '$time')");
$sth6->execute();
}
else
{#print " '$IP', '$PORT', '$COMMUNITY'  existed\n"; 
$sth7=$dbh->prepare("SELECT `FAIL`, `TOTAL_REQ` FROM `sur4` WHERE IP='$IP' AND PORT='$PORT' AND COMMUNITY='$COMMUNITY' ");
$sth7->execute();

 @row4=$sth7->fetchrow_array();
($FAIL,$TOTAL_REQ1)=@row4;
$FAIL++;
$TOTAL_REQ1++;

$sth8=$dbh->prepare("UPDATE `sur4` SET FAIL=$FAIL, FAIL1=$FAIL,TOTAL_REQ=$TOTAL_REQ1 WHERE IP='$IP' AND PORT='$PORT' AND COMMUNITY='$COMMUNITY' ");
$sth8->execute();
}
}
}















