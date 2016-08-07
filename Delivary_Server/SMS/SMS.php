<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SMS
 *http://192.168.0.104/Delivary/Interface.php?type=_DILRGDELVI1_&_KBDL4_=1&_KBDPSN4_=000000000000000&_KBDN4_=nrruudd&_KBDMN4_=0000&_KBDIDN4_=00000000000000000000000&_KBDPN4_=%2B79409223858
 * @author abaza
 */
class SMS {

    var $ActivCode = '';
    var $User_ID = 0;

    public function SendSMS_Delivary($ID) {
        if (isset($ID)) {
            $this->User_ID = $ID;
        } else {
            return null;
        }

        $Userdata = $GLOBALS[CLASS_DATABASE]->select(TABLE_BOYDELIVARY, array(FILED_BOYDELIVARY_ID => $this->User_ID));
        if (is_null($Userdata)) {
            return null;
        }

        $Phone = $GLOBALS[CLASS_TOOLS]->getValue(FILED_BOYDELIVARY_PHONE_NUMBER, $Userdata);
        $Username = $GLOBALS[CLASS_TOOLS]->getValue(FILED_BOYDELIVARY_NAME, $Userdata);
        $Points = $GLOBALS[CLASS_TOOLS]->getValue(FILED_BOYDELIVARY_POINTS, $Userdata);
        $servicenumber = SystemVariable(FILED_SYSTEM_SERVER_PHONE);


        $ApplicationName = SystemVariable(FILED_SYSTEM_APPLICATION_NAME);
        $ArabicMessage = "السيد %s مرحبا بك في شركة ديلفري\n"
                . "الرقم الكودي لك هو %s \n"
                . "رصيد النقاط %s نقطة \n"
                . "وفي حالة الإستعلام و الإستفسار الرجاء الإتصال بالرقم %s"
                . " مع تحيات شركة ديلفري.";
        $MessageFinal = sprintf($ArabicMessage, $Username, $ID, $Points, $servicenumber);
        $Message = urlencode($MessageFinal);


//Prepare you post parameters
        $postData = array(
            'authkey' => SystemVariable(FILED_SYSTEM_SMS_AUTH_KEY),
            'mobiles' => $Phone,
            'message' => $Message,
            'sender' => SystemVariable(FILED_SYSTEM_SMS_SENDER_ID),
            'route' => SystemVariable(FILED_SYSTEM_SMS_ROUTE),
            'response' => SystemVariable(FILED_SYSTEM_SMS_RESPONSE_TYPE),
            'unicode' => 1, //unicode=1 (for unicode SMS) or 0 if English
            'campaign' => $ApplicationName //Campaign name you wish to create.
        );

// init the resource
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt_array($ch, array(
            CURLOPT_URL => SystemVariable(FILED_SYSTEM_SMS_API_URL),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData
                //,CURLOPT_FOLLOWLOCATION => true
        ));


//Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


//get response
        $Json = curl_exec($ch); //{"message":"3661676f3237323238393231","type":"success"}

        $Data = array(
            FILED_SMS_DELIVARY_MESSAGE => $Message,
            FILED_SMS_DELIVARY_STATUS => SMS_WAITING,
            FILED_SMS_DELIVARY_APIKEY => $GLOBALS[CLASS_TOOLS]->GenerateApiKey(),
            FILED_SMS_DELIVARY_UID => $this->User_ID
        );

//Print error if any
        if (curl_errno($ch)) {
            return sprintf(MessagesSystem(ERROR_MESSAGE), curl_error($ch));
        }

        curl_close($ch);

        if ($GLOBALS[CLASS_DATABASE]->insert(TABLE_SMS_DELIVARY, $Data)) {

            $SMS_ID = $GLOBALS[CLASS_DATABASE]->lastInsertID();

            if ($this->Implimantation($Json, $SMS_ID)) {
                $this->LogSUCCESS("Done Send SMS Active Code " . print_r($Data, true), __FUNCTION__, __LINE__);
                return true;
            } else {
                $this->LogNOTICE("Can't Send SMS Active Code " . "Parameter : " . print_r($Data, true) . " Respons : " . print_r(json_decode($json), true), __FUNCTION__, __LINE__);
                return false;
            }
        } else {
            $this->LogERROR("MySQL ERROR : " . $GLOBALS[CLASS_DATABASE]->ReturnError(), __FUNCTION__, __LINE__);
            return false;
        }
    }

    private function Implimantation($JSON, $SMS_ID) {
        $Data = array();

        $Data[FILED_SMS_RESEVED_DELIVARY_SMS_ID] = $SMS_ID;

        $Output = json_decode($JSON, true);
        if (is_array($Output)) {
            foreach ($Output as $Key => $Value) {
                if ($Key == 'message') {
                    $Data[FILED_SMS_RESEVED_DELIVARY_CODE] = $Value;
                }
                if ($Key == 'type') {
                    if ($Value == 'success') {
                        $Data[FILED_SMS_RESEVED_DELIVARY_STATUS] = $Value;
                    } else {
                        $Data[FILED_SMS_RESEVED_DELIVARY_STATUS] = $Value;
                    }
                }
            }
        }

        if (count($Data) > 0) {
            return $this->SetSMSHistory($Data);
        } else {
            return false;
        }
    }

    private function SetSMSHistory($Data = null) {
        if (!is_null($Data)) {
            if ($GLOBALS[CLASS_DATABASE]->insert(Table_SMS_RESEVED_ACTIVE_DELIVARY, $Data)) {
                return true;
            } else {
                return false;
            }
        } else {
            return null;
        }
    }

    public function GetSMSHistory($Where = null, $Filed = null) {
        if (!is_null($Where)) {
            $Data = $GLOBALS[CLASS_DATABASE]->select(TABLE_SMS_DELIVARY, $Where, FILED_SMS_DELIVARY_DATE_TIME);
            if (!is_null($Data)) {
                if (!is_null($Filed)) {
                    return $Data[$Filed];
                } else {
                    return $Data;
                }
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    private function LogERROR($Message, $Function, $Line) {
        $GLOBALS[CLASS_TOOLS]->System_Log($Message, __CLASS__ . "::" . $Function, $Line, Tools::ERROR);
    }

    private function LogNOTICE($Message, $Function, $Line) {
        $GLOBALS[CLASS_TOOLS]->System_Log($Message, __CLASS__ . "::" . $Function, $Line, Tools::NOTICE);
    }

    private function LogSUCCESS($Message, $Function, $Line) {
        $GLOBALS[CLASS_TOOLS]->System_Log($Message, __CLASS__ . "::" . $Function, $Line, Tools::SUCCESS);
    }

}
