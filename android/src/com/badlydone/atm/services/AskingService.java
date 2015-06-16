package com.badlydone.atm.services;

import java.util.Timer;
import java.util.TimerTask;

import com.badlydone.atm.AtmWsdl;
import com.badlydone.atm.QuestionStruct;

import android.app.Notification;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.app.Service;
import android.content.Context;
import android.content.Intent;
import android.os.Binder;
import android.os.IBinder;
import android.widget.Toast;

public class AskingService extends Service {
	
	// timer that ask questions
	private Timer _timer = new Timer();
	// binder class
	private final IBinder _binder = new AskingServiceBinder();
	// notification nanager
	private NotificationManager _nm;
	// class atm
	private AtmWsdl _atm;
	
	// class for the binder
	public class AskingServiceBinder extends Binder {
		public AskingService getService() {
            return AskingService.this;
        }
    }

	@Override
	public void onCreate() {
		// TODO Auto-generated method stub
		super.onCreate();
		
		Toast.makeText(getBaseContext(), "Service started", 
                Toast.LENGTH_SHORT).show();
		
		// get the notification manager from the system
		_nm = (NotificationManager) getSystemService(NOTIFICATION_SERVICE);
	}

	@Override
	public void onDestroy() {
		// TODO Auto-generated method stub
		super.onDestroy();
		
		// get rid of all notifications
		_nm.cancelAll();
		
		Toast.makeText(getBaseContext(), "Service stopped", 
                Toast.LENGTH_SHORT).show();
	}

	@Override
	public IBinder onBind(Intent arg0) {
		// TODO Auto-generated method stub
		return _binder;
	}
	
	public void StartAsking(AtmWsdl a)
	{
		
		_atm = a;
		
		// calculate the internal in minutes
		int interval = (_atm.getTimeToAskMe() * 60) * 1000;
		
		Toast.makeText(getBaseContext(), String.format("First question from %s minutes", _atm.getTimeToAskMe()) , 
                Toast.LENGTH_SHORT).show();
		
		_timer.scheduleAtFixedRate(new TimerTask() {
			
			@Override
			public void run() {
				// TODO Auto-generated method stub
				AskQuestion();
			}
		}, 
		interval,
		interval);
		
	}
	
	private void AskQuestion()
	{
		
		// stop the timer
		_timer.cancel();
		
		// get the question from webservice
		QuestionStruct q = _atm.getQuestion();
		
		// show the notify on the toolbar
		if (q != null)
			sendNotifyQuestion(q);
	}

	private void sendNotifyQuestion(QuestionStruct q)
	{
		
		//create the notify
		int icon = com.badlydone.atm.R.drawable.status_icon;
		CharSequence tickerText = "Question";
		long when = System.currentTimeMillis();
		
		Notification notification = new Notification(icon, tickerText, when);
		
		// create the text inside
		Context context = getApplicationContext();
		CharSequence contentTitle = "New question";
		CharSequence contentText = String.format("Question about: %s", q.getFrom());
		Intent notificationIntent = new Intent(this, AskingService.class);
		PendingIntent contentIntent = PendingIntent.getActivity(this, 0, notificationIntent, 0);
		
		notification.setLatestEventInfo(context, contentTitle, contentText, contentIntent);
		
		_nm.notify(1, notification);
		
	}
	
}
