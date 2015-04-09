<?php
define('DEALER_CWD', realpath(dirname(__FILE__)) );
require_once(realpath(dirname(__FILE__) . '/../..').'/Config/database.php');
$dealer_db = new DATABASE_CONFIG();
$dealer_db = $dealer_db->default;
//get user's IP address
if(isset($_SERVER["REMOTE_ADDR"])){
    $ip = $_SERVER["REMOTE_ADDR"];
}elseif(isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
    $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
}elseif(isset($_SERVER["HTTP_CLIENT_IP"])){
    $ip = $_SERVER["HTTP_CLIENT_IP"];
}
//get geodata from IP address
include(DEALER_CWD."/geoip/geoipcity.inc");
$gi = geoip_dl_open(DEALER_CWD."/geoip/GeoIPCity.dat",GEOIP_DL_STANDARD);
include(DEALER_CWD."/geoip/geoipregionvars.php");
//IP address for testing on localhost
$ip = "99.95.210.128";
$record = GeoIP_record_by_addr($gi, $ip);
geoip_dl_close($gi);
//If user is in US, continue with truckload workflow
if($record->country_code == 'US'){
    $con = mysql_connect($dealer_db['host'], $dealer_db['login'], $dealer_db['password']);
    mysql_select_db($dealer_db['database'], $con);
    //if the IP address didn't return a postal code, find the nearest postal code based on the IP coordinates
    if(!isset($record->postal_code) || empty($record->postal_code)){
        $zip_query = 'SELECT zipcodes.zipcode
            FROM jacuzzi.zipcodes
            WHERE zipcodes.latitude BETWEEN '.($record->latitude - 10).' AND '.($record->latitude + 10).'
                AND zipcodes.longitude BETWEEN '.($record->longitude - 10).' AND '.($record->longitude + 10).'
            ORDER BY (3963.0 * acos(sin(zipcodes.latitude/57.2958) * sin('.$record->latitude.'/57.2958) + cos
(zipcodes.latitude/57.2958) * cos('.$record->latitude.'/57.2958) *  cos('.$record->longitude.'/57.2958 -
zipcodes.longitude/57.2958))) ASC
                LIMIT 1';
        $zip_result = mysql_query($zip_query);

        if(!empty($zip_result)){
            while($zip_row = mysql_fetch_assoc($zip_result)){
                $zip = $zip_row['zipcode'];
            }
        }
    }else{
        $zip = $record->postal_code;
    }
    //If there is a postal code, get the postal code's dealer if that dealer is having a truckload sale
    if(isset($zip) && !empty($zip)){
        $result = mysql_query("SELECT dealers.id, dealers.city FROM dealers_zipcodes LEFT JOIN dealers ON 
dealers.id=dealers_zipcodes.dealer_id WHERE dealers_zipcodes.zipcode_id = '".$zip."' AND dealers.default_promo = 1 
AND (dealers.additional_html_start_sale <= UNIX_TIMESTAMP() OR dealers.additional_html_start <= UNIX_TIMESTAMP()) 
AND dealers.additional_html_end >= UNIX_TIMESTAMP()");
        while($row = mysql_fetch_assoc($result)){
            $dealer_id = $row['id'];
            $city_name = $row['city'];
            include(DEALER_CWD.'/popup_html.php');
            break;
        }
    }
}

?>
