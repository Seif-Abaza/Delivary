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
 * Description of Tools
 *
 * @author abaza
 */
class Tools {

    const SUCCESS = 1; // 0001
    const NOTICE = 2; // 0010
    const RETERN = 4; // 0100
    const ERROR = 8; // 1000

    protected $DebugMode = false;

    /**
     * message levels
     *
     * @var array
     */
    static public $level = array(
        Tools::SUCCESS => 'success',
        Tools::NOTICE => 'notice',
        Tools::RETERN => 'retern',
        Tools::ERROR => 'error',
    );

    function __construct() {
        if (getcwd() == dirname(__FILE__)) {
            die(ShowError());
        }
    }

    public function getToday() {
        return date('d-m-Y');
    }

    public function getTime() {
        return date('H:i:s');
    }

    public function NowDateAndTime() {
        $Time = date('d-m-Y') . ' ' . date('H:i:s');
        return $Time;
    }

    public function removeDuplicat($Array) {
        $Data = array_unique($Array, SORT_STRING);
        uasort($Data, SORT_STRING);
        return $Data;
    }

    public function MeargArray($Array1, $Array2) {
        $Res = array_merge($Array1, $Array2);
        $Res2 = $this->removeDuplicat($Res);
        return $this->removeNull($Res2);
    }

    public function GetKeys($Array) {
        $ArrayKeys = array_keys($Array);
        if (!is_null($ArrayKeys)) {
            return $ArrayKeys;
        } else {
            return null;
        }
    }

    public function Sort_Up_to_Down($Array) {
        arsort($Array, SORT_REGULAR);
        return $Array;
    }

    public function Sort_Down_to_Up($Array) {
        asort($Array, SORT_REGULAR);
        return $Array;
    }

    public function Key_Sort_Up_to_Down($Array) {
        krsort($Array, SORT_REGULAR);
        return $Array;
    }

    public function Key_Sort_Down_to_Up($Array) {
        ksort($Array, SORT_REGULAR);
        return $Array;
    }

    public function GetKey($Value, $Array) {
        if (is_array($Array)) {
            foreach ($Array as $Key => $value) {
                if ((strcmp($Value, $value)) == 0) {
                    return $Key;
                }
            }
            return null;
        } else {
            return null;
        }
    }

    /**
     * (PHP 5)<br/>
     * Search_in_Array($Array,....Key or Value)
     * Returns FALSE if not found value , array if found it
     * @return array an array 
     */
    public function in_Array() {
        $Values = func_get_args();
        $Array = array();
        if (is_array($Values[0])) {
            $Array = $Values[0];
        } else {
            return null;
        }
        $Need = array_slice($Values, 1);
        $CountNeed = count($Need);
        $EleInt = 0;
        foreach ($Need as $element) {
            if (array_key_exists($element, $Array)) {
                $EleInt++;
                if ($EleInt == $CountNeed) {
                    return true;
                }
            }
        }
        return false;
    }

    public function isKeyExists($Key, $Array) {
        if (array_key_exists($Key, $Array)) {
            return true;
        } else {
            return false;
        }
    }

    public function getValue($Key, $Array) {
        foreach ($Array as $key => $value) {
            if ($key == $Key) {
                return $value;
            }
        }
        return NULL;
    }

    public function isClassExist($Class) {
        if (class_exists($Class)) {
            return true;
        } else {
            $this->System_Log("Can not found Class " . $Class, __FUNCTION__, __LINE__, self::ERROR);
            die(ShowError());
        }
    }

    public function isFunctionExist($Function) {
        if (function_exists($Function)) {
            return true;
        } else {
            $this->System_Log("Can not found Function " . $Function, __FUNCTION__, __LINE__, self::ERROR);
            die(ShowError());
        }
    }

    public function removeNull($Array) {
        $FilterData = array();
        if (!is_null($Array)) {
            foreach ($Array as $key => $value) {
                if (!is_null($value) || !empty($value)) {
                    if (is_string($value)) {
                        if (strlen($value) > 0) {
                            $FilterData[$key] = $value;
                        }
                    } else {
                        $FilterData[$key] = $value;
                    }
                }
            }
            if (count($FilterData) > 0) {
                return $FilterData;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public function ChangeValueInArray($Key, $New_Value, $Array) {
        $NewArray = null;

        foreach ($Array as $key => $value) {
            if ($key == $Key) {
                $NewArray[$key] = $New_Value;
            } else {
                $NewArray[$key] = $value;
            }
        }
        return $NewArray;
    }

    public function RemoveKeyInArray($Key, $Array) {
        $NewArray = null;
        $NewSubArray = null;
        $Loop = 0;
        if (is_array($Array[0])) {
            foreach ($Array as $SubArray) {
                foreach ($SubArray as $key => $value) {
                    if ($key != $Key) {
                        $NewSubArray[$key] = $value;
                    }
                }
                if (!is_null($SubArray)) {
                    $NewArray[$Loop++] = $NewSubArray;
                }
            }
        } else {
            foreach ($Array as $key => $value) {
                if ($key != $Key) {
                    $NewArray[$key] = $value;
                }
            }
        }
        return $NewArray;
    }

    public function ShowDie($Message) {
        $this->Show($Message);
    }

    public function Show($Message) {
        echo $Message . '<br><br><br>';
    }

    public function CreateURL($Path) {
        $URL = "http://" . $_SERVER['HTTP_HOST'] . DIRECTORY_SEPARATOR . SystemVariable(FILED_SYSTEM_APPLICATION_NAME) . DIRECTORY_SEPARATOR . $Path;
        $URL = htmlspecialchars($URL, ENT_IGNORE, 'utf-8');
        return $URL;
    }

    public function ShowBuffer($Message) {
        if (SystemVariable(FILED_SYSTEM_ENCRIPTION_BUFFER)) {
            if (is_array($Message)) {
                $MessageEnc = array();
                foreach ($Message as $Key => $Value) {
                    $MessageEnc[$Key] = md5($Value);
                }
            } else {
                $MessageEnc = '';
                $MessageEnc = md5($Message);
            }
            $this->System_Log($Message, __FUNCTION__, __LINE__, self::RETERN);
            print json_encode($MessageEnc);
        } else {
            $this->System_Log($Message, __FUNCTION__, __LINE__, self::RETERN);
            if (is_array($Message)) {
                uasort($Message, SORT_STRING);
            }
            print json_encode($Message);
        }
    }

    public function setDebug($debug) {
        if ($debug) {
            $ip = $GLOBALS[CLASS_FILTER]->GetIP();
            $url = $_SERVER['REQUEST_URI'];
            print("<b>Debug Mode is Run</b><br>");
            echo '<button type="button" onclick="MovetoAdmin()">Admin Control</button><br>';
            $ua = $GLOBALS[CLASS_FILTER]->getBrowser();
            $yourbrowser = "<b>Your browser</b> : " . $ua['name'] . " " . $ua['version'] . " on " . $ua['platform'] .
                    "<br><b>Reports</b> : " . $ua['userAgent'] . "<br>";
            $phpversion = "<b>PHP Version</b> : " . phpversion();
            echo $yourbrowser . $phpversion . '<br>';
            printf('<b>IP Address </b>: %s', $ip);
            printf('<br><b>URL </b>: %s <br><ul>', $url);
        }
        $this->DebugMode = $debug;
    }

    public function isDebug() {
        return $this->DebugMode;
    }

    /**
     * Generating random Unique MD5 String for user Api key
     */
    public function GenerateApiKey() {
        return md5(uniqid(rand(), true));
    }

    public function generateRandomString($Activ = false) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        if ($Activ) {
            for ($i = 0; $i < ACTIVE_LENGTH; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
        } else {
            for ($i = 0; $i < PASSWORD_LENGTH; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
        }
        return $randomString;
    }

    public function Count_Debug_time() {
//        try {
//            $fp = fopen(SYSTEM_FILE_TIME_FOR_DEBUG, "a");
//
//            $count = fgets($fp, 1024);
//
//            $cnew = $count + 1;
//            $countnew = fputs($fp, $count + 1);
//            fclose($fp);
//            return $cnew;
//        } catch (Exception $error) {
//            $this->System_Log($error, __FUNCTION__, __LINE__);
//            return 0;
//        }
    }

    public function Count_Bad_Word($Message) {
        $WordArray = explode(' ', $Message);
        if (is_array($WordArray)) {
            foreach ($WordArray as $word) {
                if ($GLOBALS[CLASS_DATABASE]->isExist(TABLE_BAD_WORD, array(FILED_BAD_WORD_WORD => $word))) {
                    $BadWord = $GLOBALS[CLASS_DATABASE]->select(TABLE_BAD_WORD, array(FILED_BAD_WORD_WORD => $word));
                    $Inc = intval($BadWord[FILED_BAD_WORD_HOW_TIME]) + 1;
                    $GLOBALS[CLASS_DATABASE]->update(TABLE_BAD_WORD, array(FILED_BAD_WORD_HOW_TIME => $Inc), array(FILED_BAD_WORD_ID => $BadWord[FILED_BAD_WORD_ID]));
                }
            }
        }
        return trim($Message);
    }

    public function Count_Worring_Word($Message) {
        $WordArray = explode(' ', $Message);
        if (is_array($WordArray)) {
            foreach ($WordArray as $word) {
                if ($GLOBALS[CLASS_DATABASE]->isExist(TABLE_WORRNING_WORD, array(FILED_WORRNING_WORD_WORD => $word))) {
                    $WorrningWord = $GLOBALS[CLASS_DATABASE]->select(TABLE_WORRNING_WORD, array(FILED_WORRNING_WORD_WORD => $word));
                    $Inc = intval($WorrningWord[FILED_BAD_WORD_HOW_TIME]) + 1;
                    $GLOBALS[CLASS_DATABASE]->update(TABLE_WORRNING_WORD, array(FILED_WORRNING_WORD_HOW_TIME => $Inc), array(FILED_WORRNING_WORD_ID => $WorrningWord[FILED_WORRNING_WORD_ID]));
                }
            }
        }
        return trim($Message);
    }

    public function Count_Hashtag($One_Word) {

        if ($GLOBALS[CLASS_DATABASE]->isExist(TABLE_HASHTAG, array(FILED_HASHTAG_WORD => $One_Word))) {

            $HashWord = $GLOBALS[CLASS_DATABASE]->select(TABLE_HASHTAG, array(FILED_HASHTAG_WORD => $One_Word));

            $Inc = intval($HashWord[FILED_HASHTAG_HOW_TIME]) + 1;

            $GLOBALS[CLASS_DATABASE]->update(TABLE_HASHTAG, array(FILED_HASHTAG_HOW_TIME => $Inc), array(FILED_HASHTAG_ID => $HashWord[FILED_HASHTAG_ID]));
        } else {

            $GLOBALS[CLASS_DATABASE]->insert(TABLE_HASHTAG, array(FILED_HASHTAG_WORD => $One_Word, FILED_HASHTAG_HOW_TIME => 1));
        }

        return '<a href="' . LINK_FOR_HASH_GROUPS . $One_Word . '">' . $One_Word . '</a>';
    }

    public function ToOneArray($MainArray) {
        $new_array = array();
        foreach ($MainArray as $array) {
            foreach ($array as $val) {
                array_push($new_array, $val);
            }
        }
        return $new_array;
    }

    public function convertHashtags($str) {

        $matches = array();
        $final = '';
        $regex = '/#(\w*[a-zA-Z0-9-أ-إ-آ-ا-ب-ت-ث-ج-ح-خ-د-ذ-ر-ز-س-ش-ص-ض-ط-ظ-ع-غ-ف-ق-ك-ل-م-ن-ه-و-لا-لا-لآ-لأ-لإ-ى-ي-ئ-ة-ء-ؤ_].+?)(?=[\s.,:,]|$)/';
        preg_match_all($regex, $str, $matches);
        $arr_str = $this->removeNull(explode(' ', str_replace('#', '', $str)));
        $tmpHash = $this->removeDuplicat($matches[1]);
        $HashWords = array();
        foreach ($tmpHash as $hash) {
            if ((str_word_count($hash)) > 1) {
                $tmp = explode(' ', $hash);
                array_push($HashWords, $tmp[0]);
            } else {
                array_push($HashWords, $hash);
            }
        }

        foreach ($arr_str as $Word) {
            if (in_array($Word, $HashWords)) {
                if (!strstr($final, $Word)) {
                    $UrlHash = $this->Count_Hashtag($this->getValue(array_search($Word, $HashWords), $HashWords));
                    if (!strstr($final, $UrlHash)) {
                        $final .= ' ' . $UrlHash;
                    }
                } else {
                    $final .= ' ' . $Word;
                }
            } else {
                if (!strstr($final, $Word)) {
                    $final .= ' ' . $Word;
                }
            }
        }

        if (strlen($final) <= 0) {
            return $str;
        }
        return(trim($final));
    }

    public function forString($Text) {
        return trim($this->convertHashtags($this->Count_Worring_Word($this->Count_Bad_Word($Text))));
    }

    public function Language($Text) {
        return $Text;
    }

    public function Serial_Number_Implimntation($Serial) {
        $Len = strlen($Serial);
        if ($Len == 16) {
            return $Serial;
        } else {
            return null;
        }
    }

    public function System_Log($Echo, $Function, $Line, $level = null, $WithRequest = false) {
        if (is_null($level)) {
            $level = self::$level[Tools::NOTICE];
        } else {
            $level = self::$level[$level];
        }

        if (SystemVariable(FILED_SYSTEM_LOG_SYSTEM)) {
            $Time = $this->getTime();
            $Date = $this->getToday();
            $ip = $GLOBALS[CLASS_FILTER]->GetIP();
            $Location = $GLOBALS[CLASS_FILTER]->GetCountry(GEO_CITYNAME);
            $url = $_SERVER['REQUEST_URI'];

            $bro = $_SERVER['HTTP_USER_AGENT'];
            $re = print_r($_REQUEST, true);

            $Message = null;
            $LogSystem = array();

            if (is_array($Echo)) {
                $Result = print_r($Echo, true);
                if ($WithRequest) {
                    $Message = $level . ' ( ' . $Time . ' | ' . $Date . ' )( ' . $ip . ':' . $Location . ' ) (' . $Function . ') (' . $Line . ') Array : [' . $Result . '].  URL : ' . $url . '. Request : ' . $re . PHP_EOL;
                } else {
                    $Message = $level . ' ( ' . $Time . ' | ' . $Date . ' )( ' . $ip . ':' . $Location . ' ) (' . $Function . ') (' . $Line . ') Array : [' . $Result . '].  URL : ' . $url . '.' . PHP_EOL;
                }
                $LogSystem = array(
                    FILED_SYSTEM_LOG_ACTION => $Function . " Line : " . $Line,
                    FILED_SYSTEM_LOG_INFO => $Result,
                    FILED_SYSTEM_LOG_IP_CLIENT => $ip,
                    FILED_SYSTEM_LOG_REQUEST => $re,
                    FILED_SYSTEM_LOG_LEVEL => $level
                );
            } else {
                if ($WithRequest) {
                    $Message = $level . ' ( ' . $Time . ' | ' . $Date . ' )( ' . $ip . ':' . $Location . ' ) (' . $Function . ') (' . $Line . ') Message : ' . $Echo . '. URL : ' . $url . '. Request : ' . $re . PHP_EOL;
                } else {
                    $Message = $level . ' ( ' . $Time . ' | ' . $Date . ' )( ' . $ip . ':' . $Location . ' ) ( ' . $Function . ') (' . $Line . ') Message : ' . $Echo . '. URL : ' . $url . '.' . PHP_EOL;
                }
                $LogSystem = array(
                    FILED_SYSTEM_LOG_ACTION => $Function . " Line : " . $Line,
                    FILED_SYSTEM_LOG_INFO => $Echo,
                    FILED_SYSTEM_LOG_IP_CLIENT => $ip,
                    FILED_SYSTEM_LOG_REQUEST => $re,
                    FILED_SYSTEM_LOG_LEVEL => $level
                );
            }

            $LogSystem = $this->removeNull($LogSystem);

            //Save in database 
            $GLOBALS[CLASS_DATABASE]->insert(TABLE_SYSTEM_LOG, $LogSystem);

            //Time Execution
//            $TimeExe = sys_getloadavg();
//            echo $TimeExe[0];
        }
    }

}
