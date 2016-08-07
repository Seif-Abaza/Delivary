<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Regestration
 *
 * @author root
 */
class Regestration {

    public function DelivaryBoy_Regestration() {
        /* Application Need
         * Name
         * Phone Number
         * Serial Number
         * Location Zone
         * Location GPS
         * ID Number
         * Motor Number
         * 
         * (( Automatic ))
         * Version number & URL
         * Record Date
         * Point
         * Comment */
        $isExitinDB = array(
            FILED_BOYDELIVARY_PHONE_SERIAL_NUMBER => $GLOBALS[CLASS_FILTER]->FilterData(KEY_BOYDELIVARY_PHONE_SERIAL_NUMBER)
        );

        if ($GLOBALS[CLASS_DATABASE]->isExist(TABLE_BOYDELIVARY, $isExitinDB)) {
            return array(RETERN => FAIL);
        }

        $SMSService = new SMS();

        $tmp = array(
            FILED_BOYDELIVARY_NAME => $GLOBALS[CLASS_FILTER]->FilterData(KEY_BOYDELIVARY_NAME),
            FILED_BOYDELIVARY_PHONE_NUMBER => $GLOBALS[CLASS_FILTER]->FilterData(KEY_BOYDELIVARY_PHONE_NUMBER),
            FILED_BOYDELIVARY_PHONE_SERIAL_NUMBER => $GLOBALS[CLASS_FILTER]->FilterData(KEY_BOYDELIVARY_PHONE_SERIAL_NUMBER),
            FILED_BOYDELIVARY_LOCATION => $GLOBALS[CLASS_FILTER]->FilterData(KEY_BOYDELIVARY_LOCATION),
            FILED_BOYDELIVARY_ID_NUMBER => $GLOBALS[CLASS_FILTER]->FilterData(KEY_BOYDELIVARY_ID_NUMBER),
            FILED_BOYDELIVARY_MOTOSICAL_NUMBER => $GLOBALS[CLASS_FILTER]->FilterData(KEY_BOYDELIVARY_MOTOSICAL_NUMBER),
            FILED_BOYDELIVARY_VIRESION => SystemVariable(FILED_SYSTEM_VIRESION_DELIVARY),
            FILED_BOYDELIVARY_VIRESIONURL => SystemVariable(FILED_SYSTEM_VIRESIONURL_DELIVARY),
            FILED_BOYDELIVARY_POINTS => 0,
            FILED_BOYDELIVARY_MOOD => 1,
            FILED_BOYDELIVARY_RECORD_DATE => $GLOBALS[CLASS_TOOLS]->NowDateAndTime()
        );

        $Data = $GLOBALS[CLASS_TOOLS]->removeNull($tmp);

        if ($GLOBALS[CLASS_DATABASE]->insert(TABLE_BOYDELIVARY, $Data)) {
            if (SystemVariable(FILED_SYSTEM_SWITCH_SMS) == 1) {
                $UserID = $GLOBALS[CLASS_DATABASE]->lastInsertID();
                $SMSService->SendSMS_Delivary($UserID);
            }
            return array(RETERN => SUCCESS);
        } else {
            return array(RETERN => FAIL);
        }
    }

}
