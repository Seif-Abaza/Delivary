package delivery.com.delivary_boy.Network;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.os.AsyncTask;
import android.support.v7.app.AlertDialog;

import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;
import java.util.HashMap;
import java.util.Map;

import delivery.com.delivary_boy.R;


/**
 * Created by root on 11.07.16.
 */
public class RegestrationClass extends AsyncTask<String, Void, String> {
    Context Activ = null;
    ProgressDialog dialog = null;
    ConnectionServer MyServer = null;

    public RegestrationClass(Context context) {
        this.Activ = context;
        dialog = new ProgressDialog(Activ);
        this.MyServer = new ConnectionServer();
    }

    @Override
    protected void onPreExecute() {
        this.dialog.setMessage(Activ.getResources().getString(R.string.dilogWait));
        this.dialog.show();
    }

    @Override
    protected void onPostExecute(String result) {
        String JSONString = result;
        if ((!JSONString.isEmpty()) || (JSONString.length() > 0) || (JSONString != null)) {
            if (dialog.isShowing()) {
                dialog.dismiss();
            }
            if (JSONString.equals(globalvar.SUCCESS)) {
//                Activ.startActivity(new Intent(Activ, Dashbord.class));
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
    protected String doInBackground(String... strings) {
        Map<String, String> MyPrameter = new HashMap<String, String>();
        String Name = strings[0];
        String PhoneNumber = strings[1];
        String PhoneSerial = strings[2];
        String Location = strings[3];
        String IDNumber = strings[4];
        String MotorNumber = strings[5];

        MyPrameter.put(globalvar.KEY_BOYDELIVARY_NAME, this.Filter(Name));
        MyPrameter.put(globalvar.KEY_BOYDELIVARY_PHONE_NUMBER, this.Filter(PhoneNumber));
        MyPrameter.put(globalvar.KEY_BOYDELIVARY_PHONE_SERIAL_NUMBER, this.Filter(PhoneSerial));
        MyPrameter.put(globalvar.KEY_BOYDELIVARY_LOCATION, this.Filter(Location));
        MyPrameter.put(globalvar.KEY_BOYDELIVARY_ID_NUMBER, this.Filter(IDNumber));
        MyPrameter.put(globalvar.KEY_BOYDELIVARY_MOTOSICAL_NUMBER, this.Filter(MotorNumber));
        return this.MyServer.Server(globalvar.REGESTRATION_DELIVARY, MyPrameter, globalvar.RESULT);
    }

    private String Filter(String s) {
        try {
            return URLEncoder.encode(s, "UTF-8");
        } catch (UnsupportedEncodingException e) {
            return null;
        }
    }
}
