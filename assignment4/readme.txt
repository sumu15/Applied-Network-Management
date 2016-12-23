------------------SNMP Device Monitoring Tool-----------------

	A Web GUI is provided by a tool which contains a dashboard that lists the present status of SNMP devices which is given by the user. The present status of device is shown in color format. Each device displayed on dashboard is clickable. On click, details like the device last reported sysuptime, numer of sent requests, number of lost requests and the webserver time of the respective device are shown. 


CONTENTS				DESCRIPTION
--------				-----------
index.php	-		The webpage of a tool that displays list of devices with their color status

readme.txt	-		This text file describes the tool, its prerequisites and the steps of installation.

backend		-		This is the script that triggers backend.pl for every 30 seconds

backend.pl	-		The backend perl script that calculates the systemuptime of every device in the list.


PREREQUISITES
-------------
libapache2-mod-php5
mysql-server
DBI
DBD::mysql
Net::SNMP
php 5.0.x or greater versions
perl
snmp
snmpd
apache server

PREREQUISITES INSTALLATION
--------------------------
libapache2-mod-php5 -> sudo apt-get install libapache2-mod-php5
mysql-server 				-> sudo apt-get install mysql-server
DBI  	     					-> sudo apt-get install libdbi-perl
DBD::mysql    	1. Install libmysqlclient-dev package by typing the following command in the terminal: 										->	 sudo apt-get install libmysqlclient-dev 
								2. Download the DBD-mysql-4.028.tar.gz file from the link: http://search.cpan.org/		~capttofu/DBD-mysql-4.028/lib/DBD/mysql.pm
								3. Extract the DBD-mysql-4.028.tar.gz file to a desired directory.
								4. Open terminal and change to that directory (cd <path to directory>/DBD-mysql-4.028).
								5. Type the following commands one after the other:
												$ perl Makefile.PL
												$ make
												# make install  (Here # indicates you need to execute that command as root).
Net::SNMP     	1. Install snmp package by typing the following command in the terminal:
										->	 sudo apt-get install snmp
								2. Install snmpd package by typing the following command in the terminal: 
										->	sudo apt-get install snmpd
								3. Install libperl-dev package by typing the following command in the terminal: 
										->	sudo apt-get install libperl-dev
								4. Install libnet-snmp-perl package by typing the following command in the terminal:
										->  sudo apt-get install libnet-snmp-perl
								5. Download the net-snmp-5.x.x.x.tar.gz file from the link: http://www.net-snmp.org/download.html (click on any of the source to download the file).
								6. Extract the net-snmp-5.x.x.x.tar.gz file to a desired directory.
								7. Open terminal and change to that directory (cd <path to directory>/net-			snmp-5.x.x.x).
								8. Type the following commands one after the other:
												$ ./configure
  											$ make
  											# make install  (Here # indicates you need to execute that command as root).
Net::SNMP installation steps)
php  	     					-> sudo apt-get install php5
php5-mysql  	     	-> sudo apt-get install php5-mysql
php-apache2  	     	-> sudo apt-get install php5-apache2
perl 	     					-> sudo apt-get install perl
apache server 			-> sudo apt-get install apache2

INSTALLATION & CONFIGURATION
----------------------------
1.Open terminal and change the working directory to assignment4 and execute 'backend.sh' script. Do not close the terminal window as it triggers the backend perl script every 10 seconds to retrieve sysup times of network devices. 
2. Now open browser and type http://localhost/<path to assignment4 directory>/index.php in the url bar.
3. A web page consisting of a dashboard with all the devices sepcified and the colored status of the device besides it appears.
4. Click the device to view the details of it, like: last reported sysuptime, numer of sent requests, number of lost requests and the time of update of these details.

Copyright
----------
SUREN MUSINADA
sumu15@student.bth.se