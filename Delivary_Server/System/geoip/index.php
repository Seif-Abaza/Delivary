<?php
require "geolocation.php";
require "localTime.php";

/*
 * Geolocation
 */
$General_IP = '91.231.218.128'; //getenv("REMOTE_ADDR");
$geolocation = ip2c_geolocation($General_IP);
$continentCode = $geolocation['continentCode'];
$continentName = $geolocation['continentName'];
$countryCode2 = $geolocation['countryCode2'];
$countryCode3 = $geolocation['countryCode3'];
$countryName = $geolocation['countryName'];
$regionName = $geolocation['regionName'];
$cityName = $geolocation['cityName'];
$cityLatitude = $geolocation['cityLatitude'];
$cityLongitude = $geolocation['cityLongitude'];
$countryLatitude = $geolocation['countryLatitude'];
$countryLongitude = $geolocation['countryLongitude'];

/*
 * Time zone
 */
$localTimeZone = ip2c_getTimeZone($countryCode2, $cityLongitude);
$localTimeEpoch = ip2c_getLocalTime($localTimeZone);

class MyGeo {

    var $filename1 = "./GeoIPCountryWhois.csv";
    var $filename2 = "./GeoIPASNum2.csv";
    var $filename3 = "./GeoLiteCity-Blocks.csv";
    var $filename4 = "./GeoLiteCity-Location.csv";
    var $IP_FROM, $IP_TO, $Code1, $Code2, $Country_Code, $Country_Name;
    var $Code3, $Code4, $Company;
    var $Code5, $Code6, $Location;
    var $LocationID, $Region, $City, $Post_Code, $Latitude, $Longitude, $MetroCode, $AreaCode;
    var $General_IP = '91.231.218.128';

    function Insert($format) {
        $servername = "localhost";
        $username = "root";
        $password = "trinitron";
        $dbname = "super_wow";

// Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        if ($conn->query($format) === TRUE) {
            echo "New record created successfully <br>";
        } else {
            echo "Error: " . $newformat . "<br>" . $conn->error;
        }

        $conn->close();
    }

    function Step1() {
        $file = fopen($this->filename1, "r");
        if ($file != false) {
            while (!feof($file)) {
                $temp_data = trim(fgets($file));
                if (!empty($temp_data)) {
                    list( $this->IP_FROM, $this->IP_TO, $this->Code1, $this->Code2, $this->Country_Code, $this->Country_Name) = explode(',', $temp_data);
                    $Country = str_replace("'", "\'", $this->Country_Name);
                    $format = "INSERT INTO `super_wow`.`GEO` "
                            . "(`_IP_FROM`, `_IP_TO`, `_CODE_1`, `_CODE_2`, "
                            . "`_COUNTRY_CODE`, `_COUNTRY_NAME`, `_COMPANY`, `_REGION`, "
                            . "`_CITY`, `_POST_CODE`, `_LATITUDE`, `_LONGITUDE`, `_METRO_CODE`,"
                            . " `_ARIEA_CODE`, `_BLOCK`) VALUES ('{$this->IP_FROM}', '{$this->IP_TO}', '{$this->Code1}', '{$this->Code2}', '$this->Country_Code', '$Country', '', '', '', '', '', '', '', '', '');";
                    $this->Insert(str_replace('"', '', $format));
                }
            }
        }
    }

    function Step2() {
        $file = fopen($this->filename2, "r");
        if ($file != false) {
            while (!feof($file)) {
                $temp_data = trim(fgets($file));
                if (!empty($temp_data)) {
                    list( $this->Code3, $this->Code4, $this->Company) = explode(',', $temp_data);
                }
            }
        }
    }

    function ip_in_range($ip, $range) {
        if (strpos($range, '/') == false) {
            $range .= '/32';
        }
        // $range is in IP/CIDR format eg 127.0.0.1/24
        list( $range, $netmask ) = explode('/', $range, 2);
        $range_decimal = ip2long($range);
        $ip_decimal = ip2long($ip);
        $wildcard_decimal = pow(2, ( 32 - $netmask)) - 1;
        $netmask_decimal = ~ $wildcard_decimal;
        if (( $ip_decimal & $netmask_decimal ) == ( $range_decimal & $netmask_decimal )) {
            return true;
        } else {
            return false;
        }
    }

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

    <head>
        <title>IP Geolocator</title>
        <meta content='text/html; charset=UTF-8' http-equiv='Content-Type' />
    </head>

    <body>

        <h1>IP Geolocator</h1>

        <table>
            <tr><td>IP address:</td><td><?php echo $General_IP; ?></td></tr>
            <tr><td>Continent:</td><td><?php echo $continentName; ?></td></tr>
            <tr><td>Continent code:</td><td><?php echo $continentCode; ?></td></tr>
            <tr><td>Country:</td><td><?php echo $countryName; ?></td></tr>
            <tr><td>Country code:</td><td><?php echo $countryCode2; ?></td></tr>
            <tr><td>Country code:</td><td><?php echo $countryCode3; ?></td></tr>
            <tr><td>Country Longitude:</td><td><?php echo $countryLongitude; ?></td></tr>
            <tr><td>Country Latitude:</td><td><?php echo $countryLatitude; ?></td></tr>
            <tr><td>Region:</td><td><?php echo $regionName; ?></td></tr>
            <tr><td>City:</td><td><?php echo $cityName; ?></td></tr>
            <tr><td>City Longitude:</td><td><?php echo $cityLongitude; ?></td></tr>
            <tr><td>City Latitude:</td><td><?php echo $cityLatitude; ?></td></tr>
            <tr><td>Time zone:</td><td><?php echo $localTimeZone; ?></td></tr>
            <tr><td>Local time:</td><td><?php echo $localTimeEpoch; ?></td></tr>
        </table>
        <?php
        $Code = new MyGeo();
        $Code->Step1();
        ?>
    </body>
</html>
