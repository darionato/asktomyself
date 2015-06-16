package com.badlydone.atm;

import java.util.ArrayList;
import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.TextView;

class CategoriesAdapter extends ArrayAdapter<Category> {

    private ArrayList<Category> items;

    public CategoriesAdapter(Context context, int textViewResourceId, ArrayList<Category> items) {
            super(context, textViewResourceId, items);
            this.items = items;
    }

    public View getView(int position, View convertView, ViewGroup parent) {
            View v = convertView;
            if (v == null) {
                LayoutInflater vi = (LayoutInflater)
                	getContext().getSystemService(Context.LAYOUT_INFLATER_SERVICE);
                v = vi.inflate(R.layout.row_category, null);
            }
            Category o = items.get(position);
            if (o != null) {
                    TextView tt = (TextView) v.findViewById(R.id.toptext);
                    TextView bt = (TextView) v.findViewById(R.id.bottomtext);
                    if (tt != null)
                    	tt.setText(o.getDescription());
                    if(bt != null)
                    {
                    	bt.setText("Shared by: " + (o.getSharedBy().length() == 0?"myself":o.getSharedBy()));
                    }
            }
            return v;
    }
}