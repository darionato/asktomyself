<?php

    require_once('email.inc.php');
    include_once('config.php');

    class sendEmailEngineAtm extends sendEmailEngine
    {

        private $_pass;

        function __construct()
        {
            $this->setCaption("Ask to myself");
            $this->setEMailFrom("info@asktomyself.com");
        }

        function setPassword($value)
        {
            $this->_pass = $value;
        }

        function sendEmailRegistration()
        {

            $this->setSubject($this->getCaption() . " - registration");
            $this->setPathHtmlMail("templates/email/email_reg.html");
            $this->setPathTextMail("templates/email/email_reg.txt");

            //replace the email
            $this->textHtmlMail = str_replace('---email---', 
                    $this->getEMailTo(), $this->textHtmlMail);
            $this->textTextMail = str_replace('---email---',
                    $this->getEMailTo(), $this->textTextMail);

            //replace the password
            $this->textHtmlMail = str_replace('---pass---',
                    $this->_pass, $this->textHtmlMail);
            $this->textTextMail = str_replace('---pass---',
                    $this->_pass, $this->textTextMail);

            //replace the atm email
            $this->textHtmlMail = str_replace('---email-atm---',
                    EMAIL_ADDRESS, $this->textHtmlMail);
            $this->textTextMail = str_replace('---email-atm---',
                    EMAIL_ADDRESS, $this->textTextMail);

            //replace the skype name
            $this->textHtmlMail = str_replace('---skype---',
                    SKYPE_NAME, $this->textHtmlMail);
            $this->textTextMail = str_replace('---skype---',
                    SKYPE_NAME, $this->textTextMail);

            //replace the website name
            $this->textHtmlMail = str_replace('---sitoweb---',
                    WEBSITE_ADDRESS, $this->textHtmlMail);
            $this->textTextMail = str_replace('---sitoweb---',
                    WEBSITE_ADDRESS, $this->textTextMail);

            //replace the twitter name
            $this->textHtmlMail = str_replace('---twitter---',
                    TWITTER_PAGE, $this->textHtmlMail);
            $this->textTextMail = str_replace('---twitter---',
                    TWITTER_PAGE, $this->textTextMail);

            return sendEmailEngine::sendEmail();

        }

    }

?>
