CREATE DATABASE IF NOT EXISTS `delivarydb` DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
USE `delivarydb`;


CREATE TABLE IF NOT EXISTS `Table_users_admins` (
  `_id` int(11) NOT NULL AUTO_INCREMENT,
  `_username` text COLLATE utf8_bin NOT NULL,
  `_password` text COLLATE utf8_bin NOT NULL,
  `_lastlogin` datetime NOT NULL,
  `_ipaddress` text COLLATE utf8_bin NOT NULL,
PRIMARY KEY (`_id`)
);
-- --------------------------------------------------------

--
-- Table structure for table `Table_Location`
--

CREATE TABLE IF NOT EXISTS `Table_Location` (
  `_ID` int(11) NOT NULL AUTO_INCREMENT,
  `_NAME` text CHARACTER SET utf8 NOT NULL,
  `_CODE` int(11) NOT NULL,
  `_ISENABLE` tinyint(1) NOT NULL,
PRIMARY KEY (`_ID`)
);
-- --------------------------------------------------------

CREATE TABLE `Table_Booking` (
  `_ID` int(11) NOT NULL AUTO_INCREMENT,
  `_DELIVARY_ID` int(11) NOT NULL,
  `_TASK_ID` int(11) NOT NULL,
  `_DATE` datetime NOT NULL,
PRIMARY KEY (`_ID`)
);

-- --------------------------------------------------------

--
-- Table structure for table `Table_Service`
--

CREATE TABLE IF NOT EXISTS `Table_Service` (
  `_ID` int(11) NOT NULL AUTO_INCREMENT,
  `_NAME` varchar(200) CHARACTER SET utf8 NOT NULL,
  `_LOCATION` int(11) NOT NULL,
  `_ADDRESS` text NOT NULL,
  `_PHONE` text NOT NULL,
  `_SERIAL_NUMBER` varchar(17) NOT NULL,
  `_PRICE_PARTICIPATION` text NOT NULL,
  `_BLOCK` tinyint(1) NOT NULL,
  `_VIRESION` int(11) NOT NULL,
  `_VIRESIONURL` varchar(1000) COLLATE utf8_bin NOT NULL,
  `_RECORD_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`_ID`),
FOREIGN KEY (`_LOCATION`) REFERENCES Table_Location(`_ID`)
);
-- --------------------------------------------------------

--
-- Table structure for table `Table_BoyDelivary`
--

CREATE TABLE IF NOT EXISTS `Table_BoyDelivary` (
  `_ID` int(11) NOT NULL AUTO_INCREMENT,
  `_NAME` varchar(100) CHARACTER SET utf8 NOT NULL,
  `_PHONE_NUMBER` text NOT NULL,
  `_PHONE_SERIAL_NUMBER` varchar(17) NOT NULL,
  `_ID_NUMBER` varchar(20) NOT NULL,
  `_LOCATION` int(11) NOT NULL,
  `_MOTOSICAL_NUMBER` text NOT NULL,
  `_POINTS` int(11) NOT NULL,
  `_COMMENT` varchar(3000) NOT NULL,
  `_VIRESION` int(11) NOT NULL,
  `_VIRESIONURL` varchar(1000) COLLATE utf8_bin NOT NULL,
  `_MOOD` BOOLEAN NOT NULL,
  `_RECORD_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`_ID`),
FOREIGN KEY (`_LOCATION`) REFERENCES Table_Location(`_ID`)
);

-- --------------------------------------------------------

--
-- Table structure for table `Table_Tasks`
--

CREATE TABLE IF NOT EXISTS `Table_Tasks` (
  `_ID` int(11) NOT NULL AUTO_INCREMENT,
  `_SERVICE_NAME` int(11) NOT NULL,
  `_OWNER_ORDER` varchar(3000) NOT NULL,
  `_TASK_START_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `_AMOUT_ORDER` int(11) NOT NULL,
  `_QUANTATY_ORDER` int(11) NOT NULL,
  `_RESERVED` int(11) NOT NULL,
  `_TASK_RESERVED_DATE` date NOT NULL,
  `_TASK_RESERVED_TIME` time NOT NULL,
  `_OPEN` tinyint(1) NOT NULL,
PRIMARY KEY (`_ID`),
FOREIGN KEY (`_SERVICE_NAME`) REFERENCES Table_Service(`_ID`)
);

-- --------------------------------------------------------

--
-- Table structure for table `Table_CurrentLocations`
--
-- For know where is the Delivary location after reseved order
CREATE TABLE IF NOT EXISTS `Table_CurrentLocations` (
  `_ID` int(11) NOT NULL AUTO_INCREMENT, 
  `_DELIVARY_NAME` int(11) NOT NULL,
  `_DATE` date NOT NULL,
  `_TIME` time NOT NULL,
  `_SERVICE_ORDER_NUMBER` int(11) NOT NULL,
  `_LATITUDE` int(11) NOT NULL,
  `_LONGITUDE` int(11) NOT NULL,
  `_TIMEGPS` int(11) NOT NULL,
  `_SPEED` int(11) NOT NULL,
  `_ADDRESS` varchar(9000) NOT NULL,
PRIMARY KEY (`_ID`),
FOREIGN KEY (`_DELIVARY_NAME`) REFERENCES Table_BoyDelivary(`_ID`)
);

-- --------------------------------------------------------

--
-- Table structure for table `Table_POS_Delivary`
--

CREATE TABLE IF NOT EXISTS `Table_POS_Delivary` (
  `_ID` int(11) NOT NULL AUTO_INCREMENT,
  `_USER` int(11) NOT NULL,
  `_SERVIC_NAME` int(11) NOT NULL,
  `_ORDER` int(11) NOT NULL,
  `_ORDER_DATE` date NOT NULL,
  `_ORDER_SERVIC` int(11) NOT NULL,
  `_TOTAL_FOR_DELIVERY` int(11) NOT NULL,
  `_TOTAL_FOR_COM_DELIVERY` int(11) NOT NULL,
  `_RECORD_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`_ID`),
FOREIGN KEY (`_USER`) REFERENCES Table_BoyDelivary(`_ID`),
FOREIGN KEY (`_SERVIC_NAME`) REFERENCES Table_Service(`_ID`)
);

-- --------------------------------------------------------

--
-- Table structure for table `Table_POS_Service`
--

CREATE TABLE IF NOT EXISTS `Table_POS_Service` (
  `_ID` int(11) NOT NULL AUTO_INCREMENT, 
  `_USER` int(11) NOT NULL,
  `_INSURANCE` int(11) NOT NULL,
  `_PARTICIPATION` tinyint(1) NOT NULL,
  `_DATE` date NOT NULL,
  `_DELAYED` tinyint(1) NOT NULL,
  `_PARTICIPATION_DELAYED` int(11) NOT NULL,
  `_ALLOWING` int(11) NOT NULL,
  `_RECORD_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`_ID`),
FOREIGN KEY (`_USER`) REFERENCES Table_Service(`_ID`)
);

-- --------------------------------------------------------

--
-- Table structure for table `Table_System`
--

CREATE TABLE IF NOT EXISTS `Table_System` (
  `ID` int(11) NOT NULL ,
  `_ACTIV` bit(1) NOT NULL DEFAULT b'1',
  `_VERSION` text NOT NULL,
  `_APPLICATION_NAME` text NOT NULL,
  `_APPLICATION_PATH_MOBILE` text NOT NULL,
  `_SERVER_CURRENT_PATH` text NOT NULL,
  `_SERVER_NEW_PATH` text NOT NULL,
  `_POWER_BY` text NOT NULL,
  `_SERVER_MAIL` text NOT NULL,
  `_INCRIMENT_PRICE_AFTER` int(11) NOT NULL,
  `_INCRIMENT_PRICE` int(11) NOT NULL,
  `_LOG_SYSTEM` bit(1) NOT NULL DEFAULT b'1',
  `_CAN_GET_DATA_FROM_BROWSER` bit(1) NOT NULL DEFAULT b'1',
  `_IS_UPDATE` bit(1) NOT NULL DEFAULT b'0',
  `_IS_ONLINE_SERVER` bit(1) NOT NULL DEFAULT b'0',
  `_SYSTEM_USER_ID` int(11) NOT NULL DEFAULT '0',
  `_ENCRIPTION_BUFFER` bit(1) NOT NULL DEFAULT b'0',
  `_POINT_PRICE` float NOT NULL DEFAULT '0.14',
  `_LIKE_TO_POINT` int(11) NOT NULL DEFAULT '50',
  `_NORMAL_SCORE` int(11) NOT NULL DEFAULT '0',
  `_VIP_SCORE` int(11) NOT NULL DEFAULT '50',
  `_MINIMAM_SEND_TO_STOCK` int(11) NOT NULL DEFAULT '1',
  `_MAXIMAM_SEND_TO_STOCK` int(11) NOT NULL DEFAULT '1000000',
  `_SHOW_UNLIKE` bit(1) NOT NULL DEFAULT b'1',
  `_SHOW_LIKE` bit(1) NOT NULL DEFAULT b'1',
  `_SHOW_TOP_IN_GLOBEL` bit(1) NOT NULL DEFAULT b'0',
  `_SHOW_TOP_IN_ZONE` bit(1) NOT NULL DEFAULT b'1',
  `_SHOW_STOCK_IN_USERS_LIST` bit(1) NOT NULL DEFAULT b'0',
  `_SHOW_POINTS_IN_USER_LIST` bit(1) NOT NULL DEFAULT b'0',
  `_LIMITED_FOR_NETWORK` text NOT NULL,
  `_ICON_FOR_VIP` text NOT NULL,
  `_ICON_FOR_FAMUS` text NOT NULL,
  `_ICON_FOR_LEVEL_1` text NOT NULL,
  `_ICON_FOR_LEVEL_2` text NOT NULL,
  `_ICON_FOR_LEVEL_3` text NOT NULL,
  `_ICON_FOR_LEVEL_4` text NOT NULL,
  `_ICON_FOR_LEVEL_5` text NOT NULL,
  `_ICON_FOR_LEVEL_6` text NOT NULL,
  `_SWITCH_MAIL` tinyint(1) NOT NULL,
  `_SWITCH_SMS` tinyint(1) NOT NULL,
  `_SMS_API_URL` text NOT NULL,
  `_SMS_AUTH_KEY` text NOT NULL,
  `_SMS_SENDER_ID` text NOT NULL,
  `_SMS_ROUTE` text NOT NULL,
  `_SMS_RESPONSE_TYPE` text NOT NULL,
  `_VIRESION_SERVICE` int(11) NOT NULL,
  `_VIRESIONURL_SERVICE` varchar(1000) COLLATE utf8_bin NOT NULL,
  `_VIRESION_DELIVARY` int(11) NOT NULL,
  `_VIRESIONURL_DELIVARY` varchar(1000) COLLATE utf8_bin NOT NULL,
  `_DATE_TIME` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `Table_SMS_Delivary` (
    `ID` int(11) NOT NULL AUTO_INCREMENT,
    `_UID` int(11) NOT NULL,
    `_APIKEY` text NOT NULL,
    `_MESSAGE` text NOT NULL,
    `_STATUS` tinyint(4) NOT NULL,
    `_DATE_TIME` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`ID`),
    FOREIGN KEY (`_UID`) REFERENCES Table_BoyDelivary(`_ID`)
);

CREATE TABLE IF NOT EXISTS `Table_SMS_Service` (
    `ID` int(11) NOT NULL AUTO_INCREMENT,
    `_UID` int(11) NOT NULL,
    `_APIKEY` text NOT NULL,
    `_MESSAGE` text NOT NULL,
    `_STATUS` tinyint(4) NOT NULL,
    `_DATE_TIME` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`ID`),
    FOREIGN KEY (`_UID`) REFERENCES Table_Service(`_ID`)
);

CREATE TABLE IF NOT EXISTS `Table_SMS_RESEVED_ACTIVE_DELIVARY` (
    `ID` int(11) NOT NULL AUTO_INCREMENT,
    `_SMS_ID` int(11) NOT NULL,
    `_CODE` text NOT NULL,
    `_STATUS` text NOT NULL,
    `_DATE_TIME` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`ID`),
    FOREIGN KEY (`_SMS_ID`) REFERENCES Table_SMS_Delivary(`ID`)
);

CREATE TABLE IF NOT EXISTS `Table_SMS_RESEVED_ACTIVE_SERVICE` (
    `ID` int(11) NOT NULL AUTO_INCREMENT,
    `_SMS_ID` int(11) NOT NULL,
    `_CODE` text NOT NULL,
    `_STATUS` text NOT NULL,
    `_DATE_TIME` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`ID`),
    FOREIGN KEY (`_SMS_ID`) REFERENCES Table_SMS_Service(`ID`)
);

--
-- Table structure for table `Table_System_Log`
--

CREATE TABLE IF NOT EXISTS `Table_System_Log` (
  `ID` int(11) NOT NULL ,
  `_DATE_TIME` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `_ACTION` text NOT NULL,
  `_REQUEST` varchar(9000) NOT NULL,
  `_INFO` varchar(9000) NOT NULL,
  `_IP_CLIENT` text NOT NULL,
  `_COUNTRY_ID` int(11) DEFAULT NULL,
  `_LEVEL` text NOT NULL
);



