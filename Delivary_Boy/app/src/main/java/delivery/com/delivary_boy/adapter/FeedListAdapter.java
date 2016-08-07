package delivery.com.delivary_boy.adapter;

import android.app.Activity;
import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.TextView;

import java.util.List;

import delivery.com.delivary_boy.Network.BookingClass;
import delivery.com.delivary_boy.R;
import delivery.com.delivary_boy.data.FeedItem;


public class FeedListAdapter extends BaseAdapter {
    private Activity activity;
    private LayoutInflater inflater;
    private List<FeedItem> feedItems;
//	ImageLoader imageLoader = AppController.getInstance().getImageLoader();

    public FeedListAdapter(Activity activity, List<FeedItem> feedItems) {
        this.activity = activity;
        this.feedItems = feedItems;
    }

    @Override
    public int getCount() {
        return feedItems.size();
    }

    @Override
    public Object getItem(int location) {
        return feedItems.get(location);
    }

    @Override
    public long getItemId(int position) {
        return position;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {

        if (inflater == null)
            inflater = (LayoutInflater) activity
                    .getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        if (convertView == null)
            convertView = inflater.inflate(R.layout.feeditem, null);

//		if (imageLoader == null)
//			imageLoader = AppController.getInstance().getImageLoader();

        TextView name = (TextView) convertView.findViewById(R.id.name);
        TextView txtAddress = (TextView) convertView.findViewById(R.id.txtAddress);
        TextView txtStartTime = (TextView) convertView.findViewById(R.id.txtOrderStartTime);
        TextView txtQuantaty = (TextView) convertView.findViewById(R.id.txtOrderQuantaty);
        TextView txtOrderAmount = (TextView) convertView.findViewById(R.id.txtOrderAmount);
        TextView txtPhone = (TextView) convertView.findViewById(R.id.txtPhone);
        TextView txtID = (TextView) convertView.findViewById(R.id.txtTaskOrderID);
        Button btnGOToThis = (Button) convertView.findViewById(R.id.btnGo);
        final FeedItem item = feedItems.get(position);


        txtID.setText(String.valueOf(this.activity.getResources().getString(R.string.lblNumOrder) + " " + item.getId()));
        name.setText(item.getName());
        txtAddress.setText(item.getAddress());
        txtPhone.setText(item.getPhone());

        txtQuantaty.setText(item.getQuantaty());
        txtOrderAmount.setText(item.getAmount());
        txtStartTime.setText(item.getStarttime());


        btnGOToThis.setVisibility(View.GONE);

        btnGOToThis.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                new BookingClass(v.getContext()).execute(String.valueOf(item.getId()));
            }
        });
        return convertView;
    }

}
