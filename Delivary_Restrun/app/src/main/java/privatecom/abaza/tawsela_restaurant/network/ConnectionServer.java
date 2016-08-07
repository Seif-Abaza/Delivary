package privatecom.abaza.tawsela_restaurant.network;

import android.net.Uri;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.UnsupportedEncodingException;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLDecoder;
import java.util.Map;


/**
 * Created by root on 03.07.16.
 */
public class ConnectionServer {
    private boolean DebugFlagOpen = false;
    private HttpURLConnection con = null;

    public String Server(String Function, Map<String, String> Parameters, String Retern_Need) {
        try {
            String sur = buildURI(Function, Parameters);
            URL surl = new URL(sur);
            if (surl != null) {
                con = (HttpURLConnection) surl.openConnection();
                con.setRequestMethod("GET");
                con.setRequestProperty("Content-length", "0");
                con.setRequestProperty("Accept-Charset", "UTF-8");
                con.setInstanceFollowRedirects(false);
                con.setUseCaches(false);
                con.setAllowUserInteraction(false);
                con.setConnectTimeout(50000);
                con.setReadTimeout(50000);
                con.connect();
                int status = con.getResponseCode();
                switch (status) {
                    case 200:
                    case 201:
                        BufferedReader br = new BufferedReader(new InputStreamReader(con.getInputStream()));
                        StringBuilder sb = new StringBuilder();
                        String line;
                        while ((line = br.readLine()) != null) {
                            sb.append(line + "\n");
                        }
                        br.close();
                        String JSONString = sb.toString();
                        if ((!JSONString.isEmpty()) || (JSONString.length() > 0) || (JSONString != null)) {
                            try {
                                JSONObject jsonObject = new JSONObject(JSONString);
                                if (Retern_Need != null) {
                                    String quiry = jsonObject.getString(Retern_Need);
                                    if (quiry.length() > 0) {
                                        return quiry;
                                    } else {
                                        return null;
                                    }
                                } else {
                                    return jsonObject.toString();
                                }

                            } catch (JSONException e) {
                                return null;
                            }
                        }
                }
            }

            return null;
        } catch (IOException e) {
            return null;
        } catch (NullPointerException e) {
            return null;
        } finally {
            if (con != null) {
                try {
                    con.disconnect();
                } catch (Exception ex) {
                    return null;
                }
            }
        }
    }

    public String buildURI(String Function, Map<String, String> params) {
        try {
            if (params != null) {
                if (DebugFlagOpen) {
                    params.put(globalvar.KEY_DebugFlag, globalvar.VALUE_DebugFlag);
                }
                String url = globalvar.SERVER_URL + "?" + globalvar.TYPE_COMMEND + "=" + Function;

                Uri.Builder builder = Uri.parse(url).buildUpon();
                for (String key : params.keySet()) {
                    String decodedString = null;
                    decodedString = URLDecoder.decode(params.get(key), "UTF-8");
                    builder.appendQueryParameter(key, decodedString);
                }
                return builder.build().toString();
            } else {
                return new String(globalvar.SERVER_URL + "?" + globalvar.TYPE_COMMEND + "=" + Function);
            }
        } catch (UnsupportedEncodingException e) {
            e.printStackTrace();
            return null;
        }
    }
}

