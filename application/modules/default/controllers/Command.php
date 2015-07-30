<?php

class Default_Controller_Command extends Zend_Controller_Action
{
    public function writeLine($string)
    {
        printf($string."\n");
        ob_flush();
    }
}