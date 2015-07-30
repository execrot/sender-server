<?php

class IndexController extends Default_Controller_Base
{
    /**
     * @var App_Model_User
     */
    public $user = null;

    /**
     * @throws Exception
     */
    public function init()
    {
        parent::init();

        $token = $this->getRequest()->getHeader('x-auth');

        if ($token) {

            $this->user = App_Model_User::fetchOne([
                'tokens' => ['$in' => [$token]]
            ]);

            if ($this->user) {
                return;
            }
        }

        throw new Exception('Not authorized', 403);
    }

    public function sendAction()
    {
        $this->content = [];

        foreach ($this->getParam('messages', []) as $message) {

            $message = [
                'type'      => $message['type'],
                'receivers' => $message['receivers'],
                'content'   => $message['content'],
                'subject'   => empty($message['subject'])?time():$message['subject'],
                'time'      => empty($message['time'])?time():$message['time']
            ];

            $message['user'] = (string)$this->user->id;

            $queue = new App_Model_Queue($message);
            $queue->save();

            $this->content[] = ['success' => true];
        }
    }
}

