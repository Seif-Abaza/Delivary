package delivery.com.delivary_boy.Network;

import android.os.AsyncTask;
import android.support.v4.widget.SwipeRefreshLayout;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;

import delivery.com.delivary_boy.MainActivity;

/**
 * Created by root on 24.07.16.
 */
public class GetUpDate extends AsyncTask<String, Void, String> {
    private SwipeRefreshLayout swipeRefreshLayout = null;
    private MainActivity MA = null;

    public GetUpDate(MainActivity mainActivity, SwipeRefreshLayout SRL) {
        if (SRL != null) {
            this.swipeRefreshLayout = SRL;
        }
        this.MA = mainActivity;
    }

    @Override
    protected void onPostExecute(String result) {
        String JSONString = result;
        if (swipeRefreshLayout != null) {
            swipeRefreshLayout.setRefreshing(false);
        }
        if ((!JSONString.isEmpty()) || (JSONString.length() > 0) || (JSONString != null)) {
            try {
                JSONObject Json = new JSONObject(JSONString);
                this.MA.parseJsonFeed(Json);
            } catch (JSONException e) {
                e.printStackTrace();
            }
        }
    }

    @Override
    protected void onPreExecute() {
        if (swipeRefreshLayout != null) {
            swipeRefreshLayout.setRefreshing(true);
        }
    }

    @Override
    protected String doInBackground(String... params) {
        HashMap<String, String> Key = new HashMap<String, String>();
        Key.put(globalvar.KEY_BOYDELIVARY_PHONE_SERIAL_NUMBER, params[0]);
        return new ConnectionServer().Server(globalvar.GET_FEED, Key, null);
    }
}
