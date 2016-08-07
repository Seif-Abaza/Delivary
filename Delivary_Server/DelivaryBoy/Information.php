<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Information
 *
 * @author root
 */
class Information_Delivary {

    public function is_DelivaryBoy_Exist() {
        $Data = array(
            FILED_BOYDELIVARY_PHONE_SERIAL_NUMBER => $GLOBALS[CLASS_FILTER]->FilterData(KEY_BOYDELIVARY_PHONE_SERIAL_NUMBER)
        );

        if ($GLOBALS[CLASS_DATABASE]->isExist(TABLE_BOYDELIVARY, $Data)) {
            return array(RETERN => EXSIST);
        } else {
            return array(RETERN => NOT_EXSIST);
        }
    }

    public function GetInfoDelivaryBoy() {
        $Data = array(
            FILED_BOYDELIVARY_PHONE_SERIAL_NUMBER => $GLOBALS[CLASS_FILTER]->FilterData(KEY_BOYDELIVARY_PHONE_SERIAL_NUMBER)
        );

        $DataRetern = $GLOBALS[CLASS_DATABASE]->select(TABLE_BOYDELIVARY, $Data);
        if (!is_null($DataRetern)) {
            if (is_array($DataRetern)) {
                return $DataRetern;
            } else {
                return array(RETERN => $DataRetern);
            }
        } else {
            return array(RETERN => FAIL);
        }
    }

    public function BD_Location() {
        //Also You can get Location from this URL it is JSON
        //"http://maps.googleapis.com/maps/api/geocode/json?latlng=" + latitude + "," + longitude + "&sensor=true"
        $Location = array(
            FILED_CURRENTLOCATIONS_LATITUDE => $GLOBALS[CLASS_FILTER]->FilterData(KEY_CURRENTLOCATIONS_LATITUDE),
            FILED_CURRENTLOCATIONS_LONGITUDE => $GLOBALS[CLASS_FILTER]->FilterData(KEY_CURRENTLOCATIONS_LONGITUDE),
            FILED_CURRENTLOCATIONS_TIMEGPS => $GLOBALS[CLASS_FILTER]->FilterData(KEY_CURRENTLOCATIONS_TIMEGPS),
            FILED_CURRENTLOCATIONS_SPEED => $GLOBALS[CLASS_FILTER]->FilterData(KEY_CURRENTLOCATIONS_SPEED),
            FILED_CURRENTLOCATIONS_ADDRESS => $GLOBALS[CLASS_FILTER]->FilterData(KEY_CURRENTLOCATIONS_ADDRESS),
            FILED_CURRENTLOCATIONS_TIME => $GLOBALS[CLASS_TOOLS]->getTime(),
            FILED_CURRENTLOCATIONS_DATE => $GLOBALS[CLASS_TOOLS]->getToday()
        );

        $tmpuser = array(
            FILED_CURRENTLOCATIONS_DELIVARY_NAME => $GLOBALS[CLASS_FILTER]->FilterData(KEY_CURRENTLOCATIONS_DELIVARY_NAME),
            FILED_CURRENTLOCATIONS_SERVICE_ORDER_NUMBER => (is_null($GLOBALS[CLASS_FILTER]->FilterData(KEY_CURRENTLOCATIONS_SERVICE_ORDER_NUMBER)) ? 0 : $GLOBALS[CLASS_FILTER]->FilterData(KEY_CURRENTLOCATIONS_SERVICE_ORDER_NUMBER))
        );

        $User = $GLOBALS[CLASS_TOOLS]->removeNull($tmpuser);

        $ID = $GLOBALS[CLASS_DATABASE]->select(TABLE_BOYDELIVARY, array(FILED_BOYDELIVARY_PHONE_SERIAL_NUMBER => $User[FILED_CURRENTLOCATIONS_DELIVARY_NAME]), '', '', false, 'AND', FILED_BOYDELIVARY_ID);

        $DelvaryID = intval($GLOBALS[CLASS_TOOLS]->getValue(FILED_BOYDELIVARY_ID, $ID));
        if ((!is_null($DelvaryID)) || $DelvaryID != 0) {
            $User = $GLOBALS[CLASS_TOOLS]->ChangeValueInArray(FILED_CURRENTLOCATIONS_DELIVARY_NAME, $DelvaryID, $User);

            $Data = array_merge($Location, $User);

            $OldData = $GLOBALS[CLASS_DATABASE]->select(TABLE_CURRENTLOCATIONS, array(FILED_CURRENTLOCATIONS_DELIVARY_NAME => $User[FILED_CURRENTLOCATIONS_DELIVARY_NAME]));
            if (is_null($OldData)) {
                if ($GLOBALS[CLASS_DATABASE]->insert(TABLE_CURRENTLOCATIONS, $Data)) {
                    return array(RETERN => SUCCESS);
                } else {
                    return array(RETERN => FAIL);
                }
            } else {
                if ($GLOBALS[CLASS_DATABASE]->update(TABLE_CURRENTLOCATIONS, $Data, array(FILED_CURRENTLOCATIONS_DELIVARY_NAME => $User[FILED_CURRENTLOCATIONS_DELIVARY_NAME]))) {
                    return array(RETERN => SUCCESS);
                } else {
                    return array(RETERN => FAIL);
                }
            }
        } else {
            return array(RETERN => FAIL);
        }
    }

    public function ChangeMood() {
        $Where = array(
            FILED_BOYDELIVARY_PHONE_SERIAL_NUMBER => $GLOBALS[CLASS_FILTER]->FilterData(KEY_BOYDELIVARY_PHONE_SERIAL_NUMBER)
        );
        $Data = array(
            FILED_BOYDELIVARY_MOOD => $GLOBALS[CLASS_FILTER]->FilterData(KEY_BOYDELIVARY_MOOD)
        );

        if ($GLOBALS[CLASS_DATABASE]->update(TABLE_BOYDELIVARY, $Data, $Where)) {
            return array(RETERN => SUCCESS);
        } else {
            return array(RETERN => FAIL);
        }
    }

    public function GetFeed() {
        /*
         * Service Name
         * Service Address
         * Service Phone
         * Service Image
         * Task Amount + (FILED_SERVICE_PRICE_PARTICIPATION * Quantaty)
         * Task Quantaty
         * Task Time
         */
        //Delvery
        $DelveryData = array(FILED_BOYDELIVARY_PHONE_SERIAL_NUMBER => $GLOBALS[CLASS_FILTER]->FilterData(KEY_BOYDELIVARY_PHONE_SERIAL_NUMBER));
        $Delvery_Dir = $GLOBALS[CLASS_DATABASE]->select(TABLE_BOYDELIVARY, $DelveryData);
        $DelvaryLocationID = intval($GLOBALS[CLASS_TOOLS]->getValue(FILED_BOYDELIVARY_LOCATION, $Delvery_Dir));

        //Service
        $Service_Dir = $GLOBALS[CLASS_DATABASE]->select(TABLE_SERVICE, array(FILED_SERVICE_LOCATION => $DelvaryLocationID), '', '', false, 'AND', FILED_SERVICE_ID);
        $tmpFeed = array();
        $Feed = array();
        if (is_array($Service_Dir[0])) {
            for ($i = 0; $i <= count($Service_Dir) - 1; $i++) {
                foreach ($Service_Dir[$i] as $Service) {
                    $OrdersID = $GLOBALS[CLASS_DATABASE]->select(TABLE_TASKS, array(FILED_TASKS_SERVICE_NAME => $Service, FILED_TASKS_OPEN => 1));
                    if (is_array($OrdersID[0])) {
                        foreach ($OrdersID as $sub) {
                            if (!is_null($sub)) {
                                array_push($Feed, $sub);
                            }
                        }
                    } else {
                        if (!is_null($OrdersID)) {
                            array_push($Feed, $OrdersID);
                        }
                    }
                }
            }
        } else {
            for ($i = 0; $i <= count($Service_Dir) - 1; $i++) {
                $OrdersID = $GLOBALS[CLASS_DATABASE]->select(TABLE_TASKS, array(FILED_TASKS_SERVICE_NAME => $Service, FILED_TASKS_OPEN => 1));
                if (is_array($OrdersID[0])) {
                    foreach ($OrdersID as $sub) {
                        if (!is_null($sub)) {
                            array_push($Feed, $sub);
                        }
                    }
                } else {
                    if (!is_null($OrdersID)) {
                        array_push($Feed, $OrdersID);
                    }
                }
            }
        }

        $new_array = $GLOBALS[CLASS_TOOLS]->removeNull($Feed);

//        $new_array = $GLOBALS[CLASS_TOOLS]->ToOneArray($tmp);

        $FinalArray = array();
        foreach ($new_array as $element) {
            $ServiceFilter = FILED_SERVICE_ADDRESS . " , " . FILED_SERVICE_PHONE . " , " . FILED_SERVICE_NAME;
            $ID = intval($GLOBALS[CLASS_TOOLS]->getValue(FILED_TASKS_SERVICE_NAME, $element));

            $ServiceCode = $GLOBALS[CLASS_DATABASE]->select(TABLE_SERVICE, array(FILED_SERVICE_ID => $ID), '', '', false, 'AND', $ServiceFilter);

            if (!is_null($ServiceCode)) {
                $Moneytmp = $GLOBALS[CLASS_DATABASE]->select(TABLE_SERVICE, array(FILED_SERVICE_ID => $ID), '', '', false, 'AND', FILED_SERVICE_PRICE_PARTICIPATION);
                $Money = $GLOBALS[CLASS_TOOLS]->getValue(FILED_SERVICE_PRICE_PARTICIPATION, $Moneytmp);

                $Quantaty = $element[FILED_TASKS_QUANTATY_ORDER];
                $Our = intval($Money) * intval($Quantaty);

                $Check = intval($element[FILED_TASKS_AMOUT_ORDER]);
                $Total = $Check + $Our;

                $element = $GLOBALS[CLASS_TOOLS]->ChangeValueInArray(FILED_TASKS_AMOUT_ORDER, $Total, $element);

                $New = $GLOBALS[CLASS_TOOLS]->RemoveKeyInArray(FILED_TASKS_SERVICE_NAME, $element);
                $New = $GLOBALS[CLASS_TOOLS]->RemoveKeyInArray(FILED_TASKS_RESERVED, $New);
                $New = $GLOBALS[CLASS_TOOLS]->RemoveKeyInArray(FILED_TASKS_TASK_RESERVED_DATE, $New);
                $New = $GLOBALS[CLASS_TOOLS]->RemoveKeyInArray(FILED_TASKS_TASK_RESERVED_TIME, $New);
                $New = $GLOBALS[CLASS_TOOLS]->RemoveKeyInArray(FILED_TASKS_OPEN, $New);

                $FinalArray[count($FinalArray) + 1] = array_merge($ServiceCode, $New);
            }
        }
        
        if (is_array($FinalArray)) {
            return array(RETERN => $GLOBALS[CLASS_TOOLS]->Sort_Down_to_Up($FinalArray));
        } else {
            return array(RETERN => NO_TASKS);
        }
    }

    public function getPoints() {

        return array(RETERN => 10);
    }

}
