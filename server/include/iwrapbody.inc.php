<?php

interface iWrapBody
{
    public function setIdUser($id_user);
    public function setConnection(&$conn);
    public function getModuleName();
    public function getHtml();
}

?>
