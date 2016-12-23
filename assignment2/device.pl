#!/usr/bin/perl
use DBI;
#use strict;
use Net::SNMP qw(snmp_dispatcher oid_lex_sort);
use RRD::Simple ();
use Data::Dumper qw(Dumper);
use Cwd 'abs_path'; 

#database connect
$cwd = abs_path(__FILE__);
@finding = split('/', $cwd);
splice @finding, -2;
push(@finding, 'db.conf');
$realpath = join('/', @finding);
require "$realpath";
my $driver = "mysql";
my $dsn = "DBI:$driver:$database:$host:$port";
my $dbh = DBI->connect($dsn, $username, $password ) or die $DBI::errstr;

my $i=0;
my $x=0;
my %devices;
my %details;
my $sth = $dbh->prepare("SELECT IP, PORT, COMMUNITY,interfaces FROM sur2_devices ");
$sth->execute() or die $DBI::errstr;


while (my @row = $sth->fetchrow_array()) 
{
my @oid_inoctet;
my @oid_outoctet;
my @oid_oct;
   my ($ip, $port, $community,$interfaces ) = @row;
	$devices{"device$ip$port$community"}{ip}   = $ip;
	 $devices{"device$ip$port$community"}{port}    = $port;
	 $devices{"device$ip$port$community"}{community}   = $community;
   
   #print"$ip--- $interfaces\n";
   my @intf=split('&',$interfaces);
	 #print"@intf\n";
	 my $i=0;
	 foreach(@intf)
	 {
	 $devices{"device$ip$port$community"}{interface}{$_}=$_;
	 push(@oid_inoctet,"1.3.6.1.2.1.2.2.1.10.$_");
   push(@oid_outoctet,"1.3.6.1.2.1.2.2.1.16.$_");
	 
	 }
#print"@oid_inoctet\n";
#print"@oid_outoctet\n";
push(@oid_all,@oid_inoctet,@oid_outoctet);


#session creation
								my ($session, $error) = Net::SNMP->session(
									 -hostname    =>  $ip,
									 -community   =>  $community,
									 -port        =>  $port,
									 -nonblocking =>  1,
									 -version     =>  'snmpv2c',
								);
# Was the session created?
				if (!defined($session)) 
				{
					 printf("ERROR: %s.\n", $error);
					next;
				}
				while ((my $h=@oid_all) > 0)
				  {
				  
				  my $result_ifType = $session->get_request(
				                      -varbindlist      => [splice @oid_all, 0, 40],
				                      -callback        => [ \&sub_ifOct, $ip, $port, $community] ,    # non-blocking
				                      );
				                   
				  if (!defined($result_ifType))
								{
			 						printf "ERROR: Failed to queue get request for host '%s': %s.\n",
				        	 $session->hostname(), $session->error();
								}
								else{
								print "req sent";
								}
					}

}
snmp_dispatcher();
 sub sub_ifOct
{
 my @y;
 my ($session, $ip, $port, $community) = @_;
 
   my $result =  $session->var_bind_list();
   
   if (!defined $result)
    {
      printf "ERROR: Get request failed for host '%s': %s.\n",
             $session->hostname(), $session->error();
      return;
		}
		else
		{
		foreach (oid_lex_sort(keys(%{$session->var_bind_list()})))
					{
      		 $devices{"device$ip$port$community"}{"ifall"}{$_}=$result->{$_};
           }
      }

}
#print Dumper \%devices;

my @keys = keys %devices;
foreach my $p (@keys)
{
		 my $rrd = RRD::Simple->new( file => "$p.rrd" );
		 my @subject =keys % {$devices{$p}{"interface"}} ;
		 my @y;
		 my @add2;
		 my $j=0;
		 my $inagg=0;
		 my $outagg=0;
		foreach my $q (@subject)
      		 {
				         $y[$j]=$q;
				         $j++;
           }
           #print "@y\n";
           my @b=sort (@y);
           #print "@b\n";
           if(@b)
           {
						     my @add2;
						     my $file = "$p.rrd";
						     my $rrd = RRD::Simple->new( file => "$file" );
											if(! -e $file )   
													 {
													 my @add1;
													 	print "qwert";
														foreach (@b)
																	{
														 				
																	 push(@add1,("bytesIn$_" => "COUNTER"), ("bytesOut$_" => "COUNTER"));
										
																		}
																		push(@add1,("bytesIntotal" => "COUNTER"), ("bytesOuttotal" => "COUNTER"));
																		print "-----------@add1----------\n";
																		$rrd->create($file,"year", @add1);
																		print "$file created\n";
													 			 }
						    
						     
														foreach my $z (@b)
														{
														if(($devices{"$p"}{"ifall"}{"1.3.6.1.2.1.2.2.1.10.$z"})==noSuchInstance)
														{
														($devices{"$p"}{"ifall"}{"1.3.6.1.2.1.2.2.1.10.$z"})=0;
														}
														if(($devices{"$p"}{"ifall"}{"1.3.6.1.2.1.2.2.1.16.$z"})==noSuchInstance)
														{
														($devices{"$p"}{"ifall"}{"1.3.6.1.2.1.2.2.1.16.$z"})=0;
														}
														
														push(@add2,("bytesIn$z" => $devices{"$p"}{"ifall"}{"1.3.6.1.2.1.2.2.1.10.$z"}), ("bytesOut$z" => $devices{"$p"}{"ifall"}{"1.3.6.1.2.1.2.2.1.16.$z"}));
										$inagg=$inagg+$devices{"$p"}{"ifall"}{"1.3.6.1.2.1.2.2.1.10.$z"};
										$outagg=$outagg+$devices{"$p"}{"ifall"}{"1.3.6.1.2.1.2.2.1.16.$z"};
														}
														$devices{"$p"}{"inall"}="$inagg";
														$devices{"$p"}{"outall"}="$outagg";
							print "in agg is:$inagg\n";
							print "out agg is:$outagg\n";
							push(@add2,("bytesIntotal" => $devices{"$p"}{"inall"}), ("bytesOuttotal" => $devices{"$p"}{"outall"}));
							print "--------------@add2\n";
							my $x1=time();
							$rrd->update("$p.rrd",$x1,@add2);	
							print "$p updated\n";	
					}
			}
#print Dumper \%devices;
