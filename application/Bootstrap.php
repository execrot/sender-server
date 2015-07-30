<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * Now configuration are available from the Registry
     *
     * @return void
     */
    protected function _initConfig()
    {
        Zend_Registry::set('config', $this->getOptions());
    }

    /**
     * Initialize pseudo-namespaces,
     * auto-loader and resource groups
     *
     * @return void
     */
    protected function _initAutoloader()
    {
        $moduleLoader = new Zend_Application_Module_Autoloader([
            'namespace' => ucfirst('Default'),
            'basePath' => APPLICATION_PATH.'/modules/default'
        ]);

        $moduleLoader->addResourceTypes([
            'controller' => [
                'namespace' => 'Controller',
                'path' => 'controllers'
            ]
        ]);

        $appResources = new Zend_Loader_Autoloader_Resource([
            'basePath' => APPLICATION_PATH,
            'namespace' => 'App',
        ]);

        $appResources->addResourceTypes([
            'exceptions' => [
                'namespace' => 'Exception',
                'path' => 'exceptions'
            ],
            'models' => [
                'namespace' => 'Model',
                'path' => 'models'
            ],
            'services' => [
                'namespace' => 'Service',
                'path' => 'services'
            ],
        ]);
    }

    /**
     * @throws Zend_Exception
     */
    protected function _initDb()
    {
        $config = Zend_Registry::get('config');
        Mongostar_Model::setConfig($config['db']);
    }

    /**
     * Initialize error-handler
     * On all notices, warnings and errors will be thrown App_Exception_Error
     *
     * @return void
     */
    protected function _initErrorHandler()
    {
        set_error_handler(function($number, $message, $file, $line) {
            throw new Exception($message.":".$file.":".$line, 404);
        });
    }
}

