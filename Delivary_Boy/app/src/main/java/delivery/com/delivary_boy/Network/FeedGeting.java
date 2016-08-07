package delivery.com.delivary_boy.Network;

import android.app.ProgressDialog;
import android.content.Context;
import android.os.AsyncTask;

import java.util.HashMap;

import delivery.com.delivary_boy.Dashbord;
import delivery.com.delivary_boy.R;

/**
 * Created by root on 14.07.16.
 */
public class FeedGeting extends AsyncTask<String, Void, String> {
    Context contxt = null;
    ProgressDialog dialog = null;
    Dashbord mainpage = null;

    public FeedGeting(Dashbord mainpord, Context context) {
        this.mainpage = mainpord;
        this.contxt = context;
        if (this.contxt != null) {
            dialog = new ProgressDialog(this.contxt);
        } else {
            this.dialog = null;
        }

    }

    @Override
    protected void onPreExecute() {
        if (this.dialog != null) {
            this.dialog.setMessage(this.contxt.getResources().getString(R.string.dilogWait));
            this.dialog.show();
        }
    }

    @Override
    protected void onPostExecute(String result) {
        String JSONString = result;
        if ((!JSONString.isEmpty()) || (JSONString.length() > 0) || (JSONString != null)) {
            if (this.dialog != null) {
                if (dialog.isShowing()) {
                    dialog.dismiss();
                }
            }
            this.mainpage.StartFeedView(JSONString);
        }
    }

    @Override
    protected String doInBackground(String... params) {
        HashMap<String, String> Key = new HashMap<String, String>();
        Key.put(globalvar.KEY_BOYDELIVARY_PHONE_SERIAL_NUMBER, params[0]);
        return new ConnectionServer().Server(globalvar.GET_FEED, Key, null);
    }
}
