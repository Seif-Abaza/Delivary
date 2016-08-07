package delivery.com.delivary_boy;

import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;

import java.util.ArrayList;

import delivery.com.delivary_boy.Network.RegestrationClass;


/**
 * Created by root on 07.07.16.
 */
public class RegestrationPage extends AppCompatActivity {

    AlertDialog.Builder alert = null;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.fileds_reg);
        setContentView(R.layout.btn_reg);
        setContentView(R.layout.regestration);
        alert = new AlertDialog.Builder(getApplicationContext());


        //Get Intent
        Intent bast = getIntent();
        final ArrayList<String> worldlist = bast.getStringArrayListExtra("CONTRY");
        final String IMSI = bast.getStringExtra("IMSI");

        //Detramation Wedget
        final EditText txtName = (EditText) findViewById(R.id.txtName);
        final EditText txtPhone = (EditText) findViewById(R.id.txtPhone);
        final Spinner ServiceLocation = (Spinner) findViewById(R.id.lisZone);
        final EditText txtMotorNumber = (EditText) findViewById(R.id.txtMotorNumber);
        final EditText txtIDNumber = (EditText) findViewById(R.id.txtIDNumber);

        Button btnCancel = (Button) findViewById(R.id.btnCancel);
        Button btnNext = (Button) findViewById(R.id.btnNext);

        ServiceLocation.setAdapter(new ArrayAdapter<>(RegestrationPage.this,
                android.R.layout.simple_spinner_dropdown_item,
                worldlist));

        ServiceLocation.setSelection(0);

        btnCancel.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                System.exit(0);
            }
        });

        btnNext.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if (txtName.getText().length() == 0) {
                    final AlertDialog.Builder alert = new AlertDialog.Builder(view.getContext());
                    alert.setTitle(view.getResources().getString(R.string.msgError));
                    alert.setMessage(view.getResources().getString(R.string.msgCNRWName));
                    alert.setCancelable(false);
                    alert.setPositiveButton(view.getResources().getText(R.string.btnOK), new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {
                            return;
                        }
                    }).create();
                    alert.show();
                    return;
                }
                if (txtPhone.getText().length() == 0) {
                    final AlertDialog.Builder alert = new AlertDialog.Builder(view.getContext());
                    alert.setTitle(view.getResources().getString(R.string.msgError));
                    alert.setMessage(view.getResources().getString(R.string.msgCNRWPhone));
                    alert.setCancelable(false);
                    alert.setPositiveButton(view.getResources().getText(R.string.btnOK), new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {
                            return;
                        }
                    }).create();
                    alert.show();
                    return;
                }
                if (txtMotorNumber.getText().length() == 0) {
                    final AlertDialog.Builder alert = new AlertDialog.Builder(view.getContext());
                    alert.setTitle(view.getResources().getString(R.string.msgError));
                    alert.setMessage(view.getResources().getString(R.string.msgCNRWMotorNumber));
                    alert.setCancelable(false);
                    alert.setPositiveButton(view.getResources().getText(R.string.btnOK), new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {
                            return;
                        }
                    }).create();
                    alert.show();
                    return;
                }
                if (txtIDNumber.getText().length() == 0) {
                    final AlertDialog.Builder alert = new AlertDialog.Builder(view.getContext());
                    alert.setTitle(view.getResources().getString(R.string.msgError));
                    alert.setMessage(view.getResources().getString(R.string.msgCNRWIDN));
                    alert.setCancelable(false);
                    alert.setPositiveButton(view.getResources().getText(R.string.btnOK), new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {
                            return;
                        }
                    }).create();
                    alert.show();
                    return;
                }

                new RegestrationClass(RegestrationPage.this).execute(txtName.getText().toString(), txtPhone.getText().toString()
                        , IMSI, String.valueOf(ServiceLocation.getSelectedItemId() + 1), txtIDNumber.getText().toString(),
                        txtMotorNumber.getText().toString());
            }
        });
    }
}
