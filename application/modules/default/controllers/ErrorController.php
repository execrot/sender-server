<?php

class ErrorController extends Default_Controller_Base
{
    /**
     * Container with error description
     *
     * @var ArrayObject
     */
    protected $_errors = null;

    /**
     * Initialize error description
     */
    public function init()
    {
        parent::init();

        $errors = $this->_getParam('error_handler');

        if (!$errors || !$errors instanceof ArrayObject) {
            $this->message = 'You have reached the error page';
            return;
        }

        switch ($errors->type) {

            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:

                $this->statusCode = 404;
                $this->content->message = 'Method does not exists';
                break;

            default:
                // application error
                $this->statusCode = $errors->exception->getCode();
                $this->content->message = $errors->exception->getMessage();
                break;
        }
    }

    public function errorAction() {}
}

