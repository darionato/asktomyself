package com.badlydone.atm;

import java.util.ArrayList;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

import org.ksoap2.SoapEnvelope;
import org.ksoap2.serialization.SoapObject;
import org.ksoap2.serialization.SoapSerializationEnvelope;
import org.ksoap2.transport.AndroidHttpTransport;


@SuppressWarnings("deprecation")
public class AtmWsdl implements Runnable {

	// enum
	private enum AsyncOperation
	{
		NONE, TRY_LOGIN, GET_CATEGORIES, GET_SETTINGS, GET_QUESTION
	}
		
	// webservice config
	private static final String NAMESPACE = "urn:askmewsdl";
	private static final String URL = "http://www.asktomyself.com/service/askme.php";
	
	// general
	private static final String REGEXP_FIND_WORD = "\\d\\wòàéáéíóäëiöúàèìù ?.,;&'\\\\/\\*\\+\\-\\$\\£\\%\\(\\)";
	
	// properties variables
	private String _email;
	private String _password;
	private ArrayList<Category> _categories;
	private AsyncOperation _currentOperazion = AsyncOperation.NONE;
	private Object _lastOpetarionResult;

	// setting of atm
	private int _TimeToAskMe;
	private int _Category;
	private Boolean _Invert;
	private Boolean _DownloadImage;
	
	public Boolean getDownloadImage()
	{
		return this._DownloadImage;
	}
	
	public Boolean getInvert()
	{
		return this._Invert;
	}
	
	public int getCategory()
	{
		return this._Category;
	}
	
	public int getTimeToAskMe()
	{
		return this._TimeToAskMe;
	}
	
	public ArrayList<Category> getCategories()
	{
		return _categories;
	}
	
	public String getPassword()
	{
		return this._password;
	}
	
	public void setPassword(String value)
	{
		this._password = value;
	}
	
	public String getEmail()
	{
		return this._email;
	}
	
	public void setEmail(String value)
	{
		this._email = value;
	}
	
	// get soap object with user, password
	private SoapObject getNewSoap(String method_name)
	{
		// create the parameters
		SoapObject request = new SoapObject(NAMESPACE, method_name);
        request.addProperty("user", this._email);
        request.addProperty("pass", this._password);
        
        // special cases
        if (this._currentOperazion == AsyncOperation.GET_QUESTION)
        	request.addProperty("category", this._Category);
        
        return request;
	}
	
	private void RunWaitThread()
	{
		
		// set the default value
		this._lastOpetarionResult = null;
		
		// throw the opereation in a thread
		Thread thread = new Thread(this);
		thread.run();
    	
    	// check if is aready death
    	if (!thread.isAlive()) 
    	{		
    		return;
    	}
    	

    	// wait max 3 seconds
    	long delay = 3000;
    	
    	try 
    	{
    		// wait
    	    thread.join(delay);
    	    
    	    // if not live, it's finished
    	    if (!thread.isAlive()) 
	    	{
		    	return;
	    	}
	    	
    	} catch (InterruptedException e) {
    		// interupt
    		e.printStackTrace();
    	}

    	// wait the rest of time to end the process
    	try {
    	    thread.join();
    	} catch (InterruptedException e) {
    		// interupt
    		e.printStackTrace();
    	}
    	
    	// finished!

	}
	
	// return if login pass out
	public Boolean TryLogin()
	{
		
		// set the operation to do
		this._currentOperazion = AsyncOperation.TRY_LOGIN;
		
		// run the request
		this.RunWaitThread();

		// check the result   	
        if (_lastOpetarionResult == null) return false;
        
        return (Boolean)_lastOpetarionResult;

	}
	
	// get the user settings
	public void FethSettings()
	{
		
		// set the operation to do
		this._currentOperazion = AsyncOperation.GET_SETTINGS;
		
		// run the request
		this.RunWaitThread();
		
		// check the result   	
        if (_lastOpetarionResult == null) return;
    	
        String c = (String)_lastOpetarionResult;
        
        // create the RE
        String patternStr = "\\(([\\w]+):([\\d|\\w ]+)\\)";
        
        Pattern pattern = Pattern.compile(patternStr);

        // apply the patter to the string
        Matcher matcher = pattern.matcher(c);
        
        // loop the string
        while (matcher.find())
        {
        	switch (Integer.parseInt(matcher.group(1)))
            {
                case 1: // time_out_ask
                    this._TimeToAskMe = Integer.parseInt(matcher.group(2));
                    break;
                case 2: // last_category
                	this._Category = Integer.parseInt(matcher.group(2));
                    break;
                case 3: // invert
                	this._Invert = (matcher.group(2) == "1" ? true : false);
                    break;
                case 4: // dowload_image
                	this._DownloadImage = (matcher.group(2) == "1" ? true : false);
                    break;
            }
        }
	}
	
	public QuestionStruct getQuestion()
	{
		
		// set the operation to do
		this._currentOperazion = AsyncOperation.GET_QUESTION;
		
		// run the request
		this.RunWaitThread();
        
		// check the result   	
        if (_lastOpetarionResult == null) return null;
    	
        String c = (String)_lastOpetarionResult;
        
        // check if it has values
        if (c.length() == 0)
            return null;
        
        // "\(([0-9]+):([{0}]+):([{0}]+)\)"
        
        // create the RE
        String patternStr = String.format("\\(([0-9]+):([%s]+):([%s]+)\\)",
        		REGEXP_FIND_WORD, REGEXP_FIND_WORD);
		
        Pattern pattern = Pattern.compile(patternStr);

        // return class
        QuestionStruct ret = new QuestionStruct();
        
        // apply the patter to the string
        Matcher matcher = pattern.matcher(c);
        
        if (matcher.find())
        {
        	
        	ret.setId(Integer.parseInt(matcher.group(1)));
        	ret.setFrom(matcher.group(2));
        	ret.setTo(matcher.group(3));
        	
        	// till now the image is null
        	ret.setThunbnail(null);
        	
        }
        
        return ret;
        
	}
	
	// get the user categories
	public void FethCategories()
	{
		
		// set the operation to do
		this._currentOperazion = AsyncOperation.GET_CATEGORIES;
		
		// run the request
		this.RunWaitThread();
        
		// check the result   	
        if (_lastOpetarionResult == null) return;
    	
        String c = (String)_lastOpetarionResult;
        
        
        // create the RE
        String patternStr = String.format(
				"\\(\\[([\\d]+)\\],\\[([0-1])\\],\\[([%s]*)\\],\\[([%s]*)\\],\\[([%s]*)\\]\\)",
        		REGEXP_FIND_WORD, REGEXP_FIND_WORD, REGEXP_FIND_WORD);
        
        
        Pattern pattern = Pattern.compile(patternStr);

        // apply the patter to the string
        Matcher matcher = pattern.matcher(c);
        
        // list of categories
        _categories = new ArrayList<Category>();
		
        // regexp for split the share by
        Pattern patt_sh = Pattern.compile("([\\w\\W]+) by ([\\w]+)");
        
        // loop the string
        while (matcher.find())
        {
        	
        	// create the new category
    		Category cat = new Category();
    		// set the id
    		cat.setId(Integer.parseInt(matcher.group(1)));
    		
    		// split the desc for get the shared
    		Matcher ms = patt_sh.matcher(matcher.group(3));
    		if (ms.find())
    		{
    			cat.setDescription(ms.group(1));
    			cat.setSharedBy(ms.group(2));
    		}
    		else
    			cat.setDescription(matcher.group(3));
    		// check if is shared
    		cat.setShared(matcher.group(2).compareTo("1") == 0);
    		// get the wrap question
    		cat.setWrapQuestion(matcher.group(4));
    		// get the wrap answer
    		cat.setWrapAnswer(matcher.group(5));
    		
    		// add the category to the list
    		_categories.add(cat);
    		
        }
		
	}
	
	// soap call
	private Object getSoapCall(SoapObject request)
    {
		
		// action
        String SOAP_ACTION = "urn:askmewsdl#" + request.getName();
        
        // web service envelope
        SoapSerializationEnvelope envelope = new SoapSerializationEnvelope(SoapEnvelope.VER11);
        envelope.dotNet = false;
        envelope.setOutputSoapObject(request);
        
        // create the transport
        AndroidHttpTransport ht = new AndroidHttpTransport(URL);
        ht.debug = true;
    	
        // set the return value
        Object ret = null;
        
        // call the method
        try
        {
            ht.call(SOAP_ACTION, envelope);
            ret = envelope.getResponse();   
        }
        catch(Exception e)
        {
            e.printStackTrace();
        }
        
        return ret;
        
    }

	public void run() 
	{
		
		String ope = "";
		
		// select the operation to do
		switch (this._currentOperazion) {
		case TRY_LOGIN:
			ope = "try_login";
			break;
		case GET_CATEGORIES:
			ope = "get_categories";
			break;
		case GET_SETTINGS:
			ope = "get_settings";
			break;
		case GET_QUESTION:
			ope = "get_question";
			break;
		default:
			break;
		}

		// create the soap request
		SoapObject request = this.getNewSoap(ope);
        
        // soap calling
        _lastOpetarionResult = this.getSoapCall(request);
		
	}
	
}
