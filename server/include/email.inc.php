<?php

    class sendEmailEngine
    {

        private	$_pathHtmlMail;
        private $_pathTextMail;
        public $textHtmlMail;
        public $textTextMail;
        private $_emailFrom;
        private $_emailTo;
        private $_caption;
        private $_subject;

        private function getFile($pathFile)
        {

            if (@!$nf = fopen($pathFile,'r')) {
                    return "";
            }

            $l = filesize($pathFile);

            $t = fread($nf, $l);

            fclose($nf);

            return $t;

        }

        function setSubject($value)
        {
            $this->_subject = $value;
        }

        function getSubject()
        {
            return $this->_subject;
        }

        function setCaption($value)
        {
            $this->_caption = $value;
        }

        function getCaption()
        {
            return $this->_caption;
        }

        function setPathHtmlMail($value)
        {
            $this->_pathHtmlMail = $value;
            $this->textHtmlMail = $this->getFile($value);
        }

        function setPathTextMail($value)
        {
            $this->_pathTextMail = $value;
            $this->textTextMail = $this->getFile($value);
        }

        function setEMailFrom($value)
        {
            $this->_emailFrom = $value;
        }

        function setEMailTo($value)
        {
            $this->_emailTo = $value;
        }

        function getEMailTo()
        {
            return $this->_emailTo;
        }

        function sendEmail()
        {

            // create the string separator
            $boundary = "==String_Boundary_x" .sha1(time()). "x";


            // create the header
            $header = "From: $this->_caption <{$this->_emailFrom}>\n";
            $header .= "BCC: $this->_caption <{$this->_emailFrom}>\n";
            $header .= "X-Mailer: " . str_replace(" ", "", $this->_caption) . "WebMail\n";
            $header .= "MIME-Version: 1.0\n";
            $header .= "Content-Type: multipart/alternative;\n";
            $header .= " boundary=\"$boundary\";\n\n";


            // create the body in text format
            $body = "MIME non supportati\n\n";
            $body .= "--$boundary\n";
            $body .= "Content-Type: text/plain; charset=\"iso-8859-1\"\n";
            $body .= "Content-Transfer-Encoding: 7bit\n\n";
            $body .= $this->textTextMail . "\n\n";


            // create the body in html format
            $body .= "--$boundary\n";
            $body .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
            $body .= "Content-Transfer-Encoding: 7bit\n\n";
            $body .= $this->textHtmlMail . "\n";
            $body .= "--$boundary--\n";


            // send the mail
            return (mail($this->_emailTo, $this->_subject,
                    $body,$header, "-f$this->_emailFrom"));


        }

    }

?>
