<?php

abstract class Default_Controller_Base extends Zend_Controller_Action
{
    /**
     * @var stdCLass
     */
    public $content = null;

    /**
     * @var int
     */
    public $statusCode = 200;

    /**
     * Initialize content
     */
    public function init()
    {
        parent::init();

        $this->content = new stdCLass();
    }

    /**
     * Rendering content to json
     */
    public function postDispatch()
    {
        /**
         * Checking status code (it must be not less than 100 and not more than 599 )
         * In case when its wrong it will be set to 500
         */
        $this->statusCode = 100 > $this->statusCode || 599 < $this->statusCode?
            500:
            $this->statusCode;

        $this->getResponse()
            ->setHttpResponseCode((int)$this->statusCode)
            ->setHeader('Content-Type', 'json')
            ->setBody($this->_helper->json($this->content))
            ->sendResponse();
    }
}