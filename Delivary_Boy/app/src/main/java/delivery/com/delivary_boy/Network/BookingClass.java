package delivery.com.delivary_boy.Network;

import android.content.Context;
import android.os.AsyncTask;
import android.telephony.TelephonyManager;

import java.util.HashMap;

/**
 * Created by root on 19.07.16.
 */
public class BookingClass extends AsyncTask<String, Void, Void> {
    private ConnectionServer Server = null;
    private Context pconContext = null;
    private TelephonyManager TeleManger = null;

    public BookingClass(Context context) {
        this.Server = new ConnectionServer();
        this.pconContext = context;
        this.TeleManger = (TelephonyManager) this.pconContext.getSystemService(Context.TELEPHONY_SERVICE);
    }

    @Override
    protected void onPostExecute(Void aVoid) {
        super.onPostExecute(aVoid);
    }

    @Override
    protected Void doInBackground(String... params) {
        String IDOrder = params[0];
        String SerialNumber = this.TeleManger.getDeviceId();
        HashMap<String, String> Map = new HashMap<>();

        Map.put(globalvar.KEY_BOOKING_DELIVARY_ID, SerialNumber);
        Map.put(globalvar.KEY_BOOKING_TASK_ID, IDOrder);

        this.Server.Server(globalvar.BOOKING_TASK, Map, null);
        return null;
    }
}
