package privatecom.abaza.tawsela_restaurant.network;

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


    //Delivary Application Command
    public static String GET_INFORMATION = "_DILSIF2_";
    public static String ISINDATABASE = "_DILGIF2_";
    public static String GET_COVER_ZONE = "_DILGCZ2_";
    public static String REGESTRATION = "_DILCNS1_";
    public static String CREATEORDER = "_DILCRO1_";
    public static String MY_ORDER_WITH = "_DILMOW1_";
    public static String GET_OPEN_TASKS = "_DILGOT1_";

    //Delivary Fileds [[[ KEY TABLES ]]]

    //TABLE SERVICE
    public static String FILED_SERVICE_NAME = "_NAME";
    public static String KEY_SERVICE_NAME = "_KSN2_";
    /* * ********************** */
    public static String FILED_SERVICE_LOCATION = "_LOCATION";
    public static String KEY_SERVICE_LOCATION = "_KSL2_";
    /* * ********************** */
    public static String FILED_SERVICE_ADDRESS = "_ADDRESS";
    public static String KEY_SERVICE_ADDRESS = "_KSAD2_";
    /* * ********************** */
    public static String FILED_SERVICE_PHONE = "_PHONE";
    public static String KEY_SERVICE_PHONE = "_KSPN2_";
    /* * ********************** */
    public static String FILED_SERVICE_SERIAL_NUMBER = "_SERIAL_NUMBER";
    public static String KEY_SERVICE_SERIAL_NUMBER = "_KSSN2_";
    /* * ********************** */
    public static String FILED_SERVICE_PRICE_PARTICIPATION = "_PRICE_PARTICIPATION";
    public static String KEY_SERVICE_PRICE_PARTICIPATION = "_KSPP2_";
    /* * ********************** */
    public static String FILED_SERVICE_BLOCK = "_BLOCK";
    public static String KEY_SERVICE_BLOCK = "_KSB2_";
    /* * ********************** */
    public static String FILED_SERVICE_VIRESION = "_VIRESION";
    public static String KEY_SERVICE_VIRESION = "_KV2_";
    /* * ********************** */
    public static String FILED_SERVICE_VIRESION_URL = "_VIRESIONURL";
    public static String KEY_SERVICE_VIRESION_URL = "_KVURL2_";


    //TABLE LOCATION
    public static String FILED_LOCATION_ID = "_ID";
    public static String KEY_LOCATION_ID = "_KLID1_";
    /* * ********************** */
    public static String FILED_LOCATION_NAME = "_NAME";
    public static String KEY_LOCATION_NAME = "_KLN1_";
    /* * ********************** */
    public static String FILED_LOCATION_CODE = "_CODE";
    public static String KEY_LOCATION_CODE = "_KLC1_";


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


    public static String KEY_DebugFlag = "XDEBUG_SESSION_START";
    public static String VALUE_DebugFlag = "netbeans-xdebug";

}
