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
        return "Login module";
    }
	
    public function getHtml()
    {

        $error_login = '';

        // check if before i wrong the login
        if (isset($_POST['email']) && 
                isset($_POST['userpass']) &&
                $this->id == 0)
        {
            // login wrong
            $error_login = 
                '<div class="text_error">E-mail or password wrong. Try again!</div>';
        }

        $ret =  <<<EOLOGIN
          <form align='center' action='index.php?ptg=myarea' method='POST'>
          <div class='title_body_wrap'>
          Get into your area:
          </div>
          $error_login
          <table class='table_form'>
          <tr>
                <td class='form_col_des'>E-mail:</td>
                <td class='form_col_input'>
                  <input class='gradient_text' type='text' name='email' size='20' maxlength='80'/>
                </td>
          </tr>
          <tr>
                <td class='form_col_des'>Password:</td>
                <td class='form_col_input'>
                  <input class='gradient_text' type='password' name='userpass' size='20' maxlength='15'/>
                </td>
          </tr>
          </table>
          <br />
          <p align='center'><input class='btn' type='submit' value='Login'/></p>
          </form>
          <div class="banner_468x60">
				<script type="text/javascript"><!--
					google_ad_client = "pub-7039402606733573";
					/* AskToMyself 468x60, creato 10/09/10 */
					google_ad_slot = "2687779765";
					google_ad_width = 468;
					google_ad_height = 60;
					//-->
					</script>
					<script type="text/javascript"
					src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				</script>
			</div>
EOLOGIN;

        return $ret;
		
	}
	
}

?>
