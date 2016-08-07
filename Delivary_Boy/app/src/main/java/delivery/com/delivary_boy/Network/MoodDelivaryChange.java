package delivery.com.delivary_boy.Network;

import android.app.ProgressDialog;
import android.content.Context;
import android.os.AsyncTask;

import java.util.HashMap;

import delivery.com.delivary_boy.Dashbord;
import delivery.com.delivary_boy.R;

/**
 * Created by root on 13.07.16.
 */
public class MoodDelivaryChange extends AsyncTask<String, String, String> {
    Context contxt = null;
    ProgressDialog dialog = null;
    Dashbord mainpage = null;
    boolean onoroff;

    public MoodDelivaryChange(Context context, Dashbord m) {
        this.contxt = context;
        this.mainpage = m;
        dialog = new ProgressDialog(this.contxt);
    }

    @Override
    protected String doInBackground(String... params) {
        HashMap<String, String> Map = new HashMap<>();
        String Function = params[0];
        Map.put(params[1], params[2]);
        Map.put(globalvar.KEY_BOYDELIVARY_PHONE_SERIAL_NUMBER, params[3].toString());
        if (params[2].equals(globalvar.ONLINE)) {
            onoroff = true;
        } else if (params[2].equals(globalvar.OFFLINE)) {
            onoroff = false;
        }
        return new ConnectionServer().Server(Function, Map, globalvar.RESULT);
    }

    @Override
    protected void onPreExecute() {
        this.dialog.setMessage(this.contxt.getResources().getString(R.string.dilogWait));
        this.dialog.show();
    }

    @Override
    protected void onPostExecute(String result) {
        String JSONString = result;
        if ((!JSONString.isEmpty()) || (JSONString.length() > 0) || (JSONString != null)) {
            if(dialog != null) {
                if (dialog.isShowing()) {
                    dialog.dismiss();
                }
            }
            if ((JSONString.equals(globalvar.SUCCESS)) && (this.mainpage != null)) {
                if (onoroff) {
                    this.mainpage.OnlineButtons();
                    this.mainpage.Start_UpdateLocation();
                } else {
                    this.mainpage.OfflineButtons();
                    this.mainpage.Stop_UpdateLocation();
                }
            }
        }
    }
}
