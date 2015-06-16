<?php

require_once('include/iwrapbody.inc.php');

class myareaBody implements iWrapBody
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
        return "Welcome myarea";
    }
	
    public function getHtml()
    {
        // check if i'm loggin in
        if ($this->id <= 0)
                return LOGIN_NOT_DONE;

        // the title
        $ret = $this->getTitle();

        // show the registration form
        $ret .= $this->getDataForm();

        return $ret;

    }

    private function getTitle()
    {
        return "<div class='title_body_wrap'>Welcome in your account page</div>";
    }

    private function getDataForm()
    {

        $querystr =
        "SELECT * FROM askme_users a where a.id_user = '{$this->id}' LIMIT 1";

        $results = $this->c->query($querystr);
        if (!$results) return "";

        
        if (($row = $results->fetch_assoc()) === NULL) return "";

        $email = $row['email'];
        $firstname = htmlspecialchars($row['name'],ENT_QUOTES);
        $lastname = htmlspecialchars($row['surname'],ENT_QUOTES);
        $country = $row['country'];
        $birthday = $row['birthday'];
        $nickname = htmlspecialchars($row['nickname'],ENT_QUOTES);

        $results->close();

        $ret = <<<EOFORM
            <table class='table_form'>
                <tr>
                    <td class='form_col_des'>
                            E-mail:
                    </td>
                    <td class='form_col_input'>
                        <input class='gradient_text' type='text' size='30' name='email' maxlength='80' value='$email' />
                    </td>
                </tr>
                <tr>
                    <td class='form_col_des'>
                            Change password:
                    </td>
                    <td class='form_col_input'>
                        <input class='gradient_text' type='password' size='30' name='pass1' maxlength='15' value=""/>
                    </td>
                </tr>
                <tr>
                    <td class='form_col_des'>
                            Password (confirm):
                    </td>
                    <td class='form_col_input'>
                        <input class='gradient_text' type='password' size='30' name='pass2' maxlength='15' value=""/>
                    </td>
                </tr>
                <tr>
                    <td class='form_col_des'>
                            First name:
                    </td>
                    <td class='form_col_input'>
                        <input class='gradient_text' type='text' size='30' name='name' maxlength='30' value='$firstname' />
                    </td>
                </tr>
                <tr>
                    <td class='form_col_des'>
                            Last name:
                    </td>
                    <td class='form_col_input'>
                        <input class='gradient_text' type='text' size='30' name='surname' maxlength='30' value='$lastname' />
                    </td>
                </tr>
                <tr>
                    <td class='form_col_des'>
                            Nickname:
                    </td>
                    <td class='form_col_input'>
                        <input class='gradient_text' type='text' size='30' name='nickname' maxlength='30' value='$nickname' />
                    </td>
                </tr>
                <tr>
                    <td class='form_col_des'>
                            Country:
                    </td>
                    <td class='form_col_input'>
                      <select name='country' class='gradient_combo' id="country_sel"></select>
                      <script type="text/javascript"><!--
                            drops.fillSelect({
                            id: "country_sel",
                            code: "countries",
                            lang: "en",
                            allowVoid: true,
                            def: "$country",
                            voidMessage: "Select a country"
                      });
                      // --></script>
                    </td>
                </tr>
                <tr>
                    <td class='form_col_des'>
                            Birthday:
                    </td>
                    <td class='form_col_input'>
                        <input id='birthday_date' class='gradient_text' type='text' size='30' name='birthday' maxlength='10' value='$birthday' />
                    </td>
                </tr>
            </table>
            <br />
            <div id='span_save'>
                <span id='span_btn_user'>
                    <input id='myare_btn_save_user' class='btn' type='submit' value='Save' />
                </span>
                <span id='span_icon_user'>
                    <div id="myarea_word_progress"></div>
                </span>
            </span>
EOFORM;

        return $ret;

    }

}

?>
