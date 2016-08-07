package delivery.com.delivary_boy;

import android.content.Intent;
import android.media.MediaPlayer;
import android.os.Bundle;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.Iterator;
import java.util.List;
import java.util.Timer;

import delivery.com.delivary_boy.Network.AutoRefrationing;
import delivery.com.delivary_boy.Network.GetUpDate;
import delivery.com.delivary_boy.Network.globalvar;
import delivery.com.delivary_boy.adapter.FeedListAdapter;
import delivery.com.delivary_boy.data.FeedItem;

public class MainActivity extends AppCompatActivity implements SwipeRefreshLayout.OnRefreshListener {
    private ListView listView;
    private FeedListAdapter listAdapter;
    private List<FeedItem> feedItems;
    private SwipeRefreshLayout swipeRefreshLayout;
    private String SerialNumber;
    private AutoRefrationing TimerOrder = null;
    private Timer tm = null;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        Intent bast = getIntent();
//            String JSONString = bast.getStringExtra("DATA");
        SerialNumber = bast.getStringExtra(globalvar.FILED_BOYDELIVARY_PHONE_SERIAL_NUMBER);

//            JSONObject ArrayFeed = new JSONObject(JSONString);

        swipeRefreshLayout = (SwipeRefreshLayout) findViewById(R.id.swipe_refresh_layout);

        swipeRefreshLayout.setOnRefreshListener(this);


        listView = (ListView) findViewById(R.id.list);
//            parseJsonFeed(ArrayFeed);

        listView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                Toast.makeText(MainActivity.this, "Pos " + position + " id " + id, Toast.LENGTH_LONG).show();
            }
        });

        /**
         * Showing Swipe Refresh animation on activity create
         * As animation won't start on onCreate, post runnable is used
         */
        swipeRefreshLayout.post(new Runnable() {
                                    @Override
                                    public void run() {
                                        new GetUpDate(MainActivity.this, swipeRefreshLayout).execute(SerialNumber);
                                    }
                                }
        );

        TimerOrder = new AutoRefrationing(SerialNumber, MainActivity.this);
        tm = new Timer(true);
        tm.schedule(TimerOrder, 5000);
    }

    /**
     * Parsing json reponse and passing the data to feed view list adapter
     */
    public void parseJsonFeed(JSONObject response) {
        try {
            feedItems = new ArrayList<FeedItem>();
            int CurrentCount = 0;
            if (listView != null) {
                CurrentCount = listView.getCount();
            }


            listAdapter = new FeedListAdapter(this, feedItems);
            listView.setAdapter(listAdapter);


            JSONObject jsnobject = response.getJSONObject(globalvar.RESULT);
            Iterator x = jsnobject.keys();
            JSONArray jsonArray = new JSONArray();

            while (x.hasNext()) {
                String key = (String) x.next();
                jsonArray.put(jsnobject.get(key));
            }


            int NewCount = jsonArray.length();
            if (NewCount > CurrentCount) {
                MediaPlayer mp = MediaPlayer.create(this, R.raw.beeps);
                mp.start();
            }

            for (int i = 0; i < jsonArray.length(); i++) {

                JSONObject feedObj = (JSONObject) jsonArray.getJSONObject(i);

                FeedItem item = new FeedItem();

                item.setId(feedObj.getInt(globalvar.FILED_TASKS_ID));
                item.setName(feedObj.getString(globalvar.FILED_SERVICE_NAME));
                item.setAddress(feedObj.getString(globalvar.FILED_SERVICE_ADDRESS));
                item.setPhone(feedObj.getString(globalvar.FILED_SERVICE_PHONE));
                item.setProfilePic(null);
                item.setAmount(feedObj.getString(globalvar.FILED_TASKS_AMOUT_ORDER));
                item.setQuantaty(feedObj.getString(globalvar.FILED_TASKS_QUANTATY_ORDER));
                item.setStarttime(feedObj.getString(globalvar.FILED_TASKS_TASK_START_DATE));
                feedItems.add(item);
            }

            // notify data changes to list adapater
            listAdapter.notifyDataSetChanged();
        } catch (JSONException e) {
            e.printStackTrace();
        }
    }

    @Override
    public void onRefresh() {
        new GetUpDate(MainActivity.this, swipeRefreshLayout).execute(SerialNumber);
    }

}
