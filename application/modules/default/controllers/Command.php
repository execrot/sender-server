<?php

class Default_Controller_Command extends Zend_Controller_Action
{
    public function writeLine($string)
    {
        printf("%s", $string."\n");
        ob_flush();
    }
}