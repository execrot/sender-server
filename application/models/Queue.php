<?php

/**
 * @property MongoId    $id
 * @property string     $type
 * @property array      $receivers
 * @property string     $subject
 * @property string     $content
 * @property int        $time
 * @property string     $user
 *
 * @method static App_Model_Queue[] fetchAll(array $cond = null, array $sort = null, $count = null, $offset = null, $hint = NULL)
 * @method static App_Model_Queue|null fetchOne(array $cond = null, array $sort = null)
 * @method static App_Model_Queue fetchObject(array $cond = null, array $sort = null)
 */
class App_Model_Queue extends Mongostar_Model
{
    const EMAIL = 'email';
    const SMS = 'sms';

    /**
     * @return App_Model_Queue|null
     */
    public static function pop()
    {
        $message = self::fetchOne([
            'time' => ['$lt' => time()]
        ]);

        if ($message) {
            $message->delete();
        }

        return $message;
    }
}