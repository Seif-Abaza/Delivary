<?php
include_once './directors.php';
error_reporting(E_ERROR);
ini_set('arg_separator.output', '&amp;');
ini_set('max_execution_time', 0);
session_start();
set_time_limit(0);


include MAIN_DIR . '/Including.php';

class AndroServer {

    protected $CommandMain = null;
    protected $DebugMode = false;
    protected $Server = null;
    protected $ServerDelivery = null;
    protected $Filter = null;
    protected $Tools = null;
    protected $Database = null;
    private $FunctionArray = array();

    function __invoke() {

        if (SystemVariable(FILED_SYSTEM_IS_ONLINE_SERVER)) {
            if (SystemVariable(FILED_SYSTEM_IS_UPDATE)) {
                die(ShowUpdate());
                exit(0);
            }

//            if ($this->Filter->isBlackList()) {
//                die(ShowError());
//            }
        } else {
            echo '<h1><p style="color:red">Server is Offline</p></h1><br>';
        }
    }

    public function __construct() {
        //Globel Variables
        global $Tools;
        global $Database;
        global $Filter;


        if (is_null($this->Filter)) {
            $Filter = $this->Filter = new Filtering();
        }

        $this->__invoke();

        if (is_null($this->ServerDelivery)) {
            $this->ServerDelivery = new core_delivery($this);
        }

        if (is_null($this->Tools)) {
            $Tools = $this->Tools = new Tools();
        }

        $Data = $this->Filter->FilterData(DEBUG);

        $this->DebugMode = (isset($Data) ? true : false);

        $this->Tools->setDebug($this->DebugMode);


        if ($this->Tools->in_Array($_GET, MAIN_COMMAND_DELIVERY)) {
            $this->CommandMain = $this->Filter->FilterData(MAIN_COMMAND_DELIVERY);
            if (empty($this->CommandMain)) {
                die(ShowError());
                exit(0);
            } else {
                if ($this->DebugMode) {
                    echo '<b>Welcome to Delivery Server</b><br>';
                }
            }
            $this->FunctionArray = GetFunctionsDelivery();
        } else {
            die(ShowError());
            exit(0);
        }


        if (is_null($this->Database)) {
            $Configration = Configration();
            $Database = $this->Database = new SQLClass($Configration['db'], $Configration['user'], $Configration['pass']);
            if (!isset($this->Database)) {
                $this->User_Log(__FUNCTION__, __LINE__, "ERROR", "Database Not Connected : " . $this->Database->ReturnError());
                die($this->Tools->ShowDie("We Are Sorry But try Later"));
            } else {
                if ($this->DebugMode) {
                    ?>
                    <script>
                        function MovetoAdmin() {
                            var dir;
                            dir = document.URL.substr(0, document.URL.lastIndexOf('/'));
                            window.location.replace(dir + "/mind/login.php");
                        }
                    </script>
                    <?php

                    echo '<b>Database is Online</b><br>';
                }
            }
        }

        session_name($this->Tools->generateRandomString());
        register_shutdown_function(array($this, '__destruct'));

        /*         * ****************Start Working from Here******************** */
        $this->Tools->System_Log("Start Session " . session_name(), __FUNCTION__, __LINE__);

        if (!is_null($this->CommandMain)) {
            if ($this->URL_Check($this->CommandMain)) {
                $this->Switching($this->CommandMain);
            } else {
                $this->Tools->System_Log("Error in Command , it is not in array command ", __FUNCTION__, __LINE__);
                die(ShowError());
                exit(0);
            }
        } elseif (!is_null($Key = $this->Tools->getValue(MAIN_COMMAND_DELIVERY, $_REQUEST))) {
            if (!is_null($Key)) {
                if ($this->URL_Check($Key)) {
                    $this->Switching($Key);
                } else {
                    $this->Tools->System_Log("Error in Command , it is not in array command", __FUNCTION__, __LINE__);
                    die(ShowError());
                    exit(0);
                }
            } else {
                $this->Tools->System_Log("Fail to get " . MAIN_COMMAND . " in Request.", __FUNCTION__, __LINE__);
                die(ShowError());
                exit(0);
            }
        } else {
            $this->Tools->System_Log("Not found Main Command (Main Key) so System can't accept this order", __FUNCTION__, __LINE__);
            die(ShowError());
            exit(0);
        }
    }

    private function Switching($Command) {
        $this->Tools->System_Log("Open Key " . $Command, __FUNCTION__, __LINE__);
        $Keys = $this->Tools->GetKeys($this->FunctionArray);
        for ($i = 0; $i <= count($this->FunctionArray) - 1; $i++) {
            if (in_array($Command, $this->FunctionArray[$Keys[$i]])) {
                $this->Moving($this->ServerDelivery, $Keys[$i], $Command);
                break;
            }
        }
    }

    private function URL_Check($Command) {
        $this->Tools->System_Log("URL Check", __FUNCTION__, __LINE__);
        foreach ($this->FunctionArray as $Element) {
            if (is_array($Element)) {
                if (in_array($Command, $Element)) {
                    return true;
                }
            }
        }
        return false;
    }

    private function Moving($Class, $Function, $arg = NULL) {
        $this->Tools->System_Log("Implimantation Function " . $Function, __FUNCTION__, __LINE__);
        if ($this->DebugMode) {
            if (isset($arg)) {
                if (is_string($arg)) {
                    $this->Tools->System_Log("String", __FUNCTION__, __LINE__);
                    $this->MovingRecording("Moving to " . $Function . " With Args " . $arg);
                } else if (is_int($arg)) {
                    $this->Tools->System_Log("Integer", __FUNCTION__, __LINE__);
                    $this->MovingRecording("Moving to " . $Function . " With Args Integer " . $arg);
                } else if (is_array($arg)) {
                    $this->Tools->System_Log("Array", __FUNCTION__, __LINE__);
                    $this->MovingRecording("Moving to " . $Function . " With Args Array");
                } else {
                    $this->Tools->System_Log("Unknow Type of arg", __FUNCTION__, __LINE__);
                    $this->MovingRecording("Moving to " . $Function);
                }
            } else {
                $this->Tools->System_Log("Moving to function " . $Function, __FUNCTION__, __LINE__);
                $this->MovingRecording("Moving to " . $Function);
            }
        }
        if (isset($arg)) {
            $this->Tools->System_Log("Call Function With Arg", __FUNCTION__, __LINE__);
            call_user_func(array($Class, $Function), $arg);
        } else {
            $this->Tools->System_Log("Call Function Without Arg", __FUNCTION__, __LINE__);
            call_user_func(array($Class, $Function));
        }
    }

    private function MovingRecording($Message) {
        $Echo = '<b>' . $Message . '</b>' . '<br>';
        if ($this->DebugMode) {
            $this->Tools->Show($Echo);
        }
    }

    public function Buffer($Data) {
        $Array = array();

        if (is_array($Data)) {
            $Array[RETERN] = SUCCESS;
            $Array = array_merge($Array, $Data);
            if ($this->DebugMode) {
                $this->Tools->Show('<b> JSON : </b>');
            }
            if ($this->__isAllow()) {
                $this->Tools->ShowBuffer($Array);
                $this->Tools->System_Log($Array, __FUNCTION__, __LINE__);
            } else {
                $Server = array(SERVER_MESSAGE_NOTE => MessagesSystem(SORRY_FOR_UPDATE));
                $this->Tools->ShowBuffer($Server);
                $this->Tools->System_Log($Server, __FUNCTION__, __LINE__);
            }
        } else {
            if ($this->DebugMode) {
                $this->Tools->Show('<b> JSON : </b>');
            }

            if (strstr($Data, "__")) {
                $Data = str_replace("__", "_:_", $Data);
            }
            if ($this->__isAllow()) {
                $this->Tools->ShowBuffer($Data);
                $this->Tools->System_Log($Data, __FUNCTION__, __LINE__);
            } else {
                $Server = array(SERVER_MESSAGE_NOTE => MessagesSystem(SORRY_FOR_UPDATE));
                $this->Tools->ShowBuffer($Server);
                $this->Tools->System_Log($Server, __FUNCTION__, __LINE__);
            }
        }
        exit();
    }

    private function __isAllow() {
        $IP = $this->Filter->GetIP();
//        $LimetZone = SystemVariable(FILED_SYSTEM_LIMITED_FOR_NETWORK);
        if ((SystemVariable(FILED_SYSTEM_IS_UPDATE)) || (!SystemVariable(FILED_SYSTEM_IS_ONLINE_SERVER))) {
//            if (strstr($IP, $LimetZone)) {
//                return true;
//            } else {
//                return false;
//            }
            return true;
        } else {
            return true;
        }
    }

    private function __destruct() {
        if (!is_null($this->Tools)) {
            $this->Tools->System_Log("Close Session Now " . session_name(), __FUNCTION__, __LINE__);
            unset($GLOBALS[CLASS_TOOLS]);
            unset($this->Tools);
        }

        if (!is_null($this->CommandMain)) {
            unset($this->CommandMain);
        }
        if (!is_null($this->Filter)) {
            unset($this->Filter);
        }
        if (!is_null($this->Server)) {
            unset($this->Server);
        }

        if (!is_null($this->DebugMode)) {
            unset($this->DebugMode);
        }

        if ($this->FunctionArray) {
            unset($this->FunctionArray);
        }

        if ($this->Database) {
            $this->Database->closeConnection();
            unset($GLOBALS['Database']);
            unset($this->Database);
        }

        session_unset();
        exit(0);
    }

}

function PHP_VERSION() {
    if (phpversion() < '5.2') {
        die("Can't Run in this PHP Version " . phpversion() . " must be 5.2 or biger");
        return false;
    } else {
        return true;
    }
}

if (PHP_VERSION()) {
    $Server = new AndroServer();
}

