package delivery.com.delivary_boy;

import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.telephony.TelephonyManager;

import com.google.android.gms.appindexing.AppIndex;
import com.google.android.gms.common.api.GoogleApiClient;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;

import delivery.com.delivary_boy.Network.ConnectionServer;
import delivery.com.delivary_boy.Network.UpdateApp;
import delivery.com.delivary_boy.Network.globalvar;


/**
 * Created by root on 07.07.16.
 */
public class Splash extends AppCompatActivity {
    public AlertDialog.Builder alert = null;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.splash);
        alert = new AlertDialog.Builder(getApplicationContext());
        ConnectivityManager connMgr = (ConnectivityManager) getSystemService(Splash.this.CONNECTIVITY_SERVICE);
        NetworkInfo networkInfo = connMgr.getActiveNetworkInfo();
        if (networkInfo != null && networkInfo.isConnected()) {
            // ATTENTION: This was auto-generated to implement the App Indexing API.
            // See https://g.co/AppIndexing/AndroidStudio for more information.
            GoogleApiClient client = new GoogleApiClient.Builder(this).addApi(AppIndex.API).build();
            client.connect();
            new ConnectionToServer().execute();
        } else {
            alert.setTitle(getResources().getString(R.string.msgError));
            alert.setMessage(getResources().getString(R.string.msg));
            alert.setCancelable(false);
            alert.setPositiveButton(getResources().getText(R.string.btnOK), new DialogInterface.OnClickListener() {
                @Override
                public void onClick(DialogInterface dialogInterface, int i) {
                    System.exit(0);
                }
            }).create();
            alert.show();
        }
    }


    private class ConnectionToServer extends AsyncTask<Void, Boolean, Boolean> {
        String Name, Points, Version, VersionURL, Status, Zone, Message_Server, MyCode;
        ConnectionServer MyServer = null;
        ArrayList<String> worldlist = null;
        TelephonyManager TeleManger = null;
        boolean NewUserOrNot;

        @Override
        protected void onPreExecute() {
            this.MyServer = new ConnectionServer();
            if (this.MyServer == null) {
                alert.setTitle(getResources().getString(R.string.msgError));
                alert.setMessage(getResources().getString(R.string.msgCNot_Connect));
                alert.setCancelable(false);
                alert.setPositiveButton(getResources().getString(R.string.btnOK), new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialogInterface, int i) {
                        System.exit(0);
                    }
                }).create();
                alert.show();
            }
            TeleManger = (TelephonyManager) getSystemService(Context.TELEPHONY_SERVICE);
            worldlist = new ArrayList<>();
        }

        @Override
        protected void onPostExecute(Boolean aBoolean) {
            if (aBoolean) {
                if (NewUserOrNot) {
                    Intent i = new Intent(Splash.this, RegestrationPage.class);
                    i.putStringArrayListExtra("CONTRY", worldlist);
                    i.putExtra("IMSI", TeleManger.getDeviceId());
                    startActivity(i);
                    finish();
                } else {
                    //Move to Dashbord
                    Intent dash = new Intent(Splash.this, Dashbord.class);
                    dash.putExtra(globalvar.FILED_BOYDELIVARY_NAME, Name);
                    dash.putExtra(globalvar.FILED_BOYDELIVARY_POINTS, Points);
                    dash.putExtra(globalvar.FILED_BOYDELIVARY_MOOD, Status);
                    dash.putExtra(globalvar.FILED_BOYDELIVARY_LOCATION, Zone);
                    dash.putExtra(globalvar.FILED_BOYDELIVARY_COMMENT, Message_Server);
                    dash.putExtra(globalvar.FILED_BOYDELIVARY_ID, MyCode);
                    dash.putExtra(globalvar.FILED_BOYDELIVARY_PHONE_SERIAL_NUMBER, TeleManger.getDeviceId());
                    startActivity(dash);
                    finish();
                }
            }
        }

        @Override
        protected Boolean doInBackground(Void... voids) {
            String SJosm;
            JSONObject jsonobject;
            JSONArray jsonarray;
            HashMap<String, String> MyParameter = new HashMap<>();
            try {
                String PhoneSerial = TeleManger.getDeviceId();

                MyParameter.put(globalvar.KEY_BOYDELIVARY_PHONE_SERIAL_NUMBER, PhoneSerial);
                SJosm = this.MyServer.Server(globalvar.ISINDATABASE_DELIVARY, MyParameter, null);
                jsonobject = new JSONObject(SJosm);
                String Result = jsonobject.getString(globalvar.RESULT);

                if (Result.equals(globalvar.EXSIST)) {
                    //Get Informations
                    //Name , Points , Version , Status (Online,Offline) , Zone , Message Server
                    SJosm = this.MyServer.Server(globalvar.GET_INFORMATION_DELIVARYBOY, MyParameter, null);
                    jsonobject = new JSONObject(SJosm);
                    Name = jsonobject.getString(globalvar.FILED_BOYDELIVARY_NAME);
                    MyCode = jsonobject.getString(globalvar.FILED_BOYDELIVARY_ID);
                    Points = jsonobject.getString(globalvar.FILED_BOYDELIVARY_POINTS);
                    Version = jsonobject.getString(globalvar.FILED_BOYDELIVARY_VIRESION);
                    VersionURL = jsonobject.getString(globalvar.FILED_BOYDELIVARY_VIRESIONURL);
                    Status = jsonobject.getString(globalvar.FILED_BOYDELIVARY_MOOD);
                    Zone = jsonobject.getString(globalvar.FILED_BOYDELIVARY_LOCATION);
                    if (jsonobject.has(globalvar.FILED_BOYDELIVARY_COMMENT)) {
                        Message_Server = jsonobject.getString(globalvar.FILED_BOYDELIVARY_COMMENT);
                    } else {
                        Message_Server = null;
                    }

                    //Check version
                    if (!Version.equals(globalvar.VERSTION)) {
                        UpdateApp atualizaApp = new UpdateApp();
                        atualizaApp.setContext(Splash.this);
                        atualizaApp.execute(String.format("%s%s", globalvar.SERVER_URL_UPDATE, VersionURL));
                        return false;
                    }

                    //Is On Blocked
                    NewUserOrNot = false;
                } else if (Result.equals(globalvar.NOT_EXSIST)) {
                    SJosm = this.MyServer.Server(globalvar.GET_COVER_ZONE, null, null);
                    jsonobject = new JSONObject(SJosm);
                    jsonarray = jsonobject.getJSONArray(globalvar.RESULT_ZONE);
                    for (int i = 0; i < jsonarray.length(); i++) {
                        jsonobject = jsonarray.getJSONObject(i);
                        worldlist.add(jsonobject.optString(globalvar.FILED_LOCATION_NAME));
                    }
                    NewUserOrNot = true;
                }
                return true;
            } catch (JSONException e) {
                e.printStackTrace();
                return false;
            }

        }
    }
}
