package privatecom.abaza.tawsela_restaurant;

import android.app.Dialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.res.Configuration;
import android.media.MediaPlayer;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.text.InputType;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.TextView;

import com.avast.android.dialogs.fragment.ListDialogFragment;
import com.avast.android.dialogs.fragment.SimpleDialogFragment;
import com.avast.android.dialogs.iface.IListDialogListener;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;

import privatecom.abaza.tawsela_restaurant.map.MapsActivity;
import privatecom.abaza.tawsela_restaurant.network.ConnectionServer;
import privatecom.abaza.tawsela_restaurant.network.CreateOrder;
import privatecom.abaza.tawsela_restaurant.network.RecordDelavary;
import privatecom.abaza.tawsela_restaurant.network.globalvar;


public class MainActivity extends AppCompatActivity implements IListDialogListener {
    public EditText Quantaty;
    public EditText Amount;
    public EditText OwnerName;
    public TextView Service;
    public String IMSI, ServicePrice;
    public ArrayList<String> TaskList = null;
    private Dialog dialogmoney = null;
    private Dialog dialogTracker = null;
    private String OrderSelectis = null;
    private MediaPlayer mp = null;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.main_botton);
        setContentView(R.layout.activity_main);

        Intent i = getIntent();
        IMSI = i.getStringExtra("IMSI");
        ServicePrice = i.getStringExtra("ServicePrice");

        dialogmoney = new Dialog(MainActivity.this);
        dialogTracker = new Dialog(MainActivity.this);
        mp = MediaPlayer.create(this, R.raw.buttondelavary);

        ImageButton btnCall = (ImageButton) findViewById(R.id.btnDelavary);
        Button OpenMap = (Button) findViewById(R.id.btnNeerly);
        Button TrackerDelavary = (Button) findViewById(R.id.btnMyOrderWith);

        OpenMap.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent map = new Intent(MainActivity.this, MapsActivity.class);
                startActivity(map);
            }
        });

        TrackerDelavary.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ButTask();
            }
        });

        btnCall.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                mp.start();
                OrderName(view);
            }
        });
    }

    private void OrderName(final View view) {
        final AlertDialog.Builder alert = new AlertDialog.Builder(view.getContext());
        alert.setCancelable(true);
        alert.setTitle(getResources().getString(R.string.titOwnerOrder));
        OwnerName = new EditText(view.getContext());
        OwnerName.setInputType(InputType.TYPE_CLASS_TEXT);
        alert.setView(OwnerName);
        alert.setNegativeButton(getResources().getText(R.string.btnNext), new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                if (OwnerName.getText().length() > 0) {
                    Quantaty(view);
                } else {
                    alert.create().dismiss();
                }
            }
        });

        alert.setPositiveButton(getResources().getText(R.string.btnCancel), new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                alert.create().dismiss();
            }
        });
        alert.create();
        alert.show();

    }

    private void Quantaty(View view) {
        final AlertDialog.Builder alert = new AlertDialog.Builder(view.getContext());
        alert.setCancelable(false);
        alert.setTitle(getResources().getString(R.string.titNumberOfOrder));
        Quantaty = new EditText(view.getContext());
        Quantaty.setInputType(InputType.TYPE_CLASS_NUMBER);
        Quantaty.setRawInputType(Configuration.KEYBOARD_12KEY);
        alert.setView(Quantaty);
        alert.setNegativeButton(getResources().getText(R.string.btnNext), new DialogInterface.OnClickListener() {
            public void onClick(DialogInterface dialog, int whichButton) {
                if (Quantaty.getText().length() > 0) {
                    Amount();
                } else {
                    alert.create().dismiss();
                }
            }
        });
        alert.setPositiveButton(getResources().getString(R.string.btnCancel), new DialogInterface.OnClickListener() {
            public void onClick(DialogInterface dialog, int whichButton) {
                alert.create().dismiss();
            }
        });
        alert.create();
        alert.show();
    }

    private void Amount() {
        //setting custom layout to dialog
        dialogmoney.setContentView(R.layout.custom_dialog_layout);

        int Quant = Integer.parseInt(Quantaty.getText().toString());
        int Serv = Integer.parseInt(ServicePrice);
        int ServiceInt = Quant * Serv;
        //adding text dynamically
        Amount = (EditText) dialogmoney.findViewById(R.id.editText);
        Service = (TextView) dialogmoney.findViewById(R.id.txtServicePrice);
        Service.setText(" + " + String.valueOf(ServiceInt));
        //adding button click event
        Button dismissButton = (Button) dialogmoney.findViewById(R.id.button);
        dismissButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (Amount.getText().equals("")) {
                    final AlertDialog.Builder alert = new AlertDialog.Builder(v.getContext());
                    alert.setTitle(v.getResources().getString(R.string.titError));
                    alert.setMessage(v.getResources().getString(R.string.msgPrice));
                    alert.setCancelable(false);
                    alert.setNegativeButton(v.getResources().getText(R.string.btnOK), new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {
                            alert.create().dismiss();
                        }
                    });
                    alert.create();
                    alert.show();
                } else {
                    String Owner = String.valueOf(OwnerName.getText());
                    String txtQuantati = String.valueOf(Quantaty.getText());
                    String txtAmount = String.valueOf(Amount.getText());

                    if ((txtQuantati.length() > 0) && (txtAmount.length() > 0) && (Owner.length() > 0)) {
                        Implimntation(Owner, txtQuantati, txtAmount);
                    } else {
                        final AlertDialog.Builder alert = new AlertDialog.Builder(v.getContext());
                        alert.setTitle(v.getResources().getString(R.string.titError));
                        alert.setMessage(v.getResources().getString(R.string.msgWithoutAandQ));
                        alert.setCancelable(false);
                        alert.setNegativeButton(v.getResources().getText(R.string.btnOK), new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {
                                alert.create().dismiss();
                            }
                        });
                        alert.create();
                        alert.show();
                    }
                }
            }
        });
        dialogmoney.show();
    }

    private void Implimntation(String Owner, String Quantaty, String Amount) {
        if ((Quantaty == null) || (Quantaty.equals(0))) {
            SimpleDialogFragment.createBuilder(this, getSupportFragmentManager())
                    .setMessage(getResources().getString(R.string.diloErrorQuantati))
                    .setTitle(getResources().getString(R.string.titError))
                    .show();
        }
        if ((Amount == null) || (Amount.equals(0))) {
            SimpleDialogFragment.createBuilder(this, getSupportFragmentManager())
                    .setMessage(getResources().getString(R.string.diloErrorAmount))
                    .setTitle(getResources().getString(R.string.titError))
                    .show();
        }

        new CreateOrder(this).execute(IMSI, Owner, Amount, Quantaty);
        dialogmoney.dismiss();
    }

    @Override
    public void onListItemSelected(CharSequence value, int number, int requestCode) {
        if (requestCode == globalvar.REQUEST_LIST_SIMPLE) {
            String[] ID = value.toString().split(":");
            OrderSelectis = ID[1];
            dialogTracker.setContentView(R.layout.dialog_my_order_with);
            dialogTracker.setCancelable(true);
            dialogTracker.setTitle(dialogTracker.getContext().getResources().getString(R.string.titWhoTalkyourorder) + " " + OrderSelectis);

            final EditText DelavaryNumber = (EditText) dialogTracker.findViewById(R.id.txtDelvNumber);
            Button btnStartTracker = (Button) dialogTracker.findViewById(R.id.btnRecord);

            btnStartTracker.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    new RecordDelavary(MainActivity.this).execute(IMSI, DelavaryNumber.getText().toString(), OrderSelectis.toString());
                    dialogTracker.dismiss();
                }
            });
            dialogTracker.show();
        }
    }

    private void ButTask() {
        new GetTasks(this).execute();
    }

    private class GetTasks extends AsyncTask<String, Void, String> {
        Context Activ = null;
        ProgressDialog dialog = null;
        ConnectionServer MyServer = null;

        public GetTasks(Context context) {
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
        protected void onPostExecute(String s) {
            JSONObject jsonobject = null;
            TaskList = new ArrayList<>();
            JSONArray jsonarray = null;
            String[] List = null;
            try {
                jsonobject = new JSONObject(s);
                try {
                    jsonarray = jsonobject.getJSONArray(globalvar.RESULT);

                    if (jsonarray.getString(0).equals(globalvar.NO_TASKS)) {
                        final AlertDialog.Builder alBuilder = new AlertDialog.Builder(this.Activ);
                        alBuilder.setTitle(getResources().getString(R.string.titErrorMessage));
                        alBuilder.setMessage(getResources().getString(R.string.NoTasks));
                        alBuilder.setCancelable(true);
                        alBuilder.setPositiveButton(R.string.btnOK, new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {
                                alBuilder.create().dismiss();
                            }
                        });
                        alBuilder.create();
                        alBuilder.show();
                        return;
                    }

                    for (int i = 0; i < jsonarray.length(); i++) {
                        jsonobject = jsonarray.getJSONObject(i);
                        TaskList.add(jsonobject.optString(globalvar.FILED_TASKS_ID) + " - " + jsonobject.optString(globalvar.FILED_TASKS_OWNER_NAME));
                    }

                    List = new String[TaskList.size()];
                    for (int x = 0; x < TaskList.size(); x++) {
                        List[x] = getResources().getString(R.string.itemList) + " : " + TaskList.get(x);
                    }

                    if (dialog.isShowing()) {
                        dialog.dismiss();
                    }
                } catch (JSONException e) {
                    String quiry = jsonobject.getString(globalvar.RESULT);

                    if (quiry.equals(globalvar.NO_TASKS)) {
                        if (dialog.isShowing()) {
                            dialog.dismiss();
                        }
                        final AlertDialog.Builder alBuilder = new AlertDialog.Builder(this.Activ);
                        alBuilder.setTitle(getResources().getString(R.string.titError));
                        alBuilder.setMessage(getResources().getString(R.string.NoTasks));
                        alBuilder.setCancelable(true);
                        alBuilder.setPositiveButton(R.string.btnOK, new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {
                                alBuilder.create().dismiss();
                            }
                        });
                        alBuilder.create();
                        alBuilder.show();
                        return;
                    } else {
                        JSONObject jsonObject = new JSONObject(quiry);

                        String ID = jsonObject.optString(globalvar.FILED_TASKS_ID);
                        String Name = jsonObject.optString(globalvar.FILED_TASKS_OWNER_NAME);

                        List = new String[1];
                        List[0] = getResources().getString(R.string.itemList) + " : " + ID + " - " + Name;
                        if (dialog.isShowing()) {
                            dialog.dismiss();
                        }
                    }
                }
            } catch (Exception e) {
                e.printStackTrace();
                if (dialog.isShowing()) {
                    dialog.dismiss();
                }
            }
            ListDialogFragment
                    .createBuilder(MainActivity.this, getSupportFragmentManager())
                    .setTitle(getResources().getString(R.string.titOpenTask))
                    .setItems(List)
                    .setRequestCode(globalvar.REQUEST_LIST_SIMPLE)
                    .show();
        }

        @Override
        protected String doInBackground(String... params) {
            HashMap<String, String> Map = new HashMap<>();
            Map.put(globalvar.KEY_TASKS_SERVICE_NAME, IMSI);
            return MyServer.Server(globalvar.GET_OPEN_TASKS, Map, null);
        }
    }
}
