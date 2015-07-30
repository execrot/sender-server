<?php

class MailController extends Default_Controller_Command
{
    public function indexAction()
    {
        do {

            $message = App_Model_Queue::pop(App_Model_Queue::EMAIL);

            if ($message) {

                $user = App_Model_User::fetchOne([
                    'id' => (string)$message->user
                ]);

                $config = $user->data['mail'];

                Zend_Mail::setDefaultTransport(new Zend_Mail_Transport_Smtp(
                    $config['server'],
                    [
                        'auth' => $config['auth'],
                        'username' => $config['username'],
                        'password' => $config['password'],
                        'port' => $config['port'],
                        'ssl' => $config['ssl'],
                    ]
                ));

                $mail = new Zend_Mail('UTF-8');

                foreach ($message->receivers as $receiver) {
                    $mail->addTo($receiver['email'], $receiver['name']);
                }

                $this->writeLine("------------------------------------------------");
                $this->writeLine("to: " . print_r($message->receivers));
                $this->writeLine("from: " . implode(', ', [$user->data['mail']['username'], $user->data['mail']['name']]));
                $this->writeLine("Subject: " . $message->subject);

                $mail->setSubject($message->subject);
                $mail->setBodyHtml($message->content);
                $mail->setFrom(
                    $user->data['mail']['username'],
                    $user->data['mail']['name']
                );

                try {
                    $mail->send();
                } catch (Exception $e) {
                    $this->writeLine($e->getMessage());
                }

                sleep(1);
            }

        } while (true);
    }
}