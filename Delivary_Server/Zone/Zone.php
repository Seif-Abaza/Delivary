<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Zone
 *
 * @author root
 */
class Zone {

    public function Get_Zone() {
        $Data = array(FILED_LOCATION_ISENABLE => 1);
        $DataZone = $GLOBALS[CLASS_DATABASE]->select(TABLE_LOCATION, $Data, '', '', false, 'AND', FILED_LOCATION_ID . ' , ' . FILED_LOCATION_NAME);
        if (!is_null($DataZone)) {
            return array(RETERN_ZONE => $DataZone);
        } else {
            return array(RETERN => FAIL);
        }
    }

}
