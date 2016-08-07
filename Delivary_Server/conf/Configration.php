<?php

if (getcwd() == dirname(__FILE__)) {
    require '../System/ErrorPage.php';
    die(ShowError());
}
include_once '../directors.php';
define("GET_PHONE_TYPE_FROM_IMEI", "http://www.imei.info/?imei=");
define("DEFUALT_COOKIE", "delivary");
define("DEFUALT_COOKIE_ONLINE", "delivaryonline");

//Application Main Parametar

define("DEBUG", "XDEBUG_SESSION_START"); //=netbeans-xdebug
//Application Switch
define("MAIN_COMMAND_DELIVERY", "type");

define("MAIN_COMMAND_MEDIA", "HTTP_TYPE");

//Defination Globel Class
define("CLASS_DATABASE", "Database");
define("CLASS_TOOLS", "Tools");
define("CLASS_FILTER", "Filter");
define("SYSTEM_DIFINATION", "System");
define("PASSWORD_LENGTH", 7);
define("ACTIVE_LENGTH", 5);

//Files And Dirs
define("BLOCK_DDOS_DIR", MAIN_DIR . DIRECTORY_SEPARATOR . "BDOS");
define("SYSTEM_XML_VAR", MAIN_DIR . "/conf/System.xml");
define("GEOIP_DATA_FILE", MAIN_DIR . "/System/geoip/GeoLiteCity.dat");
define("DATABASE_SCRIPT_PATH", MAIN_DIR . "/Database/delivarydb.sql");

/**
 * GEO LOCATION FILEDS
 */
define("GEO_CONTINENT_CODE", 0x1);
define("GEO_CONTINENTNAME", 0x2);
define("GEO_CONTINENT", 0x3);
define("GEO_COUNTRYCODE2", 0x4);
define("GEO_COUNTRYCODE3", 0x5);
define("GEO_COUNTRYNAME", 0x6);
define("GEO_REGIONNAME", 0x7);
define("GEO_CITYNAME", 0x8);
define("GEO_CITYLATITUDE", 0x9);
define("GEO_CITYLONGITUDE", 0x10);
define("GEO_COUNTRYLATITUDE", 0x11);
define("GEO_COUNTRYLONGITUDE", 0x12);
define("GEO_LOCALTIMEZONE", 0x15);
define("GEO_LOCALTIMEEPOCH", 0x16);


define('DELIVERY_ANDROID_PHONE_CONNECT', 'Android_Phone_Delivery');
define('DELIVERY_TESTING', 'Test_Delivery');

//
//              +--------------+
//              |    Switchs   |
//              +--------------+
//              |_____FILED____+
//              |      KEY     |
//              +--------------+
//              |_____FILED____+
//              |      KEY     |
//              +--------------+

/* ################################################################################*
 * ########################## DATABASE FILEDS AND TABLES ##########################*
 * ################################################################################ */

//Group Database System (1)
define("TABLE_SYSTEM", "Table_System");
define("KEY_TABLE_SYSTEM", "SYSTEM");

define("FILED_SYSTEM_ACTIV", "_ACTIV");
define("KEY_SYSTEM_ACTIV", "_K6SA_");

define("FILED_SYSTEM_VERSION", "_VERSION");
define("KEY_SYSTEM_VERSION", "_K6SV_");

define("FILED_SYSTEM_APPLICATION_NAME", "_APPLICATION_NAME");
define("KEY_SYSTEM_APPLICATION_NAME", "_K6SAN_");

define("FILED_SYSTEM_APPLICATION_PATH_MOBILE", "_APPLICATION_PATH_MOBILE");
define("KEY_SYSTEM_APPLICATION_PATH_MOBILE", "_K6SAPM_");

define("FILED_SYSTEM_SERVER_CURRENT_PATH", "_SERVER_CURRENT_PATH");
define("KEY_SYSTEM_SERVER_CURRENT_PATH", "_K6SSCP_");

define("FILED_SYSTEM_STREAMING_DATA_METHOD", "_STREAMING_DATA_METHOD");
define("KEY_SYSTEM_STREAMING_DATA_METHOD", "_K6SSNP_");

define("FILED_SYSTEM_POWER_BY", "_POWER_BY");
define("KEY_SYSTEM_POWER_BY", "_K6SPB_");

define("FILED_SYSTEM_INCRIMENT_PRICE_AFTER", "_INCRIMENT_PRICE_AFTER");
define("KEY_SYSTEM_INCRIMENT_PRICE_AFTER", "_K6SIPA_");

define("FILED_SYSTEM_INCRIMENT_PRICE", "_INCRIMENT_PRICE");
define("KEY_SYSTEM_INCRIMENT_PRICE", "_K6SIP_");

define("FILED_SYSTEM_LOG_SYSTEM", "_LOG_SYSTEM");
define("KEY_SYSTEM_LOG_SYSTEM", "_K6SLS_");

define("FILED_SYSTEM_CAN_GET_DATA_FROM_BROWSER", "_CAN_GET_DATA_FROM_BROWSER");
define("KEY_SYSTEM_CAN_GET_DATA_FROM_BROWSER", "_K6SCGDFB_");

define("FILED_SYSTEM_IS_UPDATE", "_IS_UPDATE");
define("KEY_SYSTEM_IS_UPDATE", "_K6SIU_");

define("FILED_SYSTEM_IS_ONLINE_SERVER", "_IS_ONLINE_SERVER");
define("KEY_SYSTEM_IS_ONLINE_SERVER", "_K6SIOS_");

define("FILED_SYSTEM_SYSTEM_USER_ID", "_SYSTEM_USER_ID");
define("KEY_SYSTEM_SYSTEM_USER_ID", "_K6SSUI_");

define("FILED_SYSTEM_ENCRIPTION_BUFFER", "_ENCRIPTION_BUFFER");
define("KEY_SYSTEM_ENCRIPTION_BUFFER", "_K6SEB_");

define("FILED_SYSTEM_POINT_PRICE", "_POINT_PRICE");
define("KEY_SYSTEM_POINT_PRICE", "_K6SPP_");

define("FILED_SYSTEM_LIKE_TO_POINT", "_LIKE_TO_POINT");
define("KEY_SYSTEM_LIKE_TO_POINT", "_K6SLTP_");

define("FILED_SYSTEM_NORMAL_SCORE", "_NORMAL_SCORE");
define("KEY_SYSTEM_NORMAL_SCORE", "_K6SNS_");

define("FILED_SYSTEM_VIP_SCORE", "_VIP_SCORE");
define("KEY_SYSTEM_VIP_SCORE", "_K6SVS_");

define("FILED_SYSTEM_MINIMAM_SEND_TO_STOCK", "_MINIMAM_SEND_TO_STOCK");
define("KEY_SYSTEM_MINIMAM_SEND_TO_STOCK", "_K6SMSTS_");

define("FILED_SYSTEM_MAXIMAM_SEND_TO_STOCK", "_MAXIMAM_SEND_TO_STOCK");
define("KEY_SYSTEM_MAXIMAM_SEND_TO_STOCK", "_K6SMASTS_");

define("FILED_SYSTEM_SHOW_UNLIKE", "_SHOW_UNLIKE");
define("KEY_SYSTEM_SHOW_UNLIKE", "_K6SSU_");

define("FILED_SYSTEM_SHOW_LIKE", "_SHOW_LIKE");
define("KEY_SYSTEM_SHOW_LIKE", "_K6SSL_");

define("FILED_SYSTEM_SHOW_TOP_IN_GLOBEL", "_SHOW_TOP_IN_GLOBEL");
define("KEY_SYSTEM_SHOW_TOP_IN_GLOBEL", "_K6SSTIG_");

define("FILED_SYSTEM_SHOW_TOP_IN_ZONE", "_SHOW_TOP_IN_ZONE");
define("KEY_SYSTEM_SHOW_TOP_IN_ZONE", "_K6SSTIZ_");

define("FILED_SYSTEM_SHOW_STOCK_IN_USERS_LIST", "_SHOW_STOCK_IN_USERS_LIST");
define("KEY_SYSTEM_SHOW_STOCK_IN_USERS_LIST", "_K6SSSIUL_");

define("FILED_SYSTEM_SHOW_POINTS_IN_USER_LIST", "_SHOW_POINTS_IN_USER_LIST");
define("KEY_SYSTEM_SHOW_POINTS_IN_USER_LIST", "_K6SSPIUL_");

define("FILED_SYSTEM_LIMITED_FOR_NETWORK", "_LIMITED_FOR_NETWORK");
define("KEY_SYSTEM_LIMITED_FOR_NETWORK", "_K6SLFN_");

define("FILED_SYSTEM_ICON_FOR_VIP", "_ICON_FOR_VIP");
define("KEY_SYSTEM_ICON_FOR_VIP", "_K6SIFV_");

define("FILED_SYSTEM_ICON_FOR_FAMUS", "_ICON_FOR_FAMUS");
define("KEY_SYSTEM_ICON_FOR_FAMUS", "_K6SIFF_");

define("FILED_SYSTEM_ICON_FOR_LEVEL_1", "_ICON_FOR_LEVEL_1");
define("KEY_SYSTEM_ICON_FOR_LEVEL_1", "_K6SIFL1_");

define("FILED_SYSTEM_ICON_FOR_LEVEL_2", "_ICON_FOR_LEVEL_2");
define("KEY_SYSTEM_ICON_FOR_LEVEL_2", "_K6SIFL2_");

define("FILED_SYSTEM_ICON_FOR_LEVEL_3", "_ICON_FOR_LEVEL_3");
define("KEY_SYSTEM_ICON_FOR_LEVEL_3", "_K6SIFL3_");

define("FILED_SYSTEM_ICON_FOR_LEVEL_4", "_ICON_FOR_LEVEL_4");
define("KEY_SYSTEM_ICON_FOR_LEVEL_4", "_K6SIFL4_");

define("FILED_SYSTEM_ICON_FOR_LEVEL_5", "_ICON_FOR_LEVEL_5");
define("KEY_SYSTEM_ICON_FOR_LEVEL_5", "_K6SIFL5_");

define("FILED_SYSTEM_ICON_FOR_LEVEL_6", "_ICON_FOR_LEVEL_6");
define("KEY_SYSTEM_ICON_FOR_LEVEL_6", "_K6SIFL6_");

define("FILED_SYSTEM_VIRESION_SERVICE", "_VIRESION_SERVICE");
define("KEY_SYSTEM_VIRESION_SERVICE", "_K6SVERS_");

define("FILED_SYSTEM_VIRESIONURL_SERVICE", "_VIRESIONURL_SERVICE");
define("KEY_SYSTEM_VIRESIONURL_SERVICE", "_K6SVERURLSER_");

define("FILED_SYSTEM_VIRESION_DELIVARY", "_VIRESION_DELIVARY");
define("KEY_SYSTEM_VIRESION_DELIVARY", "_K6SVERD_");

define("FILED_SYSTEM_VIRESIONURL_DELIVARY", "_VIRESIONURL_DELIVARY");
define("KEY_SYSTEM_VIRESIONURL_DELIVARY", "_K6SVERURLDEL_");

define("FILED_SYSTEM_DATE_TIME", "_DATE_TIME");
define("KEY_SYSTEM_DATE_TIME", "_K6SDT_");

define("FILED_SYSTEM_SWITCH_MAIL", "_SWITCH_MAIL");

define("FILED_SYSTEM_SWITCH_SMS", "_SWITCH_SMS");

define("FILED_SYSTEM_SMS_API_URL", "_SMS_API_URL");

define("FILED_SYSTEM_SMS_AUTH_KEY", "_SMS_AUTH_KEY");

define("FILED_SYSTEM_SMS_SENDER_ID", "_SMS_SENDER_ID");

define("FILED_SYSTEM_SMS_ROUTE", "_SMS_ROUTE");

define("FILED_SYSTEM_SMS_RESPONSE_TYPE", "_SMS_RESPONSE_TYPE");

define("FILED_SYSTEM_SERVER_MAIL", "_SERVER_MAIL");
define("FILED_SYSTEM_SERVER_PHONE", "_SERVER_PHONE");

//System Log Table
define("TABLE_SYSTEM_LOG", "Table_System_Log");
define("FILED_SYSTEM_LOG_DATE", "_DATE_TIME");
define("FILED_SYSTEM_LOG_ACTION", "_ACTION");
define("FILED_SYSTEM_LOG_REQUEST", "_REQUEST");
define("FILED_SYSTEM_LOG_INFO", "_INFO");
define("FILED_SYSTEM_LOG_IP_CLIENT", "_IP_CLIENT");
define("FILED_SYSTEM_LOG_COUNTRY_ID", "_COUNTRY_ID");
define("FILED_SYSTEM_LOG_LEVEL", "_LEVEL");


/* Table Location (1) */
define('TABLE_LOCATION', 'Table_Location');
/* * ********************** */
define('FILED_LOCATION_ID', '_ID');
define('KEY_LOCATION_ID', '_KLID1_');
/* * ********************** */
define('FILED_LOCATION_NAME', '_NAME');
define('KEY_LOCATION_NAME', '_KLN1_');
/* * ********************** */
define('FILED_LOCATION_CODE', '_CODE');
define('KEY_LOCATION_CODE', '_KLC1_');
/* * ********************** */
define('FILED_LOCATION_ISENABLE', '_ISENABLE');
define('KEY_LOCATION_ISENABLE', '_KLIE1_');

/* Table Service (2) */
define('TABLE_SERVICE', 'Table_Service');
/* * ********************** */
define('FILED_SERVICE_ID', '_ID');
define('KEY_SERVICE_ID', '_KSID2_');
/* * ********************** */
define('FILED_SERVICE_NAME', '_NAME');
define('KEY_SERVICE_NAME', '_KSN2_');
/* * ********************** */
define('FILED_SERVICE_LOCATION', '_LOCATION');
define('KEY_SERVICE_LOCATION', '_KSL2_');
/* * ********************** */
define('FILED_SERVICE_ADDRESS', '_ADDRESS');
define('KEY_SERVICE_ADDRESS', '_KSAD2_');
/* * ********************** */
define('FILED_SERVICE_PHONE', '_PHONE');
define('KEY_SERVICE_PHONE', '_KSPN2_');
/* * ********************** */
define('FILED_SERVICE_SERIAL_NUMBER', '_SERIAL_NUMBER');
define('KEY_SERVICE_SERIAL_NUMBER', '_KSSN2_');
/* * ********************** */
define('FILED_SERVICE_PRICE_PARTICIPATION', '_PRICE_PARTICIPATION');
define('KEY_SERVICE_PRICE_PARTICIPATION', '_KSPP2_');
/* * ********************** */
define('FILED_SERVICE_BLOCK', '_BLOCK');
define('KEY_SERVICE_BLOCK', '_KSB2_');
/* * ********************** */
define('FILED_SERVICE_VIRESION', '_VIRESION');
define('KEY_SERVICE_VIRESION', '_KV2_');
/* * ********************** */
define('FILED_SERVICE_VIRESION_URL', '_VIRESIONURL');
define('KEY_SERVICE_VIRESION_URL', '_KVURL2_');
/* * ********************** */
define('FILED_SERVICE_RECORD_DATE', '_RECORD_DATE');
define('KEY_SERVICE_RECORD_DATE', '_KSRD2_');


/* Table Tasks (3) */
define("TABLE_TASKS", 'Table_Tasks');
/* * ********************** */
define('FILED_TASKS_ID', '_ID');
define('KEY_TASKS_ID', '_KTI3_');
/* * ********************** */
define('FILED_TASKS_SERVICE_NAME', '_SERVICE_NAME');
define('KEY_TASKS_SERVICE_NAME', '_KTSN3_');
/* * ********************** */
define('FILED_TASKS_OWNER_ORDER', '_OWNER_ORDER');
define('KEY_TASKS_OWNER_ORDER', '_KTOWNN3_');
/* * ********************** */
define('FILED_TASKS_TASK_START_DATE', '_TASK_START_DATE');
define('KEY_TASKS_TASK_START_DATE', '_KTTSD3_');
/* * ********************** */
define('FILED_TASKS_AMOUT_ORDER', '_AMOUT_ORDER');
define('KEY_TASKS_AMOUT_ORDER', '_KTAO3_');
/* * ********************** */
define('FILED_TASKS_QUANTATY_ORDER', '_QUANTATY_ORDER');
define('KEY_TASKS_QUANTATY_ORDER', '_KTQO3_');
/* * ********************** */
define('FILED_TASKS_RESERVED', '_RESERVED');
define('KEY_TASKS_RESERVED', '_KTRSV3_');
/* * ********************** */
define('FILED_TASKS_TASK_RESERVED_DATE', '_TASK_RESERVED_DATE');
define('KEY_TASKS_TASK_RESERVED_DATE', '_KTTRD3_');
/* * ********************** */
define('FILED_TASKS_TASK_RESERVED_TIME', '_TASK_RESERVED_TIME');
define('KEY_TASKS_TASK_RESERVED_TIME', '_KTTRT3_');
/* * ********************** */
define('FILED_TASKS_OPEN', '_OPEN');
define('KEY_TASKS_OPEN', '_KTOP3_');
/* * ********************** */
define('FILED_TASKS_BOOKING', '_BOOKING');
define('KEY_TASKS_BOOKING', '_KTBOOKING3_');
/* * ********************** */


/* Table Delivary Boy (4) */
define('TABLE_BOYDELIVARY', 'Table_BoyDelivary');
/* * ********************************************* */
define('FILED_BOYDELIVARY_ID', '_ID');
define('KEY_BOYDELIVARY_ID', '_KBD 4_');
/* * ********************************************* */
define('FILED_BOYDELIVARY_NAME', '_NAME');
define('KEY_BOYDELIVARY_NAME', '_KBDN4_');
/* * ********************************************* */
define('FILED_BOYDELIVARY_PHONE_NUMBER', '_PHONE_NUMBER');
define('KEY_BOYDELIVARY_PHONE_NUMBER', '_KBDPN4_');
/* * ********************************************* */
define('FILED_BOYDELIVARY_PHONE_SERIAL_NUMBER', '_PHONE_SERIAL_NUMBER');
define('KEY_BOYDELIVARY_PHONE_SERIAL_NUMBER', '_KBDPSN4_');
/* * ********************************************* */
define('FILED_BOYDELIVARY_ID_NUMBER', '_ID_NUMBER');
define('KEY_BOYDELIVARY_ID_NUMBER', '_KBDIDN4_');
/* * ********************************************* */
define('FILED_BOYDELIVARY_LOCATION', '_LOCATION');
define('KEY_BOYDELIVARY_LOCATION', '_KBDL4_');
/* * ********************************************* */
define('FILED_BOYDELIVARY_MOTOSICAL_NUMBER', '_MOTOSICAL_NUMBER');
define('KEY_BOYDELIVARY_MOTOSICAL_NUMBER', '_KBDMN4_');
/* * ********************************************* */
define('FILED_BOYDELIVARY_POINTS', '_POINTS');
define('KEY_BOYDELIVARY_POINTS', '_KBDPOI4_');
/* * ********************************************* */
define('FILED_BOYDELIVARY_COMMENT', '_COMMENT');
define('KEY_BOYDELIVARY_COMMENT', '_KBDCOM4_');
/* * ********************************************* */
define('FILED_BOYDELIVARY_VIRESION', '_VIRESION');
define('KEY_BOYDELIVARY_VIRESION', '_KBDV4_');
/* * ********************************************* */
define('FILED_BOYDELIVARY_VIRESIONURL', '_VIRESIONURL');
define('KEY_BOYDELIVARY_VIRESIONURL', '_KBDVURL4_');
/* * ********************************************* */
define('FILED_BOYDELIVARY_MOOD', '_MOOD');
define('KEY_BOYDELIVARY_MOOD', '_KBDMOOD4_');
/* * ********************************************* */
define('FILED_BOYDELIVARY_RECORD_DATE', '_RECORD_DATE');
define('KEY_BOYDELIVARY_RECORD_DATE', '_KBDRD4_');

//Table Location (5)
define('TABLE_CURRENTLOCATIONS', 'Table_CurrentLocations');
///*************************/
define('FILED_CURRENTLOCATIONS_ID', '_ID');
define('KEY_CURRENTLOCATIONS_ID', '_KBDCID5_');
///*************************/
define('FILED_CURRENTLOCATIONS_DELIVARY_NAME', '_DELIVARY_NAME');
define('KEY_CURRENTLOCATIONS_DELIVARY_NAME', '_KBDCDN5_');
///*************************/
define('FILED_CURRENTLOCATIONS_DATE', '_DATE');
define('KEY_CURRENTLOCATIONS_DATE', '_KBDCD5_');
///*************************/
define('FILED_CURRENTLOCATIONS_TIME', '_TIME');
define('KEY_CURRENTLOCATIONS_TIME', '_KBDCT5_');
///*************************/
define('FILED_CURRENTLOCATIONS_SERVICE_ORDER_NUMBER', '_SERVICE_ORDER_NUMBER');
define('KEY_CURRENTLOCATIONS_SERVICE_ORDER_NUMBER', '_KBDCSON5_');
///*************************/
define('FILED_CURRENTLOCATIONS_LATITUDE', '_LATITUDE');
define('KEY_CURRENTLOCATIONS_LATITUDE', '_KBDCLLAT5_');
///*************************/
define('FILED_CURRENTLOCATIONS_LONGITUDE', '_LONGITUDE');
define('KEY_CURRENTLOCATIONS_LONGITUDE', '_KBDCLLON5_');
///*************************/
define('FILED_CURRENTLOCATIONS_TIMEGPS', '_TIMEGPS');
define('KEY_CURRENTLOCATIONS_TIMEGPS', '_KBDCTIM5_');
///*************************/
define('FILED_CURRENTLOCATIONS_SPEED', '_SPEED');
define('KEY_CURRENTLOCATIONS_SPEED', '_KBDCSPED5_');
///*************************/
define('FILED_CURRENTLOCATIONS_ADDRESS', '_ADDRESS');
define('KEY_CURRENTLOCATIONS_ADDRESS', '_KBDCADD5_');


//Table Booking (6)

define('TABLE_BOOKING', 'Table_Booking');
///*************************/
define('FILED_BOOKING_ID', '_ID');
define('KEY_BOOKING_ID', '_KBOID6_');
///*************************/
define('FILED_BOOKING_DELIVARY_ID', '_DELIVARY_ID');
define('KEY_BOOKING_DELIVARY_ID', '_KBODID6_');
///*************************/
define('FILED_BOOKING_TASK_ID', '_TASK_ID');
define('KEY_BOOKING_TASK_ID', '_KBOTASKID6_');

//Table SMS Delivary

define('TABLE_SMS_DELIVARY', 'Table_SMS_Delivary');
///*************************/
define('FILED_SMS_DELIVARY_ID', 'ID');
define('FILED_SMS_DELIVARY_UID', '_UID');
define('FILED_SMS_DELIVARY_APIKEY', '_APIKEY');
define('FILED_SMS_DELIVARY_MESSAGE', '_MESSAGE');
define('FILED_SMS_DELIVARY_STATUS', '_STATUS');
define('FILED_SMS_DELIVARY_DATE_TIME', '_DATE_TIME');

//Table SMS Service

define('TABLE_SMS_SERVICE', 'Table_SMS_Service');
///*************************/
define('FILED_SMS_SERVICE_ID', 'ID');
define('FILED_SMS_SERVICE_UID', '_UID');
define('FILED_SMS_SERVICE_APIKEY', '_APIKEY');
define('FILED_SMS_SERVICE_MESSAGE', '_MESSAGE');
define('FILED_SMS_SERVICE_STATUS', '_STATUS');
define('FILED_SMS_SERVICE_DATE_TIME', '_DATE_TIME');

//Table Request SMS Table Delivary
define("Table_SMS_RESEVED_ACTIVE_DELIVARY", "Table_SMS_RESEVED_ACTIVE_DELIVARY");
///*************************/
define("FILED_SMS_RESEVED_DELIVARY_ID", "ID");
define("FILED_SMS_RESEVED_DELIVARY_SMS_ID", "_SMS_ID");
define("FILED_SMS_RESEVED_DELIVARY_CODE", "_CODE");
define("FILED_SMS_RESEVED_DELIVARY_STATUS", "_STATUS");
define("FILED_SMS_RESEVED_DELIVARY_DATE_TIME", "_DATE_TIME");

//Table Request SMS Table Service
define("Table_SMS_RESEVED_ACTIVE_SERVICE", "Table_SMS_RESEVED_ACTIVE_SERVICE");
///*************************/
define("FILED_SMS_RESEVED_SERVICE_ID", "ID");
define("FILED_SMS_RESEVED_SERVICE_SMS_ID", "_SMS_ID");
define("FILED_SMS_RESEVED_SERVICE_CODE", "_CODE");
define("FILED_SMS_RESEVED_SERVICE_STATUS", "_STATUS");
define("FILED_SMS_RESEVED_SERVICE_DATE_TIME", "_DATE_TIME");


//Table Username and Password 
define('TABLE_USERS_ADMINS', 'Table_users_admins');
/*************************/
define('FILED_USERSADMINS_ID', '_id');
/*************************/
define('FILED_USERSADMINS_USERNAME', '_username');
/*************************/
define('FILED_USERSADMINS_PASSWORD', '_password');
/*************************/
define('FILED_USERSADMINS_LASTLOGIN', '_lastlogin');
/*************************/
define('FILED_USERSADMINS_IPADDRESS', '_ipaddress');
/*************************/



///*************************/
//define('FILED_', '');
//define('KEY_', '');
///*************************/
//define('FILED_', '');
//define('KEY_', '');
///*************************/
//define('FILED_', '');
//define('KEY_', '');
///*************************/
//
//
//Results
define("SUCCESS", "_6OK_");
define("FAIL", "_6FI_");
define("RETERN", "_6RET_");
define("RETERN_ZONE", "_6RETZONE_");
define('THIS_USER_IS_OLD', '_6TUIO_');
define("ON", 1);
define("OFF", 0);
define("SERVER_MESSAGE_NOTE", "SMN");
define("EXSIST", "EXS");
define("NOT_EXSIST", "NEXS");
define("USER_BLOCKED", "UIB");
define("NO_TASKS", "NTS");
define("ONLINE", "1");
define("OFFLINE", "0");
//Connection and Testing
define("CONNECTION_ANDROID", "connect");
define("TEST", "__test");

//Servics Group (1)
define('REGESTRATION_NEW_SERVICE', '_DILCNS1_');
define('IS_EXIST_IN_SERVICE', '_DILIEIS1_');
define('CREATE_ORDER', '_DILCRO1_');
define('MY_ORDER_WITH', '_DILMOW1_');
define('GET_OPEN_TASKS', '_DILGOT1_');

//Delivary Functions
define('REGESTRATION_DELIVARY', '_DILRGDELVI1_');
define('GET_INFORMATION_DELIVARYBOY', '_DELGIDB1_');
define('SET_MODE', '_DELSMOD1_');
define('UPDATE_LOCATION', '_DILCLOCATION1_');
define('GET_FEED', '_DILGFEED1_');
define('GET_POINTS', '_DILGPOINTS1_');
define('BOOKING_TASK', '_DILBOOKTASK1_');
define('NOT_BOOKING_TASK', '_DILNOBOOKTASK1_');



//Information Gothering Group (2)
define('GET_INFORMATION', '_DILSIF2_');
define('ISINDATABASE', '_DILGIF2_');
define('ISINDATABASE_DELIVARY', '_DILGIFD2_');
define('GET_COVER_ZONE', '_DILGCZ2_');

//Application Information About Provider Service Group (3)
define('PHONE_SERIAL_NUMBER', '_DILPSN3_');
define('SERVICE_NAME', '_DILSN3_');
define('SERVICE_LOCATION', '_DILSL3_');
define('SERVICE_PHONE_NUMBER', '_DILSPN3_');

//Application Information About Boy Delivery Group (4)
define('BOYDELIVERY_NAME', '_DILN4_');
define('BOYDELIVERY_MOTOR_NUMBER', '_DILMN4_');
define('BOYDELIVERY_LOCATION', '_DILL4_');
define('BOYDELIVERY_LOCATION_NOW', '_DILLN4_');
define('BOYDELIVERY_PHONE_NUMBER', '_DILPN4_');
define('BOYDELIVERY_PHONE_SERIAL', '_DILPS4_');
define('BOYDELIVERY_ID_NUMBER', '_DILIDN4_');






/* * **************************
 * Function Main Declaration*
 * ************************** */
define('SERVICE_DELIVERY', 'service_delivery');
define('INFORMATION_GOTHERING', 'Information_gothering');
define('PROVIDER_SERVICE', 'provider_service');
define('BOYDELIVERY_INFORMATION', 'boydelivery_information');

/* * ************************
 * Server Messages
 * ************************ */
define('WELCOME_MESSAGE_IN_STATUS', 'status_message');
define('SERVER_ERROR_TITEL_MESSAGE', 'error_titel_message');
define('SERVER_ERROR_MESSAGE', 'error_message');
define('SERVER_ERROR_NUMBER', 'error_number');
define('SORRY_FOR_UPDATE', 'update_message');
define("SERVER_REPAIR_TITEL_MESSAGE", "server_repair_message");
define("SERVER_REPAIR_MESSAGE", "server_update_message");
define("YOU_HAVE_A_NEW_MESSAGE", "YHNM");
define("NEW_MESSAGE", "NM");
define("NEW_FRIEND", "NFRI");
define("LABEL_USER_COMMENT", "label_user_comment");
define("ACTIVE_CODE", "active_code");
define("ERROR_MESSAGE", "error_message");
define("INVITATION", "invitation");
/* * *****************************************************************************
 * *****************************************************************************
 * *****************************************************************************
 * *****************************************************************************
 * ***************************************************************************** */

function Configration() {
    $db = array();
    /* Data Entered
      ================================
      Database: redroot_delivarydb
      Username: redroot_redroot
      Password: trinitron
     */

    $db['host'] = 'localhost';
    $db['port'] = 3306;
    $db['user'] = 'root';
//    $db['user'] = 'redroot_redroot';
    $db['pass'] = 'trinitron';
    $db['db'] = 'delivarydb';
    //$db['db'] = 'redroot_delivarydb';
    return $db;
}

function GetFunctionsDelivery() {
    $MainFinction = array(
        DELIVERY_ANDROID_PHONE_CONNECT => array(
            CONNECTION_ANDROID
        ),
        DELIVERY_TESTING => array(
            TEST
        ),
        SERVICE_DELIVERY => array(
            REGESTRATION_NEW_SERVICE
        ),
        INFORMATION_GOTHERING => array(
            GET_INFORMATION, GET_COVER_ZONE, ISINDATABASE
        ),
        PROVIDER_SERVICE => array(
            CREATE_ORDER, MY_ORDER_WITH, GET_OPEN_TASKS
        ),
        BOYDELIVERY_INFORMATION => array(
            ISINDATABASE_DELIVARY, REGESTRATION_DELIVARY, SET_MODE, UPDATE_LOCATION, GET_INFORMATION_DELIVARYBOY,
            GET_FEED, GET_POINTS, BOOKING_TASK, NOT_BOOKING_TASK
        )
    );
    return $MainFinction;
}

function SystemVariable($Var) {
    $File = SYSTEM_XML_VAR;
    if (file_exists($File)) {
        $dom = new DOMDocument();
        $dom->load($File);
        $dom->formatOutput = true;
        $x = $dom->documentElement;
        foreach ($x->childNodes AS $item) {
            if (strstr($item->nodeName, $Var)) {
                return $item->nodeValue;
            }
        }
        return false;
    } else {
        $Need = null;
        require_once MAIN_DIR . '/Database/SQLClass.php';
        $Configration = Configration();
        $Database = new SQLClass($Configration['db'], $Configration['user'], $Configration['pass']);
        if (!is_null($Data = $Database->select(TABLE_SYSTEM, array(FILED_SYSTEM_ACTIV => ON)))) {
            $doc = new DOMDocument('1.0');
            $doc->formatOutput = true;
            $root = $doc->createElement('system');
            $root = $doc->appendChild($root);
            foreach ($Data as $Key => $Value) {
                $title = $doc->createElement($Key);
                $title = $root->appendChild($title);

                $text = $doc->createTextNode($Value);
                $text = $title->appendChild($text);
                if (strstr($Key, $Var)) {
                    $Need = $Value;
                }
            }
            $doc->save(SYSTEM_XML_VAR);
            $Database->closeConnection();
            unset($Database);
            unset($doc);
            unset($dom);

            return (!empty($Need) ? $Need : false);
        }
    }
}

function MessagesSystem($Message) {
    $MessgeArray = array(
        WELCOME_MESSAGE_IN_STATUS => "I am " . SystemVariable(FILED_SYSTEM_APPLICATION_NAME) . "Now :)",
        SERVER_ERROR_TITEL_MESSAGE => "404 Page Not Found",
        SERVER_ERROR_MESSAGE => "Page Not Found",
        SERVER_ERROR_NUMBER => "404",
        SORRY_FOR_UPDATE => "We Are Sorry But Server in Uptodate Please try later",
        SERVER_REPAIR_TITEL_MESSAGE => "Server is Repair",
        SERVER_REPAIR_MESSAGE => "We are sorry but server in update",
        YOU_HAVE_A_NEW_MESSAGE => "%s You Have a New Message",
        NEW_MESSAGE => "New Message From %s",
        NEW_FRIEND => "%s want to be your friend",
        LABEL_USER_COMMENT => "User %s comment on your photo.",
        ACTIVE_CODE => "Welcome to SuperWoW... Active Code : %s.Your Password: %s.",
        ERROR_MESSAGE => "Error : %s",
        INVITATION => "Your Friend %s is Invitation you to be friend in " .
        SystemVariable(FILED_SYSTEM_APPLICATION_NAME) . " URL: " .
        SystemVariable(FILED_SYSTEM_APPLICATION_PATH_MOBILE) . "."
    );
    return $MessgeArray[$Message];
}
