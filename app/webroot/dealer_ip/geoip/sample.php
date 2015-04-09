#!/usr/bin/php -q
<?php

// This code demonstrates how to lookup the country by IP Address

include("geoip.inc");

// Uncomment if querying against GeoIP/Lite City.
// include("geoipcity.inc");

$gi = geoip_dl_open("/usr/local/share/GeoIP/GeoIP.dat",GEOIP_DL_STANDARD);

echo geoip_dl_country_code_by_addr($gi, "24.24.24.24") . "\t" .
     geoip_dl_country_name_by_addr($gi, "24.24.24.24") . "\n";
echo geoip_dl_country_code_by_addr($gi, "80.24.24.24") . "\t" .
     geoip_dl_country_name_by_addr($gi, "80.24.24.24") . "\n";

geoip_dl_close($gi);

?>
