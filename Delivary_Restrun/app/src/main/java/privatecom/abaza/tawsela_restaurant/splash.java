package privatecom.abaza.tawsela_restaurant;

import android.content.Context;
import android.content.Intent;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.telephony.TelephonyManager;

import com.avast.android.dialogs.fragment.SimpleDialogFragment;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;

import privatecom.abaza.tawsela_restaurant.network.ConnectionServer;
import privatecom.abaza.tawsela_restaurant.network.UpdateApp;
import privatecom.abaza.tawsela_restaurant.network.ZoneFileds;
import privatecom.abaza.tawsela_restaurant.network.globalvar;

/**
 * Created by root on 28.06.16.
 */
public class splash extends AppCompatActivity {
    // Splash screen timer
    String VersionURL, NewViresion;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.spleash);
        ConnectivityManager connMgr = (ConnectivityManager) getSystemService(splash.this.CONNECTIVITY_SERVICE);
        NetworkInfo networkInfo = connMgr.getActiveNetworkInfo();
        if (networkInfo != null && networkInfo.isConnected()) {
            //Download Informations
            new PrefetchData().execute();
        } else {
            //TODO: display error
            SimpleDialogFragment.createBuilder(this, getSupportFragmentManager())
                    .setMessage(getResources().getString(R.string.msgNoNetwork))
                    .setTitle(getResources().getString(R.string.titError))
                    .show();
        }
    }


    private class PrefetchData extends AsyncTask<Void, Void, Void> {
        ConnectionServer MyServer = null;
        String ServicePrice;
        ArrayList<String> worldlist = null;
        ArrayList<ZoneFileds> world = null;
        TelephonyManager TeleManger = null;
        boolean NewUserOrNot;
        String ServiceName = "";

        @Override
        protected void onPreExecute() {
            this.MyServer = new ConnectionServer();
            if (this.MyServer == null) {
                SimpleDialogFragment.createBuilder(splash.this, getSupportFragmentManager())
                        .setMessage(getResources().getString(R.string.msgUnknow))
                        .setTitle(getResources().getString(R.string.titError))
                        .show();
            }
            TeleManger = (TelephonyManager) getSystemService(Context.TELEPHONY_SERVICE);
            world = new ArrayList<>();
            worldlist = new ArrayList<>();
        }

        @Override
        protected void onPostExecute(Void aVoid) {
            if (NewUserOrNot) {
                Intent i = new Intent(splash.this, regestration.class);
                i.putStringArrayListExtra("CONTRY", worldlist);
                i.putExtra("IMSI", TeleManger.getDeviceId());
                startActivity(i);
                finish();
            } else {
                if (ServiceName.isEmpty()) {
                    SimpleDialogFragment.createBuilder(splash.this, getSupportFragmentManager())
                            .setMessage(getResources().getString(R.string.msgUnknow))
                            .setTitle(getResources().getString(R.string.titError))
                            .show();
                } else {
                    Intent x = new Intent(splash.this, MainActivity.class);
                    x.putExtra("IMSI", TeleManger.getDeviceId());
                    x.putExtra("ServicePrice", ServicePrice);
                    startActivity(x);
                    finish();
                }
            }
        }

        @Override
        protected Void doInBackground(Void... voids) {
            String SJosm;
            JSONObject jsonobject;
            JSONArray jsonarray;
            HashMap<String, String> MyParameter = new HashMap<>();

            try {
                String PhoneSerial = TeleManger.getDeviceId();
                MyParameter.put(globalvar.KEY_SERVICE_SERIAL_NUMBER, PhoneSerial);
                SJosm = this.MyServer.Server(globalvar.ISINDATABASE, MyParameter, null);
                jsonobject = new JSONObject(SJosm);
                String Result = jsonobject.getString(globalvar.RESULT);
                //Parsing JSON To Know if it Exist or not
                if (Result.equals(globalvar.EXSIST)) {
                    SJosm = this.MyServer.Server(globalvar.GET_INFORMATION, MyParameter, null);
                    jsonobject = new JSONObject(SJosm);
                    ServiceName = jsonobject.getString(globalvar.FILED_SERVICE_NAME);
                    ServicePrice = jsonobject.getString(globalvar.FILED_SERVICE_PRICE_PARTICIPATION);
                    NewViresion = jsonobject.getString(globalvar.FILED_SERVICE_VIRESION);
                    VersionURL = jsonobject.getString(globalvar.FILED_SERVICE_VIRESION_URL);

                    //TODO:Message you must Update
                    if (!NewViresion.equals(globalvar.VERSTION)) {
                        UpdateApp atualizaApp = new UpdateApp();
                        atualizaApp.setContext(splash.this);
                        atualizaApp.execute(globalvar.SERVER_URL_UPDATE + VersionURL);
                    }

                    int Block = jsonobject.getInt(globalvar.FILED_SERVICE_BLOCK);
                    if (Block == 1) {
                        SimpleDialogFragment.createBuilder(splash.this, getSupportFragmentManager())
                                .setMessage(getResources().getString(R.string.msgBlock))
                                .setTitle(getResources().getString(R.string.titError))
                                .show();
                        return null;
                    }
                    NewUserOrNot = false;
                } else if (Result.equals(globalvar.NOT_EXSIST)) {
                    SJosm = this.MyServer.Server(globalvar.GET_COVER_ZONE, null, null);
                    jsonobject = new JSONObject(SJosm);
                    jsonarray = jsonobject.getJSONArray(globalvar.RESULT_ZONE);
                    for (int i = 0; i < jsonarray.length(); i++) {
                        jsonobject = jsonarray.getJSONObject(i);
                        ZoneFileds worldpop = new ZoneFileds();
                        worldpop.setID(jsonobject.optInt(globalvar.FILED_LOCATION_ID));
                        worldpop.setName(jsonobject.optString(globalvar.FILED_LOCATION_NAME));
                        world.add(worldpop);
                        // Populate spinner with country names
                        worldlist.add(jsonobject.optString(globalvar.FILED_LOCATION_NAME));
                    }
                    NewUserOrNot = true;

                }
            } catch (JSONException e) {
                NewUserOrNot = true;
            } catch (NullPointerException e) {
                NewUserOrNot = true;
            } catch (Exception e) {
                NewUserOrNot = true;
            }
            return null;
        }
    }


}
