package com.badlydone.atm;

import java.util.ArrayList;

import android.app.ListActivity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.ListView;

public class categories extends ListActivity  {
	
	private ArrayList<Category> _Categories = null;
	private CategoriesAdapter _Adapter = null;
	private AtmWsdl _atm = new AtmWsdl();
	
	@Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        
        // get user area data
        
        _atm.setEmail(getIntent().getExtras().getString(
        		getResources().getString(R.string.config_email)));
        _atm.setPassword(getIntent().getExtras().getString(
        		getResources().getString(R.string.config_pwd)));
        _atm.FethCategories();
        
		// get all categories
		this._Categories = _atm.getCategories(); 
		
		// create the adapter
		this._Adapter = new CategoriesAdapter(
				this, R.layout.row_category, this._Categories);
		
		// set it to list
		setListAdapter(this._Adapter);
		
	}

	@Override
	protected void onListItemClick(ListView l, View v, int position, long id) {
		// TODO Auto-generated method stub
		super.onListItemClick(l, v, position, id);
		
		Category cat = (Category) this._Categories.get(position);
		
		OpenStartAsking(cat);
	}

	private void OpenStartAsking(Category cat)
    {   	
    	Intent i = new Intent(this, StartAsking.class);
    	i.putExtra(getResources().getString(R.string.config_email), this._atm.getEmail());
    	i.putExtra(getResources().getString(R.string.config_pwd), this._atm.getPassword());
    	i.putExtra(getResources().getString(R.string.category_id), cat.getId());
    	i.putExtra(getResources().getString(R.string.category_desc), cat.getDescription());
    	startActivityForResult(i, 1);
    }
	
}
