<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tasks
 *
 * @author root
 */
class Tasks {

    private function GetServiceID() {
        $Data_SERVICE_NAME = array(
            FILED_SERVICE_SERIAL_NUMBER => $GLOBALS[CLASS_FILTER]->FilterData(KEY_TASKS_SERVICE_NAME)
        );

        return $GLOBALS[CLASS_DATABASE]->select(TABLE_SERVICE, $Data_SERVICE_NAME);
    }

    public function Record_New_Task() {
        $Service_Name = $this->GetServiceID();

        if (!is_null($Service_Name)) {
            $ServiceID = $Service_Name[FILED_SERVICE_ID];

            $TaskData = array(
                FILED_TASKS_SERVICE_NAME => $ServiceID,
                FILED_TASKS_OWNER_ORDER => $GLOBALS[CLASS_FILTER]->FilterData(KEY_TASKS_OWNER_ORDER),
                FILED_TASKS_AMOUT_ORDER => $GLOBALS[CLASS_FILTER]->FilterData(KEY_TASKS_AMOUT_ORDER),
                FILED_TASKS_QUANTATY_ORDER => $GLOBALS[CLASS_FILTER]->FilterData(KEY_TASKS_QUANTATY_ORDER),
                FILED_TASKS_TASK_START_DATE => $GLOBALS[CLASS_TOOLS]->NowDateAndTime(),
                FILED_TASKS_OPEN => 1,
                FILED_TASKS_BOOKING => 1
            );

            if ($GLOBALS[CLASS_DATABASE]->insert(TABLE_TASKS, $TaskData)) {
                return array(RETERN => SUCCESS);
            } else {
                return array(RETERN => FAIL);
            }
        } else {
            return array(RETERN => FAIL);
        }
    }

    public function MyOrderWith() {
        $Service_Name = $this->GetServiceID();

        if (!is_null($Service_Name)) {
            $ServiceID = $Service_Name[FILED_SERVICE_ID];
            $Data = array(
                FILED_TASKS_ID => $GLOBALS[CLASS_FILTER]->FilterData(KEY_TASKS_ID),
                FILED_SERVICE_NAME => $ServiceID);

            $DelivaryNumber = array(
                FILED_TASKS_RESERVED => $GLOBALS[CLASS_FILTER]->FilterData(KEY_TASKS_RESERVED)
            );

            $IsExisDelivaryNumber = array(
                FILED_BOYDELIVARY_ID => $GLOBALS[CLASS_FILTER]->FilterData(KEY_TASKS_RESERVED)
            );

            $Update = array(
                FILED_TASKS_OPEN => 0,
                FILED_TASKS_BOOKING => 0,
                FILED_TASKS_RESERVED => $GLOBALS[CLASS_FILTER]->FilterData(KEY_TASKS_RESERVED),
                FILED_TASKS_TASK_RESERVED_DATE => $GLOBALS[CLASS_TOOLS]->getToday(),
                FILED_TASKS_TASK_RESERVED_TIME => $GLOBALS[CLASS_TOOLS]->getTime());

            if (!$GLOBALS[CLASS_DATABASE]->isExist(TABLE_BOYDELIVARY, $IsExisDelivaryNumber)) {
                return array(RETERN => NOT_EXSIST);
            }

            $TaskOpen = $GLOBALS[CLASS_DATABASE]->select(TABLE_TASKS, array(FILED_TASKS_ID => $Data[FILED_TASKS_ID], FILED_TASKS_OPEN => 1));
            if (!is_null($TaskOpen)) {
                if ($GLOBALS[CLASS_DATABASE]->update(TABLE_TASKS, $Update, array(FILED_TASKS_ID => $Data[FILED_TASKS_ID], FILED_TASKS_OPEN => 1))) {
                    return array(RETERN => SUCCESS);
                } else {
                    return array(RETERN => FAIL);
                }
            } else {
                return array(RETERN => FAIL);
            }
        } else {
            return array(RETERN => FAIL);
        }
    }

    public function Get_All_Tasks() {
        $Service_Name = $Service_Name = $this->GetServiceID();
        if (!is_null($Service_Name)) {
            $ServiceWhere = array(
                FILED_TASKS_SERVICE_NAME => $Service_Name[FILED_SERVICE_ID],
                FILED_TASKS_OPEN => 1
            );

            $Quiry = $GLOBALS[CLASS_DATABASE]->select(TABLE_TASKS, $ServiceWhere, '', '', false, 'AND', FILED_TASKS_ID . ' , ' . FILED_TASKS_OWNER_ORDER . ' , ' . FILED_TASKS_BOOKING);
            if (!is_null($Quiry)) {
                return array(RETERN => $Quiry);
            } else {
                return array(RETERN => NO_TASKS);
            }
        } else {
            return array(RETERN => NO_TASKS);
        }
    }

    public function I_am_Reseved_this_Task() {
        $tmp = array(FILED_BOYDELIVARY_PHONE_SERIAL_NUMBER => $GLOBALS[CLASS_FILTER]->FilterData(KEY_BOOKING_DELIVARY_ID));
        $ID = $GLOBALS[CLASS_DATABASE]->select(TABLE_BOYDELIVARY, $tmp, '', '', false, 'AND', FILED_BOYDELIVARY_ID);
        $OrderID = array(FILED_TASKS_ID => $GLOBALS[CLASS_FILTER]->FilterData(KEY_TASKS_ID));
        $TaskID = $GLOBALS[CLASS_FILTER]->FilterData(KEY_TASKS_ID);
        $Booking = array(
            FILED_BOOKING_DELIVARY_ID => $ID[FILED_BOYDELIVARY_ID],
            FILED_BOOKING_TASK_ID => $TaskID
        );

        if ($GLOBALS[CLASS_DATABASE]->insert(TABLE_BOOKING, $Booking)) {
            if ($GLOBALS[CLASS_DATABASE]->update(TABLE_TASKS, array(FILED_TASKS_BOOKING => 0), $OrderID)) {
                return array(RETERN => SUCCESS);
            } else {
                return array(RETERN => FAIL);
            }
        } else {
            return array(RETERN => FAIL);
        }
    }

    public function I_am_Not_Reseved_this_Task() {
        $tmp = array(FILED_BOYDELIVARY_PHONE_SERIAL_NUMBER => $GLOBALS[CLASS_FILTER]->FilterData(KEY_BOOKING_DELIVARY_ID));
        $ID = $GLOBALS[CLASS_DATABASE]->select(TABLE_BOYDELIVARY, $tmp, '', '', false, 'AND', FILED_BOYDELIVARY_ID);
        $OrderID = array(FILED_TASKS_ID => $GLOBALS[CLASS_FILTER]->FilterData(KEY_TASKS_ID));
        $TaskID = $GLOBALS[CLASS_FILTER]->FilterData(KEY_TASKS_ID);
        $Booking = array(
            FILED_BOOKING_DELIVARY_ID => $ID[FILED_BOYDELIVARY_ID],
            FILED_BOOKING_TASK_ID => $TaskID
        );

        if ($GLOBALS[CLASS_DATABASE]->insert(TABLE_BOOKING, $Booking)) {
            if ($GLOBALS[CLASS_DATABASE]->update(TABLE_TASKS, array(FILED_TASKS_BOOKING => 1), $OrderID)) {
                return array(RETERN => SUCCESS);
            } else {
                return array(RETERN => FAIL);
            }
        } else {
            return array(RETERN => FAIL);
        }
    }

}
