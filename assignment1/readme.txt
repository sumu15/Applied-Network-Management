******
MRTG *
******

To install MRTG, run the file mrtgconf.pl in the same folder.

   perl mrtgconf.pl


*********************
Bitrate calculation *
*********************

The tool reads device credentials from table `DEVICES` and displays the bitrate for selected device and selected interface. The grpahs are seperated according to the in bit rate and out bit rate.



================================================================================================================================

																										Pre-requisites 
																										
================================================================================================================================

Properly installed and required configurations

			mysql-server
			apache2
			snmpd
			snmp
			php5

Required permissions must be enabled 

The webserver you are using should have read and write permissions to the directory et2536-srch15 and to the assignmnets directories.
================================================================================================================================

																										Installations
																										
================================================================================================================================																										

The following components need to be installed. 

sudo apt-get update
sudo apt-get install apache2
sudo apt-get install snmp
sudo apt-get install snmpd

sudo apt-get install libdbi-perl
sudo apt-get install libpango1.0-dev 
sudo apt-get install  libxml2-dev
sudo apt-get install libsnmp-perl 
sudo apt-get install libsnmp-dev 
sudo apt-get install libnet-snmp-perl
sudo apt-get install rrdtool
sudo apt-get install rrdtool-dbg
sudo apt-get install php5-rrd
sudo apt-get install php5-snmp
sudo perl -MCPAN -e 'install Net::SNMP'
sudo perl -MCPAN -e 'install Net::SNMP::Interfaces'
sudo perl -MCPAN -e 'install RRD::Simple'	


================================================================================================================================

																										Instructions
																										
================================================================================================================================

1.To Configure the mrtg tool run the mrtgconf file which is in the same folder. This should be run with necesary permissions(sudo)

					sudo perl mrtgconf.pl
*MRTG does not accept if the multiple devices have the same interfaces. even though they have different ip address and community.


2. The backend script has to be placed as a cron job. Following are commands in command line

					sudo crontab -e
					
	 Add the line at the bottom 
	 
	 			 */5 * * * * /path/to/et2536-srch15/assignment1/backend.pl				
	 
	 Save and exit. Start the daemon by
	 
	 			 sudo service cron start

3. Wait for atleast 15 to 20 minutes  for values to get updated.

4. From your browser go to the folder assignment1

5. The list of available devices which are curently being monitored is displayed.

6. Enter the details of the device you want to view the graphs for and press "Submit".

7. The list of Interface ID's which are being monitored will be displayed. The loop back interfaces and sub-layer interfaces 
   are not probed.

8. Enter the interface ID for which you want to view the graphs for and press "Go".

9. The updated data can be viewed by refreshing the browser


================================================================================================================================

																										Note
																										
================================================================================================================================

1. It is up to the user to enter the proper valid information. The tool doesnt verify. 

2. Wrong detials might return errors and cause the programme to fail. 

3. If a device is removed from the database, it is not shown in the table but the graphs can be viewed by entering the right credentials. 

4. SInce it not a reqiurement , the number of requests per divece is not limited. Multiple requests per device are sent.  Non-blocking method was not used to retrieve the data. 




Copyright
==========
Suren Musinada
sumu15@student.bth.se