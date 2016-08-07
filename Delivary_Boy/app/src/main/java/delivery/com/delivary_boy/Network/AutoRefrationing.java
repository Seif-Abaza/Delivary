package delivery.com.delivary_boy.Network;

import java.util.TimerTask;

import delivery.com.delivary_boy.MainActivity;

/**
 * Created by root on 24.07.16.
 */
public class AutoRefrationing extends TimerTask {
    String SerialNumber;
    MainActivity activityMain;

    public AutoRefrationing(String sn, MainActivity mainActivity) {
        this.SerialNumber = sn;
        this.activityMain = mainActivity;
    }

    @Override
    public void run() {
        new GetUpDate(this.activityMain, null).execute(this.SerialNumber);
    }
}
