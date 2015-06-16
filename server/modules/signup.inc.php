<?php

require_once('include/iwrapbody.inc.php');
require_once('include/emailatm.inc.php');
require_once('login/user_manager.inc.php');
require_once('recaptchalib.php');

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
        return "Sign Up module";
    }
	
    public function getHtml()
    {
        
        $sect = "";
        if (isset($_GET['sct']) && !$_GET['sct'] == '')
                $sect = $_GET['sct'];

        if (strlen($sect) == 0)
        {
            // show the registration form
            return $this->getSighUpForm();
        }
        else if ($sect == "newuser")
        {

            // check for captcha
            $privatekey = "6LeKI7oSAAAAAAf_J_jhV05yFV7fruz4Gr7Zxcjs";
            $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

            if (!$resp->is_valid) {
                Return "The reCAPTCHA wasn't entered correctly. Go back and try it again.<br />" .
                   "(reCAPTCHA said: " . $resp->error . ")";
            }

            // make the registration
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $pw1 =  isset($_POST['pass1']) ? $_POST['pass1'] : '';
            $pw2 =  isset($_POST['pass2']) ? $_POST['pass2'] : '';
            

            // create the new user manager
            $usermgr = new UserManager();


            // check data
            if ($email == '' or
                    !$usermgr->isValidEmail($email))
                    return "Sorry but the insert e-mail isn't correct.";

            if ($pw1 == '' or
                    $pw1 !== $pw2)
                    return "Empty password or not equal with the second one.";

            if ($usermgr->eMailExists($email, $this->c))
                    return "Sorry but the insert e-mail already exists. Try again with another e-mail.";
           
            
            // add the new user
            $new_id = $usermgr->createAccount($email, $pw1);

            if ($new_id)
            {
                //send the mail
                $send = new sendEmailEngineAtm();
                $send->setEMailTo($email);
                $send->setPassword($pw1);
                $send->sendEmailRegistration();
                
                return <<<EOREG
                Registration successful done! We sent the confirm to: <b>$email</b><br/>
                Please, click <a href='index.php?ptg=login'>here</a> to
                log in or click <a href='index.php'>here</a> to visit the home page.
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
EOREG;
            }

        }
        
    }

    private function getSighUpForm()
    {

        $publickey = "6LeKI7oSAAAAANVHIfC2RNWa6L8tAQHyuD1Ayk5r";

        $ret = <<<EOFORM
            <div class='title_body_wrap'>
            Please, enter yours information:
            </div>
            <form onsubmit='return formValidator()' action='index.php?ptg=signup&sct=newuser' method='post'>
                <table class='table_form'>
                    <tr>
                        <td class='form_col_des'>
                                E-mail:
                        </td>
                        <td class='form_col_input'>
                                <input class='gradient_text' type='text' size='30' name='email' maxlength='80'/>
                        </td>
                    </tr>
                    <tr>
                        <td class='form_col_des'>
                                Password:
                        </td>
                        <td class='form_col_input'>
                                <input class='gradient_text' type='password' size='30' name='pass1' maxlength='15'/>
                        </td>
                    </tr>
                    <tr>
                        <td class='form_col_des'>
                                Password (confirm):
                        </td>
                        <td class='form_col_input'>
                                <input class='gradient_text' type='password' size='30' name='pass2' maxlength='15'/>
                        </td>
                    </tr>
                    <tr>
                        <td class='form_col_des'>
                            <input name="agree_terms" value="true" id="agree_terms" type="checkbox" class="checkbox">
                        </td>
                        <td class='form_col_input'>
                        <label for="agree_terms" id="terms_label">
                          I agree with the <a id="click_tc" href="pages/terms_and_conditions.html" title="Terms &amp; Conditions" id="terms-popup" target="_blanck">Terms &amp; Conditions</a>.
                        </label>
                        </td>
                    </tr>
                </table>
                <br /><div class='signin_captcha'>
EOFORM;

        $ret .= recaptcha_get_html($publickey) .
                "</div><br />
                <p align='center'>
                <div id='btn_create_account_div'>
                    <input id='btn_create_account' class='btn' type='submit' value='Create account' />
                </div>
                </p>
            </form>";

        return $ret;

    }
	
}

?>
