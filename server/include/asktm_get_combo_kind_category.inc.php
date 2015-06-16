<?php

class asktm_get_combo_kind_category {

    var $c;
    var $first_element;
    var $width = 170;

    public function __construct() {
        $this->first_element = 'Select type of category...';
    }

    public function setFirstElement($value)
    {
        $this->first_element = $value;
    }

    public function setWidth($value)
    {
        $this->width = $value;
    }

    public function setConnection(&$conn)
    {
        $this->c = $conn;
    }
    
    public function getComboKindCategory()
    {

        // get the record with categories
        $querystr = <<<EOQUERY
            SELECT * FROM askme_kind_category a
            ORDER BY a.`desc` LIMIT 0,10
EOQUERY;

        $results = $this->c->query($querystr);
        if ($results === FALSE)
                return "";

        $ret = '<select class="gradient_combo" id="id_kind_category" '.
            'style="margin-right: 10px; width: '.$this->width.'px;">';
        $ret .= "<option value='0'>";
        $ret .= $this->first_element;
        $ret .= "</option>";

        while (($row = $results->fetch_assoc()) !== NULL)
        {
            $ret .= "<option value='{$row['id_kind_category']}'>";
            $ret .= $row['desc'];
            $ret .= "</option>";
        }

        $ret .= "</select>";

        $results->close();

        return $ret;

    }

}
?>
