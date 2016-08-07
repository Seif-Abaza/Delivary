package delivery.com.delivary_boy;

import android.annotation.TargetApi;
import android.content.Intent;
import android.os.Build;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.TextView;

import delivery.com.delivary_boy.Network.globalvar;

public class points extends AppCompatActivity {

    @TargetApi(Build.VERSION_CODES.JELLY_BEAN_MR1)
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_points);

        Intent bast = getIntent();
        String Point = bast.getStringExtra(globalvar.FILED_BOYDELIVARY_POINTS);

        TextView myPoint = (TextView) findViewById(R.id.txtPoints);

        myPoint.setText(Point);
        myPoint.setTextAlignment(View.TEXT_ALIGNMENT_CENTER);

    }
}
