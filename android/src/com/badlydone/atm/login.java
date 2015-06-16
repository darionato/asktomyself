package com.badlydone.atm;

import java.io.UnsupportedEncodingException;
import java.security.NoSuchAlgorithmException;

import com.badlydone.atm.utils.convertSHA1;
import com.google.android.apps.analytics.GoogleAnalyticsTracker;

import android.app.Activity;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.Toast;

public class login extends Activity {
	
	public static final String PREFS_NAME = "AskToMyselfOptions";
	private AtmWsdl _atm = new AtmWsdl();
	private GoogleAnalyticsTracker tracker;
	
    /** Called when the activity is first created. */
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.main);
        
        // google tracker
        tracker = GoogleAnalyticsTracker.getInstance();
        tracker.start("UA-20279732-1", 60, this);
        
        tracker.trackPageView("/loginScreen");
        
        // open the settings
        OpenSettings();
        
        // handle the button cancel
        Button btnCancel = (Button)findViewById(R.id.btnCancel);
        btnCancel.setOnClickListener(new OnClickListener() {
			
			public void onClick(View v) 
			{
				// close the app
				tracker.trackEvent("Login", "Click", "Close", 0);
				finish();
			}
		});
        
        // handle login button
        Button btnLogin = (Button)findViewById(R.id.btnLogin);
        btnLogin.setOnClickListener(new OnClickListener() {
			
			public void onClick(View v) {
				
				tracker.trackEvent("Login", "Click", "DoLogin", 0);
				DoTheLogin();
			}
		});
        
        // chech for the auto sign in
        CheckBox signin = (CheckBox)findViewById(R.id.chkSignInAuto);
        tracker.trackEvent("Login", "SignIn", "AutoSignIn", (signin.isChecked()?1:0));
        if (signin.isChecked())
        
        	DoTheLogin();
        
        
    }
    
    private void DoTheLogin()
    {
    	// get email and password
		EditText txtEmail = (EditText)findViewById(R.id.txtEmail);
		EditText txtPwd = (EditText)findViewById(R.id.txtPassword);
		
		// try login

		// set the pwd convert in sha1
		this._atm.setEmail(txtEmail.getText().toString());
		try {
			this._atm.setPassword(convertSHA1.SHA1(txtPwd.getText().toString()));
		} catch (NoSuchAlgorithmException e) {
			e.printStackTrace();
		} catch (UnsupportedEncodingException e) {
			e.printStackTrace();
		}
		
		
		// get the result
		if (this._atm.TryLogin() == false)
			Toast.makeText(getBaseContext(), "Email or password wrond, try again!", 
                    Toast.LENGTH_SHORT).show();
		else
		{
			
			// save settings
			SaveSettings(txtEmail.getText().toString(), 
					txtPwd.getText().toString());
			
			// open the category activity
			OpenCategoriesLayout();

		}
    }	
    
    private void OpenSettings()
    {
    	// get the preferences
        SharedPreferences settings = getSharedPreferences(PREFS_NAME, 0);
        
        // open the email
        EditText email = (EditText)findViewById(R.id.txtEmail);
        email.setText(settings.getString(
        		getResources().getString(R.string.config_email), ""));
        
        // open the password
        EditText pwd = (EditText)findViewById(R.id.txtPassword);
        pwd.setText(settings.getString(
        		getResources().getString(R.string.config_pwd), ""));
        
        // open the delivery reports
        CheckBox signin = (CheckBox)findViewById(R.id.chkSignInAuto);
        signin.setChecked(settings.getBoolean(
        		getResources().getString(R.string.config_signin), false));
        
    }
    
    private void SaveSettings(String email, String pwd)
    {
    	
    	// check if sign in auto
    	CheckBox signin = (CheckBox)findViewById(R.id.chkSignInAuto);
    	
    	SharedPreferences settings = getSharedPreferences(PREFS_NAME, 0);
		SharedPreferences.Editor editor = settings.edit();
		
		if (signin.isChecked())
		{
			// save the email
			editor.putString(
					getResources().getString(R.string.config_email), 
					email);
			
			// save the password
			editor.putString(
					getResources().getString(R.string.config_pwd), 
					pwd);
		}
		else
		{
			// clear the data
			editor.remove(getResources().getString(R.string.config_email));
			editor.remove(getResources().getString(R.string.config_pwd));
		}
		
		// save the sign in auto
		editor.putBoolean(
				getResources().getString(R.string.config_signin), 
				signin.isChecked());
		
		// Commit the edits!
		editor.commit();	
    }
    
    private void OpenCategoriesLayout()
    {   	
    	Intent i = new Intent(this, categories.class);
    	i.putExtra(getResources().getString(R.string.config_email), this._atm.getEmail());
    	i.putExtra(getResources().getString(R.string.config_pwd), this._atm.getPassword());
    	startActivityForResult(i, 1);
    }
    
}
