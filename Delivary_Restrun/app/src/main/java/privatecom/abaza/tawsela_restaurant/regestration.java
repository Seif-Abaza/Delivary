package privatecom.abaza.tawsela_restaurant;


import android.app.Activity;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AlertDialog;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;

import java.util.ArrayList;

import privatecom.abaza.tawsela_restaurant.network.RegestrationConnect;

public class regestration extends Activity {
    EditText ServiceName, PhoneNumber, Address = null, txtPriceService;
    Spinner ServiceLocation = null;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.data_regestration);
        setContentView(R.layout.activity_regestration);

        Intent i = getIntent();
        final ArrayList<String> worldlist = i.getStringArrayListExtra("CONTRY");
        final String IMSI = i.getStringExtra("IMSI");


        ServiceName = (EditText) findViewById(R.id.txtRestName);
        PhoneNumber = (EditText) findViewById(R.id.txtPhone);
        ServiceLocation = (Spinner) findViewById(R.id.txtLocation);
        Address = (EditText) findViewById(R.id.txtAddress);
        txtPriceService = (EditText) findViewById(R.id.txtPrice);

        Button RegestrationButton = (Button) findViewById(R.id.btnRegestration);

        ServiceLocation.setAdapter(new ArrayAdapter<>(regestration.this,
                android.R.layout.simple_spinner_dropdown_item,
                worldlist));

        ServiceLocation.setSelection(0);

        RegestrationButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if (ServiceName.getText().equals("")) {
                    final AlertDialog.Builder alert = new AlertDialog.Builder(view.getContext());
                    alert.setTitle(view.getResources().getString(R.string.titErrorMessage));
                    alert.setMessage(view.getResources().getString(R.string.msgCNRWOServiceName));
                    alert.setCancelable(false);
                    alert.setPositiveButton(view.getResources().getText(R.string.btnOK), new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {
                            return;
                        }
                    }).create();
                    alert.show();
                }
                if (PhoneNumber.getText().equals("")) {
                    final AlertDialog.Builder alert = new AlertDialog.Builder(view.getContext());
                    alert.setTitle(view.getResources().getString(R.string.titErrorMessage));
                    alert.setMessage(view.getResources().getString(R.string.msgCNRWOPhoneNumber));
                    alert.setCancelable(false);
                    alert.setPositiveButton(view.getResources().getText(R.string.btnOK), new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {
                            return;
                        }
                    }).create();
                    alert.show();
                }
                if (Address.getText().equals("")) {
                    final AlertDialog.Builder alert = new AlertDialog.Builder(view.getContext());
                    alert.setTitle(view.getResources().getString(R.string.titErrorMessage));
                    alert.setMessage(view.getResources().getString(R.string.msgCNRWOAddress));
                    alert.setCancelable(false);
                    alert.setPositiveButton(view.getResources().getText(R.string.btnOK), new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {
                            return;
                        }
                    }).create();
                    alert.show();
                }
                if (txtPriceService.getText().equals("")) {
                    final AlertDialog.Builder alert = new AlertDialog.Builder(view.getContext());
                    alert.setTitle(view.getResources().getString(R.string.titErrorMessage));
                    alert.setMessage(view.getResources().getString(R.string.msgCNRWOPraceService));
                    alert.setCancelable(false);
                    alert.setPositiveButton(view.getResources().getText(R.string.btnOK), new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {
                            return;
                        }
                    }).create();
                    alert.show();
                }


                RegestrationConnect RC = new RegestrationConnect(regestration.this);
                RC.execute(ServiceName.getText().toString(),
                        String.valueOf(ServiceLocation.getSelectedItemId() + 1),
                        PhoneNumber.getText().toString(), Address.getText().toString(),
                        txtPriceService.getText().toString(),
                        IMSI);
            }
        });
    }
}
