<?php

if (getcwd() == dirname(__FILE__)) {
    require '../System/ErrorPage.php';
    die(ShowError());
}
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Filtering
 *
 * @author abaza
 */
class Filtering {

    function __construct() {
        if (getcwd() == dirname(__FILE__)) {
            die(ShowError());
        }
    }

    public function filterWord($name) {

//        $input = stripslashes($input);
        return $input;
    }

    public function FilterData($Var) {
        $Data = '';
        $temp = null;

        if (isset($Var) || !empty($Var)) {
            switch (SystemVariable(FILED_SYSTEM_STREAMING_DATA_METHOD)) {
                case 0://POST
                    $CommandServer = "HTTP_" . strtoupper($Var);
                    $temp = $_SERVER;
                    if (is_array($temp)) {
                        $Data = $temp[$CommandServer];
                        if (!empty($Data)) {
                            return mysql_real_escape_string($Data);
                        } else {
                            return NULL;
                        }
                    }
                    return NULL;
                    break;
                case 1://GET
                    $temp = filter_input(INPUT_GET, $Var);
                    if (isset($temp) || !empty($temp)) {
                        if (is_string($temp)) {
                            $Data = trim($temp);
                            $input = htmlspecialchars($Data, ENT_IGNORE, 'UTF-8');
                            
                            
                            return $input;
                        }

                        if (is_numeric($Data)) {
                            if (is_float($Data)) {
                                return (float) $Data;
                            } elseif (is_int($Data)) {
                                return (int) $Data;
                            } else {
                                return $Data;
                            }
                        }
                        if (is_object($Data)) {
                            return (object) $Data;
                        }
                    }
                    break;
            }
        } else {
            return NULL;
        }
    }

    public function isBlackList() {
        $IP_ADDR = array(
            FILED_SYSTEM_BLOCK_IP_ADDRESS_IP_ADDRESS => $this->GetIP(),
        );
        $Configration = Configration();
        $Database = $this->Database = new SQLClass($Configration['db'], $Configration['user'], $Configration['pass']);
        $RET = $Database->select(TABLE_SYSTEM_BLOCK_IP_ADDRESS, $IP_ADDR);
        unset($Database);
        unset($Configration);

        if (!is_null($RET)) {
            if (($RET[FILED_SYSTEM_BLOCK_IP_ADDRESS_BLOCK_IP]) == ON) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function setBlackList($IP_ADDRESS) {
        $IP_ADDR = array(
            FILED_SYSTEM_BLOCK_IP_ADDRESS_BLOCK_IP => ON,
            FILED_SYSTEM_BLOCK_IP_ADDRESS_BROWSER => $_SERVER['HTTP_USER_AGENT'],
//            FILED_SYSTEM_BLOCK_IP_ADDRESS_COUNTRY => $this->detect_location($IP_ADDRESS),
            FILED_SYSTEM_BLOCK_IP_ADDRESS_IP_ADDRESS => $IP_ADDRESS,
            FILED_SYSTEM_BLOCK_IP_ADDRESS_REQU => print_r($_REQUEST, true)
        );
        $Configration = Configration();
        $Database = $this->Database = new SQLClass($Configration['db'], $Configration['user'], $Configration['pass']);

        $Database->insert(TABLE_SYSTEM_BLOCK_IP_ADDRESS, $IP_ADDR);

        unset($Database);
        unset($Configration);
    }

    public function getBrowser() {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version = "";

//First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

// Next get the name of the useragent yes seperately and for good reason
        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
            if (!SystemVariable(FILED_SYSTEM_CAN_GET_DATA_FROM_BROWSER)) {
                die(ShowError());
            }
        }
        if (preg_match('/Firefox/i', $u_agent)) {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
            if (!SystemVariable(FILED_SYSTEM_CAN_GET_DATA_FROM_BROWSER)) {
                die(ShowError());
            }
        }
        if (preg_match('/Chrome/i', $u_agent)) {
            $bname = 'Google Chrome';
            $ub = "Chrome";
            if (!SystemVariable(FILED_SYSTEM_CAN_GET_DATA_FROM_BROWSER)) {
                die(ShowError());
            }
        }
        if (preg_match('/Safari/i', $u_agent)) {
            $bname = 'Apple Safari';
            $ub = "Safari";
            if (!SystemVariable(FILED_SYSTEM_CAN_GET_DATA_FROM_BROWSER)) {
                die(ShowError());
            }
        }
        if (preg_match('/Opera/i', $u_agent)) {
            $bname = 'Opera';
            $ub = "Opera";
            if (!SystemVariable(FILED_SYSTEM_CAN_GET_DATA_FROM_BROWSER)) {
                die(ShowError());
            }
        }
        if (preg_match('/Netscape/i', $u_agent)) {
            $bname = 'Netscape';
            $ub = "Netscape";
            if (!SystemVariable(FILED_SYSTEM_CAN_GET_DATA_FROM_BROWSER)) {
                die(ShowError());
            }
        }

// finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
                ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
// we have no matching number just continue
        }

// see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
//we will have two since we are not using 'other' argument yet
//see if version is before or after the name
            if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                $version = $matches['version'][0];
            } else {
                $version = $matches['version'][1];
            }
        } else {
            $version = $matches['version'][0];
        }

// check if we have a number
        if ($version == null || $version == "") {
            $version = "?";
        }

        $DataBrowser = array(
            'name' => (!strstr($u_agent, 'OPR') ? $bname : 'Opera'),
            'userAgent' => $u_agent,
            'version' => $version,
            'platform' => $platform,
            'pattern' => $pattern
        );
        if (SystemVariable(FILED_SYSTEM_CAN_GET_DATA_FROM_BROWSER)) {
            return $DataBrowser;
        } else {
            $attackbrowser = "browser try to get information: " . $DataBrowser['name'] . " " . $DataBrowser['version'] . " on " . $DataBrowser['platform'] .
                    " reports: <br >" . $DataBrowser['userAgent'];

            $GLOBALS[CLASS_TOOLS]->System_Log($attackbrowser, __FUNCTION__, __LINE__, Tools::NOTICE);
        }
    }

    public function GetIP() {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (array_map('trim', explode(',', $_SERVER[$key])) as $ip) {
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    } else {
                        $host = gethostname();
                        $ip = gethostbyname($host);
                        return $ip;
                    }
                }
            }
        }
    }

    public function GetCountry($Filed = null) {
        require_once MAIN_DIR . '/System/geoip/geolocation.php';
        $VisitorIP = $this->GetIP();
        $geolocation = ip2c_geolocation($VisitorIP);
        if (is_null($Filed)) {
            return $geolocation;
        } else {
            return $geolocation[$Filed];
        }
    }

}
