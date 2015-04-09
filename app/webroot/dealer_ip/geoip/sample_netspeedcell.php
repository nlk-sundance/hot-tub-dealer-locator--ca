#!/usr/bin/php -q
<?php

include("geoip.inc");

$gi = geoip_dl_open("/usr/local/share/GeoIP/GeoIPNetSpeedCell.dat",GEOIP_DL_STANDARD);

$netspeed = geoip_dl_name_by_addr($gi,"24.24.24.24");

print $netspeed . "\n";

geoip_dl_close($gi);

?>
