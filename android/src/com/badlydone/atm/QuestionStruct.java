package com.badlydone.atm;

public class QuestionStruct {

        private int Id;
        private String From;
        private String To;
        private Object Thunbnail;

        public int getId()
        {
        	return Id;
        }
        
        public String getFrom()
        {
        	return From;
        }
        
        public String getTo()
        {
        	return To;
        }
        
        public Object getThunbnail()
        {
        	return Thunbnail;
        }
        
        public void setId(int value)
        {
        	Id = value;
        }
        
        public void setFrom(String value)
        {
        	From = value;
        }
        
        public void setTo(String value)
        {
        	To = value;
        }
        
        public void setThunbnail(Object	value)
        {
        	Thunbnail = value;
        }
	
}
