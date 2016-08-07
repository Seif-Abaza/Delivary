<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class core_delivery {

    var $Interface = null;
    var $Buffer = null;
    //Classes
    var $Servic = null;
    var $Zone = null;
    var $Tasks = null;
    var $DelivaryBoyDirs = null;
    var $DelivaryBoyInfo = null;

    public function __construct($Interface) {
        $this->Interface = $Interface;

        if (is_null($this->Servic)) {
            $this->Servic = new service_provider();
        }

        if (is_null($this->Zone)) {
            $this->Zone = new Zone();
        }

        if (is_null($this->Tasks)) {
            $this->Tasks = new Tasks();
        }

        if (is_null($this->DelivaryBoyDirs)) {
            $this->DelivaryBoyDirs = new Regestration();
        }

        if (is_null($this->DelivaryBoyInfo)) {
            $this->DelivaryBoyInfo = new Information_Delivary();
        }
    }

    function __destruct() {
        if (!is_null($this->Buffer)) {
            unset($this->Buffer);
        }
        if (!is_null($this->Interface)) {
            unset($this->Interface);
        }
        if (!is_null($this->Zone)) {
            unset($this->Zone);
        }
        if (!is_null($this->Tasks)) {
            unset($this->Tasks);
        }
    }

    public function Android_Phone_Delivery() {
        $Information = $GLOBALS[CLASS_TOOLS]->Show('<b>' . SystemVariable(FILED_SYSTEM_APPLICATION_NAME) . '</b> Server Version ' . SystemVariable(FILED_SYSTEM_VERSION) . '<br>');
        $this->Interface->Buffer = $Information;
    }

    public function Test_Delivery() {
//        $text = $GLOBALS[CLASS_TOOLS]->Show('<b>' . SystemVariable(FILED_SYSTEM_APPLICATION_NAME) . '</b> Server Version ' . SystemVariable(FILED_SYSTEM_VERSION));
        $Data = array(
            'INFO' => SystemVariable(FILED_SYSTEM_APPLICATION_NAME) . ' Server Version ' . SystemVariable(FILED_SYSTEM_VERSION)
        );
        $this->Interface->Buffer($Data);
    }

    public function service_delivery($Type) {
        if (is_string($Type)) {
            switch ($Type) {
                case REGESTRATION_NEW_SERVICE:
                    $this->Buffer = $this->Servic->CreateNewServiceProvider();
                    break;
                case IS_EXIST_IN_SERVICE:
                    $this->Buffer = $this->Servic->IsInDatabase();
                    break;
            }
        }

        $this->Outdata();
    }

    public function Information_gothering($Type) {
        if (isset($Type)) {
            switch ($Type) {
                case GET_INFORMATION:
                    $this->Buffer = $this->Servic->GetServiceInfo();
                    break;
                case ISINDATABASE:
                    $this->Buffer = $this->Servic->IsInDatabase();
                    break;
                case GET_COVER_ZONE:
                    $this->Buffer = $this->Zone->Get_Zone();
                    break;
            }
        }
        $this->Outdata();
    }

    public function provider_service($Type) {
        switch ($Type) {
            case CREATE_ORDER:
                $this->Buffer = $this->Tasks->Record_New_Task();
                break;
            case MY_ORDER_WITH:
                $this->Buffer = $this->Tasks->MyOrderWith();
                break;
            case GET_OPEN_TASKS:
                $this->Buffer = $this->Tasks->Get_All_Tasks();
                break;
        }
        $this->Outdata();
    }

    public function boydelivery_information($Type) {
        switch ($Type) {
            case ISINDATABASE_DELIVARY:
                $this->Buffer = $this->DelivaryBoyInfo->is_DelivaryBoy_Exist();
                break;
            case REGESTRATION_DELIVARY:
                $this->Buffer = $this->DelivaryBoyDirs->DelivaryBoy_Regestration();
                break;
            case GET_INFORMATION_DELIVARYBOY:
                $this->Buffer = $this->DelivaryBoyInfo->GetInfoDelivaryBoy();
                break;
            case SET_MODE:
                $this->Buffer = $this->DelivaryBoyInfo->ChangeMood();
                break;
            case UPDATE_LOCATION:
                $this->Buffer = $this->DelivaryBoyInfo->BD_Location();
                break;
            case GET_FEED:
                $this->Buffer = $this->DelivaryBoyInfo->GetFeed();
                break;
            case GET_POINTS:
                $this->Buffer = $this->DelivaryBoyInfo->getPoints();
                break;
            case BOOKING_TASK:
                $this->Buffer = $this->Tasks->I_am_Reseved_this_Task();
                break;
            case NOT_BOOKING_TASK:
                $this->Buffer = $this->Tasks->I_am_Not_Reseved_this_Task();
                break;
        }

        $this->Outdata();
    }

    private function Outdata() {
        if ((isset($this->Buffer)) || (!is_null($this->Buffer))) {
            if (is_array($this->Buffer)) {
                $tmp = $this->Buffer;
                $this->Buffer = array();
                $this->Buffer = $GLOBALS[CLASS_TOOLS]->removeNull($tmp);
            }
            $this->Interface->Buffer($this->Buffer);
        } else {
            $this->Interface->Buffer(DONE);
        }
        exit();
    }

}
