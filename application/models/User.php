<?php

/**
 * @property MongoId    $id
 * @property string     $login
 * @property string     $password
 * @property array      $tokens
 * @property array      $data
 *
 * @method static App_Model_Queue[] fetchAll(array $cond = null, array $sort = null, $count = null, $offset = null, $hint = NULL)
 * @method static App_Model_Queue|null fetchOne(array $cond = null, array $sort = null)
 * @method static App_Model_Queue fetchObject(array $cond = null, array $sort = null)
 */
class App_Model_User extends Mongostar_Model
{
    
}