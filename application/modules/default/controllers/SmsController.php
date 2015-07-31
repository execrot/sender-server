<?php

class SmsController extends Default_Controller_Command
{
    public function indexAction()
    {
        $config = Zend_Registry::get('config')['sender'];

        do {

            $message = App_Model_Queue::pop(App_Model_Queue::SMS);

            if ($message) {

                $user = App_Model_User::fetchOne([
                    'id' => (string)$message->user
                ]);

                $settings = $user->data['sms'];
                $settings['uri'] = $config['sms']['uri'];

                \Smsc\Smsc::setConfig($settings);

                $sms = new \Smsc\Smsc();

                $this->writeLine("------------------------------------------------");
                $this->writeLine("------------------------------------------------");
                $this->writeLine("sending message: " . $message->content);
                $this->writeLine("to: " . implode(', ', array_values($message->receivers)));
                $this->writeLine("from: " . $user->data['sms']['sender']);

                $sms->setReceivers($message->receivers);
                $sms->setMessage($message->content);

                $this->writeLine("Start sending...");
                try {
                    $sms->send();
                } catch (Exception $e) {
                    $this->writeLine($e->getMessage());
                }
                $this->writeLine('>>>> Done');

                sleep(1);
            }

        } while (true);
    }
}