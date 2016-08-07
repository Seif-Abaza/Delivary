package privatecom.abaza.tawsela_restaurant.network;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.os.AsyncTask;
import android.support.v7.app.AlertDialog;

import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;
import java.util.HashMap;
import java.util.Map;

import privatecom.abaza.tawsela_restaurant.R;

/**
 * Created by root on 01.07.16.
 */
public class RegestrationConnect extends AsyncTask<String, Void, String> {
    Context Activ = null;
    ProgressDialog dialog = null;
    ConnectionServer MyServer = null;

    public RegestrationConnect(Context context) {
        this.Activ = context;
        dialog = new ProgressDialog(Activ);
        this.MyServer = new ConnectionServer();
    }

    @Override
    protected void onPostExecute(String result) {
        String JSONString = result;
        if ((!JSONString.isEmpty()) || (JSONString.length() > 0) || (JSONString != null)) {
            if (dialog.isShowing()) {
                dialog.dismiss();
            }
            if (JSONString.equals(globalvar.SUCCESS)) {
                AlertDialog.Builder Dialog = new AlertDialog.Builder(this.Activ);
                Dialog.setTitle(this.Activ.getResources().getString(R.string.titDone));
                Dialog.setMessage(this.Activ.getResources().getString(R.string.msgRegDone));
                Dialog.setPositiveButton(R.string.btnOK, new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        System.exit(0);
                    }
                });
                Dialog.create();
                Dialog.show();
            } else if (JSONString.equals(globalvar.FAILURE)) {
                //TODO: display error
                dialog.setMessage(this.Activ.getResources().getText(R.string.msgFiled));
                dialog.show();
            } else if (JSONString.equals(globalvar.THIS_USER_IS_OLD)) {
                //TODO: display error
                dialog.setMessage(this.Activ.getResources().getString(R.string.msgAlertisUsed));
                dialog.show();
            } else {
                //TODO: display error
                dialog.setMessage(this.Activ.getResources().getText(R.string.msgUnknow));
                dialog.show();
            }
        }

    }

    @Override
    protected void onPreExecute() {
        this.dialog.setMessage(Activ.getResources().getString(R.string.dilogWait));
        this.dialog.show();
    }


    @Override
    protected String doInBackground(String... strings) {
        Map<String, String> MyPrameter = new HashMap<String, String>();
        String ServiceName = strings[0];
        String ServiceLocation = strings[1];
        String PhoneNumber = strings[2];
        String Address = strings[3];
        String Price = strings[4];
        String IMEI = strings[5];
        try {
            MyPrameter.put(globalvar.KEY_SERVICE_NAME, URLEncoder.encode(ServiceName, "UTF-8"));
            MyPrameter.put(globalvar.KEY_SERVICE_LOCATION, URLEncoder.encode(ServiceLocation, "UTF-8"));
            MyPrameter.put(globalvar.KEY_SERVICE_PHONE, URLEncoder.encode(PhoneNumber, "UTF-8"));
            MyPrameter.put(globalvar.KEY_SERVICE_PRICE_PARTICIPATION, URLEncoder.encode(Price, "UTF-8"));
            MyPrameter.put(globalvar.KEY_SERVICE_ADDRESS, URLEncoder.encode(Address, "UTF-8"));
            MyPrameter.put(globalvar.KEY_SERVICE_SERIAL_NUMBER, URLEncoder.encode(IMEI, "UTF-8"));

            return MyServer.Server(globalvar.REGESTRATION, MyPrameter,globalvar.RESULT);
        } catch (UnsupportedEncodingException e) {
            e.printStackTrace();
            return null;
        }
    }
}
