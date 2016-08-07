<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of service_provider
 *
 * @author root
 */
class service_provider {

    public function CreateNewServiceProvider() {
        $DataforServic = array(
            FILED_SERVICE_NAME => $GLOBALS[CLASS_FILTER]->FilterData(KEY_SERVICE_NAME),
            FILED_SERVICE_PHONE => $GLOBALS[CLASS_FILTER]->FilterData(KEY_SERVICE_PHONE),
            FILED_SERVICE_LOCATION => $GLOBALS[CLASS_FILTER]->FilterData(KEY_SERVICE_LOCATION),
            FILED_SERVICE_ADDRESS => $GLOBALS[CLASS_FILTER]->FilterData(KEY_SERVICE_ADDRESS),
            FILED_SERVICE_PRICE_PARTICIPATION => $GLOBALS[CLASS_FILTER]->FilterData(KEY_SERVICE_PRICE_PARTICIPATION),
            FILED_SERVICE_SERIAL_NUMBER => $GLOBALS[CLASS_FILTER]->FilterData(KEY_SERVICE_SERIAL_NUMBER),
            FILED_SERVICE_VIRESION => SystemVariable(FILED_SYSTEM_VIRESION_SERVICE),
            FILED_SERVICE_VIRESION_URL => SystemVariable(FILED_SYSTEM_VIRESIONURL_SERVICE),
            FILED_SERVICE_RECORD_DATE => $GLOBALS[CLASS_TOOLS]->NowDateAndTime()
        );

        if ($GLOBALS[CLASS_DATABASE]->isExist(TABLE_SERVICE, array(FILED_SERVICE_SERIAL_NUMBER => $DataforServic[FILED_SERVICE_SERIAL_NUMBER]))) {
            return array(RETERN => THIS_USER_IS_OLD);
        }

        if ($GLOBALS[CLASS_DATABASE]->insert(TABLE_SERVICE, $DataforServic)) {
            return array(RETERN => SUCCESS);
        } else {
            return array(RETERN => FAIL);
        }
    }

    public function IsInDatabase() {
        $Data = array(
            FILED_SERVICE_SERIAL_NUMBER => $GLOBALS[CLASS_FILTER]->FilterData(KEY_SERVICE_SERIAL_NUMBER)
        );

        if ($GLOBALS[CLASS_DATABASE]->isExist(TABLE_SERVICE, $Data)) {
            return array(RETERN => EXSIST);
        } else {
            return array(RETERN => NOT_EXSIST);
        }
    }

    public function GetServiceInfo() {
        $Fileds = FILED_SERVICE_BLOCK . ' , ' . FILED_SERVICE_NAME . ' , ' . FILED_SERVICE_PRICE_PARTICIPATION .
                ' , ' . FILED_SERVICE_VIRESION . ' , ' . FILED_SERVICE_VIRESION_URL;
        $Data = array(
            FILED_SERVICE_SERIAL_NUMBER => $GLOBALS[CLASS_FILTER]->FilterData(KEY_SERVICE_SERIAL_NUMBER),
            FILED_SERVICE_BLOCK => 0
        );

        $ServiceInfo = $GLOBALS[CLASS_DATABASE]->select(TABLE_SERVICE, $Data, '', '', false, 'AND', $Fileds);
        if (is_array($ServiceInfo)) {
            return $ServiceInfo;
        } else {
            return array(RETERN => USER_BLOCKED);
        }
    }

}
