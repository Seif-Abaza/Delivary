package delivery.com.delivary_boy;

import android.annotation.TargetApi;
import android.app.Dialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Color;
import android.os.Build;
import android.os.Bundle;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

import delivery.com.delivary_boy.Network.ConnectionServer;
import delivery.com.delivary_boy.Network.MoodDelivaryChange;
import delivery.com.delivary_boy.Network.globalvar;
import delivery.com.delivary_boy.location.GPSTracker;
import delivery.com.delivary_boy.location.LocationThread;

public class Dashbord extends AppCompatActivity {
    private String Name, Points, Status, Zone, Message_Server, SerialNumber, MyCode;
    private ConnectionServer Server = null;
    private LocationThread MyLocation = null;
    private Button btnFeed, btnPoints, btnOnline, btnOffline;
    private Intent Torders = null;

    @TargetApi(Build.VERSION_CODES.JELLY_BEAN_MR1)
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.message_server);
        setContentView(R.layout.activity_dashbord);
        try {

            this.Server = new ConnectionServer();

            Intent Bast = getIntent();

            Name = Bast.getStringExtra(globalvar.FILED_BOYDELIVARY_NAME);
            Points = Bast.getStringExtra(globalvar.FILED_BOYDELIVARY_POINTS);
            Status = Bast.getStringExtra(globalvar.FILED_BOYDELIVARY_MOOD);
            Zone = Bast.getStringExtra(globalvar.FILED_BOYDELIVARY_LOCATION);
            Message_Server = Bast.getStringExtra(globalvar.FILED_BOYDELIVARY_COMMENT);
            SerialNumber = Bast.getStringExtra(globalvar.FILED_BOYDELIVARY_PHONE_SERIAL_NUMBER);
            MyCode = Bast.getStringExtra(globalvar.FILED_BOYDELIVARY_ID);

            btnFeed = (Button) findViewById(R.id.btnOrdersFeed);
            btnPoints = (Button) findViewById(R.id.btnPontins);
            btnOnline = (Button) findViewById(R.id.btnOnline);
            btnOffline = (Button) findViewById(R.id.btnOffline);

            final TextView txtStatus = (TextView) findViewById(R.id.txtStatusNow);
            TextView txtName = (TextView) findViewById(R.id.txtName);
            final TextView txtSerial = (TextView) findViewById(R.id.txtMyserial);


            txtSerial.setText(MyCode);
            txtName.setText(Name);

            txtSerial.setTextAlignment(View.TEXT_ALIGNMENT_CENTER);
            txtName.setTextAlignment(View.TEXT_ALIGNMENT_CENTER);

            //Show Messages
            if (Message_Server != null) {
                final Dialog MS = new Dialog(Dashbord.this);
                MS.setContentView(R.layout.message_server);
                TextView txtServerMessage = (TextView) MS.findViewById(R.id.txtServerMessage);
                Button btnServerMessage = (Button) MS.findViewById(R.id.btnMessageServer);

                txtServerMessage.setText(Message_Server);
                btnServerMessage.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        MS.dismiss();
                    }
                });
                MS.show();
            }
            //Show Status Online or Offline

            if (Status.equals(globalvar.OFFLINE)) {
                txtStatus.setText(getResources().getText(R.string.titStatusNowOffline));
                txtStatus.setTextColor(Color.RED);
                OfflineButtons();
                Stop_UpdateLocation();
            } else if (Status.equals(globalvar.ONLINE)) {
                txtStatus.setText(getResources().getText(R.string.titStatusNowOnline));
                txtStatus.setTextColor(Color.GREEN);
                OnlineButtons();
                Start_UpdateLocation();
            }

            btnFeed.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
//                    new FeedGeting(Dashbord.this, Dashbord.this).execute(SerialNumber);
                    StartFeedView(null);

                }
            });

            btnPoints.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    //Get Points
//                    new PointsGeting().execute(SerialNumber);
                    Intent point = new Intent(Dashbord.this, points.class);
                    point.putExtra(globalvar.FILED_BOYDELIVARY_POINTS, Points);
                    startActivity(point);
                }
            });

            btnOnline.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    //Send Segnal Online
                    new MoodDelivaryChange(Dashbord.this, Dashbord.this).execute(globalvar.SET_MODE, globalvar.KEY_BOYDELIVARY_MOOD, globalvar.ONLINE, SerialNumber);
                    txtStatus.setText(Dashbord.this.getResources().getString(R.string.titStatusNowOnline));
                    txtStatus.setTextColor(Color.GREEN);
                }
            });

            btnOffline.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    //Send Segnal Offline
                    new MoodDelivaryChange(Dashbord.this, Dashbord.this).execute(globalvar.SET_MODE, globalvar.KEY_BOYDELIVARY_MOOD, globalvar.OFFLINE, SerialNumber);
                    txtStatus.setText(Dashbord.this.getResources().getString(R.string.titStatusNowOffline));
                    txtStatus.setTextColor(Color.RED);
                }
            });
            return;
        } catch (Exception r) {
            AlertDialog.Builder Dialog = new AlertDialog.Builder(Dashbord.this);
            Dialog.setTitle("Error");
            Dialog.setMessage("Can't Access Server");
            Dialog.setCancelable(false);
            Dialog.setPositiveButton("OK", new DialogInterface.OnClickListener() {
                @Override
                public void onClick(DialogInterface dialog, int which) {
                    System.exit(0);
                }
            });
            Dialog.create();
            Dialog.show();
        }

    }

    public void OnlineButtons() {
        btnFeed.setEnabled(true);
        btnPoints.setEnabled(true);
        btnOffline.setEnabled(true);
        btnOnline.setEnabled(false);
    }

    public void OfflineButtons() {
        btnFeed.setEnabled(false);
        btnPoints.setEnabled(false);
        btnOffline.setEnabled(false);
        btnOnline.setEnabled(true);
    }

    public void Start_UpdateLocation() {
        //Upload Location
        final GPSTracker GPS_Location = new GPSTracker(Dashbord.this);
        if (!GPS_Location.canGetLocation()) {
            btnFeed.setEnabled(false);
            btnPoints.setEnabled(false);
            GPS_Location.showSettingsAlert();
        } else {
            MyLocation = new LocationThread(Dashbord.this, SerialNumber);
            MyLocation.startUpdater();
        }
    }

    public void Stop_UpdateLocation() {
        if (MyLocation != null) {
            MyLocation.stopUpdater();
        }
    }

    public void StartFeedView(String Data) {
        //Get Feed
        Torders = new Intent(Dashbord.this, MainActivity.class);
//        Torders.putExtra("DATA", Data);
        Torders.putExtra(globalvar.FILED_BOYDELIVARY_PHONE_SERIAL_NUMBER, SerialNumber);
        startActivity(Torders);
    }


}
