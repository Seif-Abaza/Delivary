<?php

// geolocation.php

require_once('continents.php');
require_once('countries.php');
require_once('geoipcity.inc');
require_once('geoipregionvars.php');

$IP2C_NULL_GEOLOCATION = array(
    "countryCode2" => "Unknown",
    "countryCode3" => "Unknown",
    "continentCode" => "Unknown",
    "continentName" => "Unknown",
    "countryName" => "Unknown",
    "regionName" => "Unknown",
    "cityName" => "Unknown",
    "cityLatitude" => 0,
    "cityLongitude" => 0,
    "countryLatitude" => 0,
    "countryLongitude" => 0
);

function ip2c_geolocation($ip) {
    global $IP2C_CONTINENT, $IP2C_CONTINENT_NAME;
    global $IP2C_COUNTRY_LOCATION, $GEOIP_REGION_NAME;
    global $IP2C_NULL_GEOLOCATION;

    $geolocation = $IP2C_NULL_GEOLOCATION;
    $gi = geoip_open(GEOIP_DATA_FILE, GEOIP_STANDARD);
    if ($record = geoip_record_by_addr($gi, $ip)) {
        $geolocation[GEO_CONTINENT_CODE] = $IP2C_CONTINENT[$record->country_code];
        $geolocation[GEO_CONTINENTNAME] = $IP2C_CONTINENT_NAME[$IP2C_CONTINENT[$record->country_code]];
        $geolocation[GEO_CONTINENT] = $IP2C_CONTINENT[$record->country_code];
        $geolocation[GEO_COUNTRYCODE2] = $record->country_code;
        $geolocation[GEO_COUNTRYCODE3] = $record->country_code3;
        $geolocation[GEO_COUNTRYNAME] = $record->country_name;
        $geolocation[GEO_REGIONNAME] = $GEOIP_REGION_NAME[$record->country_code][$record->region];
        $geolocation[GEO_CITYNAME] = $record->city;
        $geolocation[GEO_CITYLATITUDE] = $record->latitude;
        $geolocation[GEO_CITYLONGITUDE] = $record->longitude;
        $geolocation[GEO_COUNTRYLATITUDE] = $IP2C_COUNTRY_LOCATION[$record->country_code][0];
        $geolocation[GEO_COUNTRYLONGITUDE] = $IP2C_COUNTRY_LOCATION[$record->country_code][1];
        if ($geolocation[GEO_REGIONNAME] == "") {
            $geolocation[GEO_REGIONNAME] = "Unknown";
        }
        if ($geolocation[GEO_CITYNAME] == "") {
            $geolocation[GEO_CITYNAME] = "Unknown";
        }
        $geolocation[GEO_LOCALTIMEZONE] = ip2c_getTimeZone($record->country_code, $record->longitude);
        $geolocation[GEO_LOCALTIMEEPOCH] = ip2c_getLocalTime($geolocation[GEO_LOCALTIMEZONE]);
    }
    geoip_close($gi);
    return $geolocation;
}

?>
