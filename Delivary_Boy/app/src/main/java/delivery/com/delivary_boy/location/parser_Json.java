package delivery.com.delivary_boy.location;

import android.os.AsyncTask;
import android.util.Log;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;

/**
 * Created by root on 13.07.16.
 */
public class parser_Json extends AsyncTask<String, JSONObject, JSONObject> {
    protected JSONObject jObject = null;

    public JSONObject ResultGet() {
        return this.jObject;
    }

    @Override
    protected JSONObject doInBackground(String... params) {
        String url = params[0];
        // initialize
        InputStream is = null;
        String result = "";


        // http post
        try {
            URL surl = new URL(url);
            HttpURLConnection httpclient = (HttpURLConnection) surl.openConnection();
            httpclient.setRequestMethod("GET");
            httpclient.setRequestProperty("Content-length", "0");
            httpclient.setInstanceFollowRedirects(false);
            httpclient.setUseCaches(false);
            httpclient.setAllowUserInteraction(false);
            httpclient.setConnectTimeout(30000);
            httpclient.setReadTimeout(30000);
            httpclient.connect();

            BufferedReader br = new BufferedReader(new InputStreamReader(httpclient.getInputStream()));
            StringBuilder sb = new StringBuilder();
            String line;
            while ((line = br.readLine()) != null) {
                sb.append(line + "\n");
            }
            br.close();
            result = sb.toString();

        } catch (Exception e) {
            Log.e("log_tag", "Error in http connection " + e.toString());
        }
        // try parse the string to a JSON object
        try {
            jObject = new JSONObject(result);
        } catch (JSONException e) {
            Log.e("log_tag", "Error parsing data " + e.toString());
        }

        return jObject;
    }
}