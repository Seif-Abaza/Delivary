package delivery.com.delivary_boy.Network;

/**
 * Created by root on 01.07.16.
 */
public class globalvar {
    public static final String VERSTION = "2";

    //Message Falgs
    public static final int REQUEST_PROGRESS = 1;
    public static final int REQUEST_LIST_SIMPLE = 9;
    public static final int REQUEST_LIST_MULTIPLE = 10;
    public static final int REQUEST_LIST_SINGLE = 11;
    public static final int REQUEST_DATE_PICKER = 12;
    public static final int REQUEST_TIME_PICKER = 13;
    public static final int REQUEST_SIMPLE_DIALOG = 42;

    //URL Server
    private static String SERVER = "http://betadelivary.heliohost.org/www";
//    private static String SERVER = "http://192.168.0.104/Delivary";
    public static String SERVER_URL = SERVER + "/Interface.php";
    public static String SERVER_URL_UPDATE = SERVER + "/update/";
    //Basic Command
    public static String TYPE_COMMEND = "type";
    public static String RESULT = "_6RET_";
    public static String RESULT_ZONE = "_6RETZONE_";
    public static String SUCCESS = "_6OK_";
    public static String FAILURE = "_6FI_";
    public static String EXSIST = "EXS";
    public static String NOT_EXSIST = "NEXS";
    public static String USER_BLOCKED = "UIB";
    public static String THIS_USER_IS_OLD = "_6TUIO_";
    public static String NO_TASKS = "NTS";
    public static String ONLINE = "1";
    public static String OFFLINE = "0";


    //Delivary Application Command
    public static String GET_INFORMATION_DELIVARYBOY = "_DELGIDB1_";
    public static String ISINDATABASE_DELIVARY = "_DILGIFD2_";
    public static String GET_COVER_ZONE = "_DILGCZ2_";
    public static String REGESTRATION_DELIVARY = "_DILRGDELVI1_";
    public static String UPDATE_LOCATION = "_DILCLOCATION1_";
    public static String SET_MODE = "_DELSMOD1_";
    public static String GET_FEED = "_DILGFEED1_";
    public static String GET_POINTS = "_DILGPOINTS1_";
    public static String BOOKING_TASK = "_DILBOOKTASK1_";

    ///*************************/
    public static String FILED_CURRENTLOCATIONS_ID = "_ID";
    public static String KEY_CURRENTLOCATIONS_ID = "_KBDCID5_";
    ///*************************/
    public static String FILED_CURRENTLOCATIONS_DELIVARY_NAME = "_DELIVARY_NAME";
    public static String KEY_CURRENTLOCATIONS_DELIVARY_NAME = "_KBDCDN5_";
    ///*************************/
    public static String FILED_CURRENTLOCATIONS_DATE = "_DATE";
    public static String KEY_CURRENTLOCATIONS_DATE = "_KBDCD5_";
    ///*************************/
    public static String FILED_CURRENTLOCATIONS_TIME = "_TIME";
    public static String KEY_CURRENTLOCATIONS_TIME = "_KBDCT5_";
    ///*************************/
    public static String FILED_CURRENTLOCATIONS_SERVICE_ORDER_NUMBER = "_SERVICE_ORDER_NUMBER";
    public static String KEY_CURRENTLOCATIONS_SERVICE_ORDER_NUMBER = "_KBDCSON5_";
    ///*************************/
    public static String FILED_CURRENTLOCATIONS_LATITUDE = "_LATITUDE";
    public static String KEY_CURRENTLOCATIONS_LATITUDE = "_KBDCLLAT5_";
    ///*************************/
    public static String FILED_CURRENTLOCATIONS_LONGITUDE = "_LONGITUDE";
    public static String KEY_CURRENTLOCATIONS_LONGITUDE = "_KBDCLLON5_";
    ///*************************/
    public static String FILED_CURRENTLOCATIONS_TIMEGPS = "_TIMEGPS";
    public static String KEY_CURRENTLOCATIONS_TIMEGPS = "_KBDCTIM5_";
    ///*************************/
    public static String FILED_CURRENTLOCATIONS_SPEED = "_SPEED";
    public static String KEY_CURRENTLOCATIONS_SPEED = "_KBDCSPED5_";
    ///*************************/
    public static String FILED_CURRENTLOCATIONS_ADDRESS = "_ADDRESS";
    public static String KEY_CURRENTLOCATIONS_ADDRESS = "_KBDCADD5_";


    //TABLE LOCATION ZONE
    public static String FILED_LOCATION_NAME = "_NAME";

    //Table Service
    public static String FILED_SERVICE_NAME = "_NAME";
    public static String FILED_SERVICE_ADDRESS = "_ADDRESS";
    public static String FILED_SERVICE_PHONE = "_PHONE";
    public static String FILED_SERVICE_PROFILE_INAGE = "_IMAGE";
    //Tasks
    /* * ********************** */
    public static String FILED_TASKS_ID = "_ID";
    public static String KEY_TASKS_ID = "_KTI3_";
    /* * ********************** */
    public static String FILED_TASKS_OWNER_NAME = "_OWNER_ORDER";
    public static String KEY_TASKS_OWNER_NAME = "_KTOWNN3_";
    /* * ********************** */
    public static String FILED_TASKS_SERVICE_NAME = "_SERVICE_NAME";
    public static String KEY_TASKS_SERVICE_NAME = "_KTSN3_";
    /* * ********************** */
    public static String FILED_TASKS_TASK_START_DATE = "_TASK_START_DATE";
    public static String KEY_TASKS_TASK_START_DATE = "_KTTSD3_";
    /* * ********************** */
    public static String FILED_TASKS_AMOUT_ORDER = "_AMOUT_ORDER";
    public static String KEY_TASKS_AMOUT_ORDER = "_KTAO3_";
    /* * ********************** */
    public static String FILED_TASKS_QUANTATY_ORDER = "_QUANTATY_ORDER";
    public static String KEY_TASKS_QUANTATY_ORDER = "_KTQO3_";
    /* * ********************** */
    public static String FILED_TASKS_RESERVED = "_RESERVED";
    public static String KEY_TASKS_RESERVED = "_KTRSV3_";
    /* * ********************** */
    public static String FILED_TASKS_TASK_RESERVED_DATE = "_TASK_RESERVED_DATE";
    public static String KEY_TASKS_TASK_RESERVED_DATE = "_KTTRD3_";
    /* * ********************** */
    public static String FILED_TASKS_TASK_RESERVED_TIME = "_TASK_RESERVED_TIME";
    public static String KEY_TASKS_TASK_RESERVED_TIME = "_KTTRT3_";

    //Delivary Boy Table

    /************************************************/
    public static String FILED_BOYDELIVARY_ID = "_ID";
    public static String KEY_BOYDELIVARY_ID = "_KBD 4_";
    /************************************************/
    public static String FILED_BOYDELIVARY_NAME = "_NAME";
    public static String KEY_BOYDELIVARY_NAME = "_KBDN4_";
    /************************************************/
    public static String FILED_BOYDELIVARY_PHONE_NUMBER = "_PHONE_NUMBER";
    public static String KEY_BOYDELIVARY_PHONE_NUMBER = "_KBDPN4_";
    /************************************************/
    public static String FILED_BOYDELIVARY_PHONE_SERIAL_NUMBER = "_PHONE_SERIAL_NUMBER";
    public static String KEY_BOYDELIVARY_PHONE_SERIAL_NUMBER = "_KBDPSN4_";
    /************************************************/
    public static String FILED_BOYDELIVARY_ID_NUMBER = "_ID_NUMBER";
    public static String KEY_BOYDELIVARY_ID_NUMBER = "_KBDIDN4_";
    /************************************************/
    public static String FILED_BOYDELIVARY_LOCATION = "_LOCATION";
    public static String KEY_BOYDELIVARY_LOCATION = "_KBDL4_";
    /************************************************/
    public static String FILED_BOYDELIVARY_MOTOSICAL_NUMBER = "_MOTOSICAL_NUMBER";
    public static String KEY_BOYDELIVARY_MOTOSICAL_NUMBER = "_KBDMN4_";
    /************************************************/
    public static String FILED_BOYDELIVARY_POINTS = "_POINTS";
    public static String KEY_BOYDELIVARY_POINTS = "_KBDPOI4_";
    /************************************************/
    public static String FILED_BOYDELIVARY_MOOD = "_MOOD";
    public static String KEY_BOYDELIVARY_MOOD = "_KBDMOOD4_";
    /************************************************/
    public static String FILED_BOYDELIVARY_COMMENT = "_COMMENT";
    public static String KEY_BOYDELIVARY_COMMENT = "_KBDCOM4_";
    /************************************************/
    public static String FILED_BOYDELIVARY_VIRESION = "_VIRESION";
    public static String KEY_BOYDELIVARY_VIRESION = "_KBDV4_";
    /************************************************/
    public static String FILED_BOYDELIVARY_VIRESIONURL = "_VIRESIONURL";
    public static String KEY_BOYDELIVARY_VIRESIONURL = "_KBDVURL4_";
    /************************************************/
    public static String FILED_BOYDELIVARY_RECORD_DATE = "_RECORD_DATE";
    public static String KEY_BOYDELIVARY_RECORD_DATE = "_KBDRD4_";

    public static String KEY_DebugFlag = "XDEBUG_SESSION_START";
    public static String VALUE_DebugFlag = "netbeans-xdebug";

    //Booking

    public static String FILED_BOOKING_DELIVARY_ID = "_DELIVARY_ID";
    public static String KEY_BOOKING_DELIVARY_ID = "_KBODID6_";
    /************************************************/
    public static String FILED_BOOKING_TASK_ID = "_TASK_ID";
    public static String KEY_BOOKING_TASK_ID = "_KBOTASKID6_";


}
