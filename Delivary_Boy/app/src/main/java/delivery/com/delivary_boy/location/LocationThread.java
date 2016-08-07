package delivery.com.delivary_boy.location;


import android.content.Context;
import android.os.Handler;

import java.util.HashMap;

import delivery.com.delivary_boy.Network.globalvar;

/**
 * Created by root on 12.07.16.
 */
public class LocationThread extends Handler {
    GPSTracker GPSLocation = null;
    String SerialNumber;
    Context mContext = null;
    private boolean mShouldRun = false; // If the Runnable should keep on running
    private final Handler mHandler = new Handler();
    // This runnable will schedule itself to run at 1 second intervals
    // if mShouldRun is set true.
    private final Runnable mUpdateClock = new Runnable() {
        public void run() {
            if (mShouldRun) {
                updateClockDisplay(); // Call the method to actually update the clock
                mHandler.postDelayed(mUpdateClock, 30000); // 30 second
            }
        }
    };

    public LocationThread(Context context, String Serial) {
        this.SerialNumber = Serial;
        this.mContext = context;
        GPSLocation = new GPSTracker(context);
    }

    /**
     * Start updating the clock every second.
     * Don't forget to call stopUpdater() when you
     * don't need to update the clock anymore.
     */
    public void startUpdater() {
        mShouldRun = true;
        mHandler.post(mUpdateClock);
    }

    /**
     * Stop updating the clock.
     */
    public void stopUpdater() {
        mShouldRun = false;
    }


    /**
     * Update the textview associated with this
     * digital clock.
     */
    private void updateClockDisplay() {
        HashMap<String, String> Location = GPSLocation.GetCounter();
        if (Location.size() > 0) {
            Location.put(globalvar.KEY_CURRENTLOCATIONS_DELIVARY_NAME, this.SerialNumber);
            new ServerLocation(Location).execute();
        }
    }
}
