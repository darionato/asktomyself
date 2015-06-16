package com.badlydone.atm;

import android.app.Activity;
import android.content.ComponentName;
import android.content.Intent;
import android.content.ServiceConnection;
import android.os.Bundle;
import android.os.IBinder;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.TextView;
import com.badlydone.atm.services.AskingService;

public class StartAsking extends Activity {

	private AtmWsdl _atm = new AtmWsdl();
	private AskingService _service;
	
	private ServiceConnection _ServiceConn = new ServiceConnection() {
			
			public void onServiceDisconnected(ComponentName name) {
				// TODO Auto-generated method stub
				_service = null;
				
			}
			
			public void onServiceConnected(ComponentName name, IBinder service) {
				// TODO Auto-generated method stub
				_service = ((AskingService.AskingServiceBinder)service).getService();
				// set the interval of asking
				_service.StartAsking(_atm);
			}
	};
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.start_asking);
		
		// get user area data
        _atm.setEmail(getIntent().getExtras().getString(
        		getResources().getString(R.string.config_email)));
        _atm.setPassword(getIntent().getExtras().getString(
        		getResources().getString(R.string.config_pwd)));
        
        _atm.FethSettings();
        
        // set the label with the category name
        TextView tvC = (TextView)findViewById(R.id.tvCategory);
        tvC.setText(getIntent().getExtras().getString(
        		getResources().getString(R.string.category_desc)));
        
        
        // handle the start services
        Button bStart = (Button)findViewById(R.id.btnStart);
        bStart.setOnClickListener(new OnClickListener() {
			
			public void onClick(View v) {
				
				bindService(new Intent(StartAsking.this, AskingService.class), _ServiceConn, BIND_AUTO_CREATE);
			}
		});
        
        // handle the stop services
        Button bStop = (Button)findViewById(R.id.btnStop);
        bStop.setOnClickListener(new OnClickListener() {
			
			public void onClick(View v) {
				
				unbindService(_ServiceConn);
				
			}
		});
		
	}

}
