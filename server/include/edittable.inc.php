<?php

/**
 * Description of edittableinc
 *
 * passing a query and connection, create a table with edit fields
 *
 * @author dario
 */
class edittableinc {

    private $c;
    private $q;
    private $_allowDeleteRow;
    private $_allowAddNew;
    private $_addTitles;
    private $_addDescTitles;
    private $_checkColumns;
    private $_firstColId;
    private $_editColumns;
    private $_checkedValue;
    private $_addButtons;

    function  __construct(&$conn, $querystr) {

        $this->c = $conn;
        $this->q = $querystr;

        // init with deafault values variables
        $this->_allowDeleteRow = false;
        $this->_allowAddNew = false;
        $this->_addTitles = false;
        $this->_firstColId = true;
        $this->_editColumns = array();
        $this->_addDescTitles = array();
        $this->_checkColumns = array();
        $this->_addButtons = array();
        $this->_checkedValue = 1;

    }

    function setcheckedValue($value)
    {
        $this->_checkedValue = $value;
    }

    function addDescTitles($col, $desc)
    {
        $this->_addDescTitles[$col] = $desc;
    }

    function addButtons($name, $title)
    {
        $this->_addButtons[$name][0] = $name;
        $this->_addButtons[$name][1] = $title;
    }

    function addEditColumn($name)
    {
        $this->_editColumns[$name] = 1;
    }

    function addCheckColumn($name)
    {
        $this->_checkColumns[$name] = 1;
    }

    function firstColId($value)
    {
        $this->_firstColId = $value;
    }

    function allowAddNew($value)
    {
        $this->_allowAddNew = $value;
    }

    function allowDeleteRow($value)
    {
        $this->_allowDeleteRow = $value;
    }

    function addTitles($value)
    {
        $this->_addTitles = $value;
    }

    function getEditTable()
    {

        // run the query
        $result = $this->c->query($this->q);

        // is no results, return a empty string
        if ($result === FALSE) return "";


        // start create table
        $table = '<table class="et_table" id="' . $this->getName() . '">';


        // get field information
        $finfo = $result->fetch_fields();


        // if add titles then add it
        if ($this->_addTitles)
        {
            $table .= "<tr class=\"et_row_title\">";

            foreach ($finfo as $val)
            {

                if (isset($this->_addDescTitles[$val->name]))
                    $name_col = $this->_addDescTitles[$val->name];
                else
                    $name_col = $val->name;

                $table .= "<td class=\"col_".$this->fN($val->name).
                            "\"><b>$name_col</b></td>";
                
            }
            if ($this->_allowDeleteRow or $this->_allowAddNew)
                    $table .= "<td>&nbsp;</td>";
            
            if (count($this->_editColumns)>0) $table .= "<td>&nbsp;</td>";

            $table .= str_repeat("<td>&nbsp;</td>",
                    count($this->_addButtons.length));

            $table .= "</tr>";

        }


        // if add new, i add few textbox to insert values
        if ($this->_allowAddNew)
        {
            $table .= "<tr class=\"et_row_new\">";

            foreach ($finfo as $val)
            {
                if (isset ($this->_editColumns[$val->name]) and
                    $this->_editColumns[$val->name] == 1)
                {
                    if (isset ($this->_checkColumns[$val->name]) and
                        $this->_checkColumns[$val->name] == 1)
                        // check column
                        $name_col = "<input type=\"checkbox\" class=\"et_check\" />";
                    else
                        // text column
                        $name_col = "<input class=\"gradient_text\" type=\"text\" value=\"\" />";
                }
                else
                    $name_col = "&nbsp;";

                $table .= "<td class=\"col_".$this->fN($val->name)."\">$name_col</td>";

            }
            $table .= '<td><a class="et_add_row" href="#">'
                        .'<span>add</span></a></td>';
            
            if (count($this->_editColumns)>0) $table .= "<td>&nbsp;</td>";

            $table .= str_repeat("<td>&nbsp;</td>",
                    count($this->_addButtons.length));

            $table .= "</tr>";
        }
        

        // run the query
        while (($row = @$result->fetch_assoc()) !== NULL)
        {

            // add new row
            $table .= "<tr>";

            // cicle the values
            foreach($row as $key => $value)
            {

                // add the column
                $table .= "<td class=\"col_".$this->fN($key)."\">";

                // write the value
                if (isset ($this->_editColumns[$key]) and
                        $this->_editColumns[$key] == 1)
                {
                    if (isset ($this->_checkColumns[$key]) and
                            $this->_checkColumns[$key] == 1)
                    {
                        // check column
                        $table .= "<input type=\"checkbox\" class=\"et_check\" "
                            . ($value == 1?'checked':'') . " />";
                    }
                    else
                    {
                        // text column
                        $table .= "<input type=\"text\" class=\"et_text\" "
                            . "value=\"$value\" />";
                    }
                }
                else
                {
                    // just value comun
                    $table .= "<span>$value</span>";
                }

                // close the column
                $table .= "</td>";

            }

            // add delete row
            if ($this->_allowDeleteRow)
                $table .= '<td><a title="Delete" class="et_del_row" href="#">'
                    .'<span>del</span></a></td>';
            else if ($this->_allowAddNew)
                $table .= "<td>&nbsp;</td>";


            // add save if edit
            if (count($this->_editColumns) > 0)
                $table .= '<td><a title="Save" class="et_save_row" href="#">'
                    .'<span>save</span></a></td>';

            // add customs button
            if (!count($this->_addButtons) ==0)
            {
                foreach ($this->_addButtons as $btn_details)
                {
                    $table .= '<td><a title="'.$btn_details[1].
                        '" class="'.$btn_details[0].'" href="#">'
                        .'<span>btn</span></a></td>';
                }
            }

            // close the row
            $table .= "</tr>";

        }

        $table .= "</table>";

        // return the table
        return $table;

    }

    private function fN($value)
    {
        return str_replace(' ', '_', $value);
    }

    private function getName()
    {
        $reg = "/INNER JOIN ([\w]+) ([\w ]+) ON/i";
        if (preg_match($reg, $this->q, $matches))
            return $matches[1];

        $reg = "/FROM ([\w]+)/i";
        preg_match($reg, $this->q, $matches);
        return $matches[1];
    }

}
?>
