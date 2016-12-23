***************************************
		LAB-3
***************************************

Packages required:

Perl DBI, Net::SNMP
Install Linux Lamp Stack which includes PHP, MySQL, Apache in one package using command "sudo apt-get install lamp-server^"
Install snmp: sudo apt-get install snmp

EXECUTION OF THE SCRIPT:
------------------------
1)Change the credentials in the db.conf file.
2)Give permissions to assignment3 directory
3)Add the following lines to the snmpdtrapd.conf file in the /etc/snmp/snmptrapd.conf:
authCommunity log,execute,net public 
disableAuthorization yes
#doNotLogTraps yes
snmpTrapdAddr udp:50162
traphandle 1.3.6.1.4.1.41717.10.* perl /var/www/html/et2536-sumu15/assignment3/trapDaemon.pl
4)Open file snmpd from /etc/default/snmpd and change the line:
TRAPDRUN=no to TRAPDRUN=yes
5) "sudo service snmpd restart"
6) Open the Terminal and give the trap command as follows:
sudo snmptrap -v 1 -c public 127.0.0.1:50162 .1.3.6.1.4.1.41717.10 10.2.3.4 6 247 '' .1.3.6.1.4.1.41717.10.1 s "" .1.3.6.1.4.1.41717.10.2 i 1
7). Open localhost/et2536-sumu15/assignment3/index.php, where you can see the status of the device. 


Copyright
==========
Suren Musinada
sumu15@student.bth.se
 


