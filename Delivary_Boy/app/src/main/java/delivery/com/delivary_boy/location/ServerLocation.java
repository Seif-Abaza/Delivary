package delivery.com.delivary_boy.location;

import android.os.AsyncTask;

import java.util.HashMap;

import delivery.com.delivary_boy.Network.ConnectionServer;
import delivery.com.delivary_boy.Network.globalvar;

/**
 * Created by root on 12.07.16.
 */
public class ServerLocation extends AsyncTask<Void, Void, Void> {
    HashMap<String, String> LOCATION = null;

    public ServerLocation(HashMap<String, String> location) {
        this.LOCATION = location;
    }

    @Override
    protected Void doInBackground(Void... params) {
        ConnectionServer Serv = new ConnectionServer();
        Serv.Server(globalvar.UPDATE_LOCATION, this.LOCATION, null);
        return null;
    }
}
