<?php

require_once('include/iwrapbody.inc.php');

class bodyWrap implements iWrapBody
{

    var $c;
    var $id;

    public function setIdUser($id_user)
    {
        $this->id = $id_user;
    }

    public function setConnection(&$conn)
    {
        $this->c = $conn;
    }
	
    public function getModuleName()
    {
        return "Tour module";
    }
	
    public function getHtml()
    {
        $ret =  "<div class='title_body_wrap'>
          Learn any words you like
          </div>";

        $ret .= <<<EOTEXT
            <div class='tour_desc'>
            <p>
            Think about planning a new journey in a foreign land without knowing enough words to be able to have a proper conversation with local people or having an exam where memory is involved and you have to remember many different dates. What is the best way to store all this data into your brain / Memory ?
            </p>
            <h4>
            ASK TO MYSELF!
            </h4>
            <p>
            It will ask you all the words that you have stored in its database.
            </p>
            </div>
            <div class='tour_desc'>
            <h3>
            How does it work?
            </h3>
            <p>
            You have two sides. A web interface and a client aplication.
            </p>
            <p>
            In the web interface you can manage your own categories and the words you want to learn. You can also see your results with charts and report.
            </p>
            <p>
            The client application keeps asking you (the timing  is set on your personal area on the web interface), with a special algorithm, what you want to store into your memory.
            </p>
            </div>
            <div class='sign_up_button'>
            </div>
EOTEXT;

        return $ret;
		
    }
	
}

?>
