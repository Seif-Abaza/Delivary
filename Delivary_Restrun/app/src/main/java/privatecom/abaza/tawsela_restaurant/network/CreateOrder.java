package privatecom.abaza.tawsela_restaurant.network;

import android.app.ProgressDialog;
import android.content.Context;
import android.os.AsyncTask;

import java.util.HashMap;
import java.util.Map;
import java.util.Timer;
import java.util.TimerTask;

import privatecom.abaza.tawsela_restaurant.R;

/**
 * Created by root on 05.07.16.
 */
public class CreateOrder extends AsyncTask<String, Void, String> {
    Context Activ = null;
    ProgressDialog dialog = null;
    ConnectionServer MyServer = null;

    public CreateOrder(Context context) {
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
                dialog.setMessage(this.Activ.getResources().getString(R.string.msgAssoon));
                dialog.show();
                TimerTask timerTask = new TimerTask() {
                    @Override
                    public void run() {
                        dialog.dismiss();
                    }
                };
                Timer timer = new Timer(true);
                timer.schedule(timerTask, 2000);

            } else if (JSONString.equals(globalvar.FAILURE)) {
                dialog.setMessage(this.Activ.getResources().getText(R.string.msgUnknow));
                dialog.show();
                TimerTask timerTask = new TimerTask() {
                    @Override
                    public void run() {
                        dialog.dismiss();
                    }
                };
                Timer timer = new Timer(true);
                timer.schedule(timerTask, 2000);
            }
        } else {
            dialog.setMessage(this.Activ.getResources().getText(R.string.msgUnknow));
            dialog.show();
            TimerTask timerTask = new TimerTask() {
                @Override
                public void run() {
                    dialog.dismiss();
                }
            };
            Timer timer = new Timer(true);
            timer.schedule(timerTask, 2000);
        }
    }

    @Override
    protected String doInBackground(String... strings) {
        Map<String, String> MyPrameter = new HashMap<String, String>();
        String IMSI = strings[0];
        String Owner = strings[1];
        String Amount = strings[2];
        String Quantati = strings[3];

        MyPrameter.put(globalvar.KEY_TASKS_SERVICE_NAME, IMSI);
        MyPrameter.put(globalvar.KEY_TASKS_OWNER_NAME, Owner);
        MyPrameter.put(globalvar.KEY_TASKS_AMOUT_ORDER, Amount);
        MyPrameter.put(globalvar.KEY_TASKS_QUANTATY_ORDER, Quantati);


        return MyServer.Server(globalvar.CREATEORDER, MyPrameter, globalvar.RESULT);
    }
}
