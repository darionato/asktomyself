<?php

require_once('include/asktm.inc.php');

session_start();

// start the mail class that on the costructor check if i'm loged in
$ask = new asktm();

// get the login link
$login_link = ($ask->isLogginIn()?'logout':'login');

// get the name of logged user
$name_user = '<a href="index.php?ptg=myarea">'.
    ($ask->isLogginIn()?$ask->getNameLoggedUser($ask->IdLoggedUser()):'').
            '</a>';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Ask to myself - all your words belong to us</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 0.18" />
        <meta name="Author" content="Darion Badlydone" />
        <meta name="description" CONTENT="With this tool you can learn a lot of new words about any topic in an easier way" />
        <meta name="keywords" lang="en-us"
         content="learn, words, foreign, question, language, ask, teach, ask me, learn new word, learn foreign language" />
        <meta name="keywords" lang="en"
         content="learn, words, foreign, question, language, ask, teach, ask me, learn new word, learn foreign language" />
        <meta name="keywords" lang="it"
         content="imparare, parole, domandare, straniera, lingua, chiedere, insegnare, chiedimi, domandami, imparare nuove parole, imparare una lingua straniera" />
        <meta name="robots" CONTENT="INDEX,FOLLOW" />
	<script type="text/javascript" src="script/jquery.js"></script>
	<script type="text/javascript" src="script/jquery.position.js"></script>
	<script type="text/javascript" src="script/jquery.menu.top.js"></script>
	<script type="text/javascript" src="script/jquery.myarea.js"></script>
	<script type="text/javascript" src="script/jquery.edtable.js"></script>
        <script type="text/javascript" src="script/jquery.tour.js"></script>
        <?php
        $p = $ask->getPageToGo();
        if ($p == 'signup' ||
                ($p == 'myarea' && $ask->getSectionToGo() == 'account'))
        {
                $script = <<<EOSCRIPT
        <script type="text/javascript" src="script/jquery-ui-1.8.4.custom.min.js"></script>
        <link rel="stylesheet" href="css/jquery-ui-1.8.4.custom.css" media="all" type="text/css" />
	<script type="text/javascript" src="http://www.lonelydrops.com/drops/1.0/core.js"></script>
	<script type="text/javascript" src="http://www.lonelydrops.com/drops/1.0/list/en/countries"></script>
	<script type="text/javascript" src="script/jquery.signup.js"></script>
EOSCRIPT;
                echo($script);
        }
        ?>
        <script type="text/javascript" src="script/jquery.getit.js"></script>
	<link rel="stylesheet" href="css/asktomyself.css" media="all" type="text/css" />
	<link rel="stylesheet" href="css/asktomyself_edittable.css" media="all" type="text/css" />
	<link rel="stylesheet" href="css/asktomyself_myarea.css" media="all" type="text/css" />
	<link rel="stylesheet" href="css/asktomyself_charts.css" media="all" type="text/css" />

	<script type="text/javascript">
		var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
		document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
	</script>
	<script type="text/javascript">
		try {
			var pageTracker = _gat._getTracker("UA-15592884-1");
			pageTracker._trackPageview();
		} catch(err) {}
	</script>
	<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
	<script type="text/javascript">stLight.options({publisher:'0b0e86a4-2a1f-4c03-ac6b-cfce411b71dc'});</script>
</head>

<body id="asktomyself">
    <div id="all_page">
        <div id="page_header">
            <div id="menu_top">
                <div class="inner_top">
                    <div class="login_user_name"><?php echo(strtolower($name_user)); ?></div>
                     <ul id="id_tabs_login" class="tabs_nav">
                         <li>
                             <a id="id_contacts" class="contacts<?php echo($ask->getPageToGo()=="contacts"?"_in":""); ?>" href="index.php?ptg=contacts">
                                 <span>CONTACTS</span>
                             </a>
                         </li>
                         <li>
                             <a id="id_charts" class="charts<?php echo($ask->getPageToGo()=="charts"?"_in":""); ?>" href="index.php?ptg=charts">
                                 <span>CHARTS</span>
                             </a>
                         </li>
                         <li>
                             <a id="id_getit" class="getit<?php echo($ask->getPageToGo()=="getit"?"_in":""); ?>" href="index.php?ptg=getit">
                                 <span>GET IT</span>
                             </a>
                         </li>
                         <li>
                             <a id="id_support" class="support<?php echo($ask->getPageToGo()=="support"?"_in":""); ?>" href="index.php?ptg=support">
                                 <span>CONTACTS</span>
                             </a>
                         </li>
                         <li>
                             <a id="id_signup" class="signup<?php echo($ask->getPageToGo()=="signup"?"_in":""); ?>" href="index.php?ptg=signup">
                                 <span>SIGN UP</span>
                             </a>
                         </li>
                         <li>
                             <a id="id_login" class="<?php echo($login_link . ($ask->getPageToGo()=="login"?"_in":"")); ?>" href="index.php?ptg=<?php echo($login_link) ?>">
                                 <span>LOGIN</span>
                             </a>
                         </li>
                     </ul>
                 </div>
            </div>
            <div id="title_section">
                <a id="title" title="Home" href="./index.php">Ask to myself!</a>
                <div id="share_bar">
                    <span class="st_twitter_large" displayText="Tweet"></span>
                    <span class="st_facebook_large" displayText="Facebook"></span>
                    <span class="st_ybuzz_large" displayText="Yahoo! Buzz"></span>
                    <span class="st_gbuzz_large" displayText="Google Buzz"></span>
                    <span class="st_email_large" displayText="Email"></span>
                    <span class="st_sharethis_large" displayText="ShareThis"></span>
                </div>
            </div>
        </div>
        <div id="wrap_body">
                <?php echo($ask->getWrapBody()); ?>
        </div>
        <!--<div id="page_pre_footer"></div>
        <div id="page_footer"></div>-->
    </div>
</body>
</html>
<?php $ask = null; ?>
