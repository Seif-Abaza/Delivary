package privatecom.abaza.tawsela_restaurant.network;

import android.app.ProgressDialog;
import android.content.Context;
import android.os.AsyncTask;

import java.util.HashMap;
import java.util.Timer;
import java.util.TimerTask;

import privatecom.abaza.tawsela_restaurant.R;

/**
 * Created by root on 05.07.16.
 */
public class RecordDelavary extends AsyncTask<String, Void, String> {
    Context ContextMain = null;
    ProgressDialog dialog = null;
    ConnectionServer MyServer = null;

    public RecordDelavary(Context context) {
        this.ContextMain = context;
        dialog = new ProgressDialog(this.ContextMain);
        this.MyServer = new ConnectionServer();
    }

    @Override
    protected void onPostExecute(String result) {
        String JSONString = result;
        if ((!JSONString.isEmpty()) || (JSONString.length() > 0) || (JSONString != null)) {
            if (dialog.isShowing()) {
                dialog.dismiss();
            }
            dialog.setMessage(this.ContextMain.getResources().getString(R.string.titTrackerisDone));
            dialog.show();
            if (JSONString.equals(globalvar.SUCCESS)) {
                TimerTask timerTask = new TimerTask() {
                    @Override
                    public void run() {
                        if (dialog.isShowing()) {
                            dialog.dismiss();
                        }
                    }
                };
                Timer timer = new Timer(true);
                timer.schedule(timerTask, 3000);
            } else if (JSONString.equals(globalvar.NOT_EXSIST)) {
                dialog.setMessage(this.ContextMain.getResources().getText(R.string.titNotfind));
                dialog.show();
                TimerTask timerTask = new TimerTask() {
                    @Override
                    public void run() {
                        if (dialog.isShowing()) {
                            dialog.dismiss();
                        }
                    }
                };
                Timer timer = new Timer(true);
                timer.schedule(timerTask, 3000);
            } else if (JSONString.equals(globalvar.FAILURE)) {
                dialog.setMessage(this.ContextMain.getResources().getText(R.string.msgUnknow));
                dialog.show();
                TimerTask timerTask = new TimerTask() {
                    @Override
                    public void run() {
                        if (dialog.isShowing()) {
                            dialog.dismiss();
                        }
                    }
                };
                Timer timer = new Timer(true);
                timer.schedule(timerTask, 3000);
            }
        } else {
            dialog.setMessage(this.ContextMain.getResources().getText(R.string.msgUnknow));
            dialog.show();
            TimerTask timerTask = new TimerTask() {
                @Override
                public void run() {
                    if (dialog.isShowing()) {
                        dialog.dismiss();
                    }
                }
            };
            Timer timer = new Timer(true);
            timer.schedule(timerTask, 3000);
        }
    }


    @Override
    protected void onPreExecute() {
        this.dialog.setMessage(ContextMain.getResources().getString(R.string.dilogWait));
        this.dialog.show();
    }

    @Override
    protected String doInBackground(String... params) {
        HashMap<String, String> MyParametars = new HashMap<>();
        String IMSI = params[0];
        String DelavaryNumber = params[1];
        String OrderNumber = params[2];

        MyParametars.put(globalvar.KEY_TASKS_SERVICE_NAME, IMSI);
        MyParametars.put(globalvar.KEY_TASKS_ID, OrderNumber);
        MyParametars.put(globalvar.KEY_TASKS_RESERVED, DelavaryNumber);


        return this.MyServer.Server(globalvar.MY_ORDER_WITH, MyParametars, globalvar.RESULT);
    }
}
