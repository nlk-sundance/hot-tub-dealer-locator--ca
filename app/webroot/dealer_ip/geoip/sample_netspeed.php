#!/usr/bin/php -q
<?php

include("geoip.inc");

$gi = geoip_dl_open("/usr/local/share/GeoIP/GeoIPNetSpeed.dat",GEOIP_DL_STANDARD);

$netspeed = geoip_dl_country_id_by_addr($gi,"24.24.24.24");

//print $n . "\n";
if ($netspeed == GEOIP_DL_UNKNOWN_SPEED){
  print "Unknown\n";
}else if ($netspeed == GEOIP_DL_DIALUP_SPEED){
  print "Dailup\n";
}else if ($netspeed == GEOIP_DL_CABLEDSL_SPEED){
  print "Cable/DSL\n";
}else if ($netspeed == GEOIP_DL_CORPORATE_SPEED){
  print "Corporate\n";
}

geoip_dl_close($gi);

?>
