#!/usr/bin/perl

use DBI;
use FindBin qw($Bin);
use File::Basename qw(dirname);
use File::Spec::Functions qw(catdir);
use Data::Dumper;


my $original= $Bin;  
my $directory= dirname($original);
my $finalpath = catdir($directory, 'db.conf');

open (FILE,$finalpath) or die 'Cannot open';

while (my $line = <FILE>) {
        my @fields = (split '"',$line);
	push @data , \@fields;
}
   
foreach my $a_ref ($data['0']) 
{
      $host = $a_ref->[1];
}
foreach my $a_ref ($data['1']) 
{
      $port = $a_ref->[1];
}

foreach my $a_ref ($data['2']) 
{
      $database = $a_ref->[1];
}

foreach my $a_ref ($data['3']) 
{
      $username = $a_ref->[1];
}

foreach my $a_ref ($data['4']) 
{
      $password = $a_ref->[1];
}

$dsn = "DBI:mysql:database=$database;host=$host;port=$port";
$dbh = DBI->connect($dsn,$username,$password);


$sql1="CREATE TABLE IF NOT EXISTS DEVICES (
id int (11) NOT NULL AUTO_INCREMENT,
IP tinytext NOT NULL,
PORT int (11) NOT NULL,
COMMUNITY tinytext NOT NULL,
PRIMARY KEY ( id )
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";
my $result1 = $dbh->do( $sql1 ) or die("Can't create table\n");

$sql2 = $dbh->prepare("SELECT * FROM DEVICES");
$sql2->execute() or die ("can't select\n");

my $cmd = system("sudo apt-get install mrtg");
my $cmd1 = system("sudo updatedb && locate mrtg");
my $cmd2 = system("sudo mkdir /etc/mrtg && sudo mv /etc/mrtg.cfg /etc/mrtg");

while (@results = $sql2->fetchrow()) {
my $x = "$results[3]"."@"."$results[1]".":"."$results[2]";
push(@y,$x);
}
my $cmd4 = system("sudo mkdir /var/www/mrtg");
my $cmd3 = system("sudo cfgmaker --global 'WorkDir: /var/www/mrtg' --global 'Options[_]: growright' --global 'RunAsDaemon: Yes' --global 'Interval: 5' --output /etc/mrtg/mrtg.cfg @y");
my $cmd8 = system("sudo env LANG=C /usr/bin/mrtg /etc/mrtg/mrtg.cfg --logging /var/log/mrtg.log");
my $cmd6 = system("sudo indexmaker --output=/var/www/mrtg/index.html /etc/mrtg/mrtg.cfg");

$path = '/etc/apache2/apache2.conf';
open (FILE,'>>',$path)  or die "Could not open file: $!\n";
print FILE "Alias /mrtg /var/www/mrtg/
	
	<Directory /var/www/mrtg/>
        	Options None
        	AllowOverride None
        	Require all granted
		Allow from all
	</Directory> 
	ServerName locahost:80 \n";
	
 
my $cmd7 = system("sudo service apache2 restart");













	
