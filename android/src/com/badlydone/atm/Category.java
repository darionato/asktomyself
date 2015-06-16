package com.badlydone.atm;

public class Category {

	private int _id;
	private String _desc;
	private Boolean _shared;
	private String _wrapQ;
	private String _wrapA;
	private String _sharedby = "";
	
	public void setId(int value)
	{
		this._id = value;
	}
	
	public int getId()
	{
		return this._id;
	}
	
	public void setDescription(String value)
	{
		this._desc = value;
	}
	
	public String getDescription()
	{
		return this._desc;
	}
	
	public void setShared(Boolean value)
	{
		this._shared = value;
	}
	
	public Boolean getShared()
	{
		return this._shared;
	}
	
	public void setWrapQuestion(String value)
	{
		this._wrapQ = value;
	}
	
	public String getWrapQuestion()
	{
		return this._wrapQ;
	}
	
	public void setWrapAnswer(String value)
	{
		this._wrapA = value;
	}
	
	public String getWrapAnswer()
	{
		return this._wrapA;
	}
	
	public void setSharedBy(String value)
	{
		this._sharedby = value;
	}
	
	public String getSharedBy()
	{
		return this._sharedby;
	}
	
}
