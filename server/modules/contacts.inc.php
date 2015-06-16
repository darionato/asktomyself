<?php

require_once('include/iwrapbody.inc.php');
include_once('include/config.php');

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
        return "Contacts module";
    }
	
    public function getHtml()
    {

        $twitter = TWITTER_PAGE;
        $email = EMAIL_ADDRESS;

        $ret .= <<<EOTEXT
            <div class='email_div'>
            <p>
            For any enquiries or feedback write to <b><a href="mailto:$email">$email</a></b>.
            </p>
            </div>
            <div class='buy_a_beer'>
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                <input type="hidden" name="cmd" value="_s-xclick">
                <input type="hidden" name="hosted_button_id" value="BFQ3LZ26ZS8B8">
                <input type="image" src="http://www.asktomyself.com/images/buy_me_a_beer.png" border="0" name="submit" alt="PayPal - Il sistema di pagamento online più facile e sicuro!">
                <img alt="" border="0" src="https://www.paypal.com/it_IT/i/scr/pixel.gif" width="1" height="1">
                </form>
            </div>
            <div class="twitter_log">
            <p>
             <a href="$twitter">Follow us</a> on Twitter for change-log, news and feedback.
            </p>
            <script src="http://widgets.twimg.com/j/2/widget.js"></script>
            <script>
            new TWTR.Widget({
              version: 2,
              type: 'profile',
              rpp: 10,
              interval: 6000,
              width: 500,
              height: 500,
              theme: {
                shell: {
                  background: '#333333',
                  color: '#ffffff'
                },
                tweets: {
                  background: '#fafafa',
                  color: '#404040',
                  links: '#782121'
                }
              },
              features: {
                scrollbar: false,
                loop: false,
                live: false,
                hashtags: true,
                timestamp: true,
                avatars: false,
                behavior: 'all'
              }
            }).render().setUser('asktomyself').start();
            </script>
            </div>
EOTEXT;

        return $ret;
		
    }
	
}

?>
