#!/usr/bin/perl

use DBI;
use Net::SNMP;
use FindBin '$Bin';

#Connecting to database
my @values = split ('/',$Bin);
pop @values;
$values[$#values+1]="db.conf";
$path=join('/',@values);

open FILE, "$path" or die $!;

my @lines = <FILE>;

my @host = split('"', $lines[0]);
my @port = split('"', $lines[1]);
my @database = split('"', $lines[2]);
my @username = split('"', $lines[3]);
my @password = split('"', $lines[4]);

 $dbh = DBI->connect("DBI:mysql:".$database[1].";".$host[1].";".$port[1], $username[1],$password[1])
 or die "Connection Error: $DBI::errstr\n";
 
	$sth = $dbh->prepare("CREATE TABLE IF NOT EXISTS `sur3_traps`
								( `id` int(11) NOT NULL AUTO_INCREMENT, 
								`STATUS` tinytext NOT NULL, 
								`IP` tinytext NOT NULL,
								`TIME` tinytext NOT NULL,
								`PREVIOUS_STATUS` tinytext NOT NULL,
								`PREVIOUS_TIME` tinytext NOT NULL, 
								`STATUS1` tinytext NOT NULL,
								`PREVIOUS_STATUS1` tinytext NOT NULL,
								PRIMARY KEY (`id`) )
								ENGINE=InnoDB DEFAULT CHARSET=LATIN1 AUTO_INCREMENT=1");
	$sth->execute;

@oids = ();
@OID = ();

#Receiving Trap file
	my $trapFile = "$Bin/traplog.log";	
	open(trapFile, ">>$trapFile");
	
	$localtime = localtime();
	
	my $host = <STDIN>;	
	 chomp($host);
	my $ip1 = <STDIN>;
	 chomp($ip1);

	while(<STDIN>) 
			{
				chomp($_);
				push(@details,$_);
			}

	
	print(trapFile "\nNew trap received: $localtime for \nHost: $host\nIP: $ip1\n");


foreach(@details) 
 {
       
  print(trapFile $_);
	
	@detail = split(/\ /,$_);
				
	if("$detail[0]" eq "iso.3.6.1.4.1.41717.10.1" || "$detail[0]" eq ".1.3.6.1.4.1.41717.10.1")
	{
	$ip1=$detail[1];
	@spl=split('"',$ip1);
	$ip="$spl[1]";
	}
	elsif("$detail[0]" eq "iso.3.6.1.4.1.41717.10.2" || "$detail[0]" eq ".1.3.6.1.4.1.41717.10.2")
	{
							
	if($detail[1] == 0)
	{
	$status = OK; 
	$status1= 0;
	}elsif($detail[1] == 1)
	{
	$status = PROBLEM;
	$status1= 1; 
	}elsif($detail[1] == 2)
	{
	$status = DANGER; $test=DANGER;
	$status1= 2;
	}elsif($detail[1] == 3)
	{
	$status = FAIL; $test=FAIL;$ipFAIL=$ip;
	$status1= 3;
	}
	}
	

$time=time();

	
	if($ip && $status)
	{
 	print(trapFile "The ip and status are $ip and $status-$status1 \n");
	$trapVerify = $dbh->prepare("select * from `sur3_traps` where `IP`='$ip'");
	$trapVerify->execute;
	@i = $trapVerify->fetchrow_array();
			 
	if($i[2])
	{
									
	$trapPrev = $dbh->prepare("select `STATUS`,`TIME`, `STATUS1` from `sur3_traps` where `IP`='$ip'");
	$trapPrev->execute;
	@previousDetails = $trapPrev->fetchrow_array();
									
	$previousStatus = $previousDetails[0];
	$previousTime   = $previousDetails[1];
	$previousStatus1 = $previousDetails[2];
		
							
	$trapUpdate = $dbh->prepare("UPDATE `sur3_traps` SET  		`STATUS`='$status',`TIME`='$time',`PREVIOUS_STATUS`='$previousStatus',`PREVIOUS_TIME`='$previousTime',`STATUS1`='$status1',
`PREVIOUS_STATUS1`='$previousStatus1'  WHERE `IP` = '$ip'");
	$trapUpdate->execute;
										 
	print(trapFile "Existing Trap \n Previous status:$previousStatus\n Previous time:$previousTime\n");
	print(trapFile " Current status:$status\n Current time:$time\n");
								
	}else	
	{	

	$trapNew = $dbh->prepare("insert into `sur3_traps` (IP,STATUS,TIME,STATUS1,PREVIOUS_STATUS1) VALUES ('$ip','$status','$time', '$status1','-')");	
	$trapNew->execute;
	print(trapFile "New Trap Inserted: $ip,$status,$time\n");
	}
$ip="";
$status="";
$status1="";
	
	}
}

$trapDevice = $dbh->prepare("select * from `sur3_trapdevice`");
	$trapDevice->execute;
	while(@j=$trapDevice->fetchrow_array())
	 {
		$credentials[1]= $j[1]; #ip
		$credentials[2]= $j[2]; #port
		$credentials[3]= $j[3]; #community
	}
 					

	($session,$error) = Net::SNMP->session(Hostname => $credentials[1],Community => $credentials[3],Port => $credentials[2]); 
#Preparing FAIL status
	 $trapFail = $dbh->prepare("select * from `sur3_traps` WHERE `STATUS` = 'FAIL' AND `IP` = '$ipFAIL'");
	 $trapFail->execute;

	 	
	 @s=$trapFail->fetchrow_array();
	
		{			
					
					push (@oids,"1.3.6.1.4.1.41717.20.1",OCTET_STRING,$s[2]); 
					push (@oids,"1.3.6.1.4.1.41717.20.2",INTEGER32,$time);

					if ($s[7] eq "-") {
					push (@oids,"1.3.6.1.4.1.41717.20.3",INTEGER,0);
					push (@oids,"1.3.6.1.4.1.41717.20.4",INTEGER32,0);
					}
					
					if ($s[7] ne "-") {
					push (@oids,"1.3.6.1.4.1.41717.20.3",INTEGER,$s[7]);
					push (@oids,"1.3.6.1.4.1.41717.20.4",INTEGER32,$s[5]);
					}		

		}

#preparing DANGER status

	 $trapDanger = $dbh->prepare("select * from `sur3_traps` WHERE `STATUS` = 'DANGER'");
	 $trapDanger->execute;
   $number = $trapDanger->rows();
	  
    if($number >= 2)
  	
  	  {
	$n = 1;
	while(@xx=$trapDanger->fetchrow_array())
	
	{
	push (@OID,"1.3.6.1.4.1.41717.30.$n",OCTET_STRING,$xx[2]);  $n = $n+1;
	push (@OID,"1.3.6.1.4.1.41717.30.$n",INTEGER32,$xx[3]);  $n = $n+1;
	
					if ($xx[7] eq "-") {
					push (@OID,"1.3.6.1.4.1.41717.30.$n",INTEGER,0); $n = $n+1;
					push (@OID,"1.3.6.1.4.1.41717.30.$n",INTEGER32,0); $n = $n+1;	
					}

					if ($xx[7] ne "-") {
					push (@OID,"1.3.6.1.4.1.41717.30.$n",INTEGER,$xx[7]); $n = $n+1;
					push (@OID,"1.3.6.1.4.1.41717.30.$n",INTEGER32,$xx[5]); $n = $n+1;	
					}
	
	}
	if($test eq "DANGER"){ print(trapFile "sending DANGER trap\n");
		my $result1 = $session->trap(-varbindlist  => \@OID);}			
	}

#Sending the trap to the device.

	
				
		if($test eq "FAIL"){	print(trapFile "sending FAIL trap\n");
		my $result = $session->trap(-varbindlist  => \@oids);}
		
		$session->close;		


print(trapFile "\n-------------------NEW ENTRY-----------------------\n");

close(trapFile);
