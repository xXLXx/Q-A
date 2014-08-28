<?php

use yii\db\Schema;
use yii\db\Migration;

class m140826_032805_users extends Migration
{
    public function up()
    {
    	$this->createTable('users', [
    		'id'			=> Schema::TYPE_INTEGER.' UNSIGNED AUTO_INCREMENT PRIMARY KEY',
    		'name'			=> Schema::TYPE_STRING.'(50) NOT NULL',
    		'email'			=> Schema::TYPE_STRING.'(50) NOT NULL',
    		'password'		=> Schema::TYPE_STRING.' NOT NULL',
    		'pic_path'		=> Schema::TYPE_STRING,
    		'auth_key'		=> Schema::TYPE_STRING,
    		'access_token'	=> Schema::TYPE_STRING,
    		'created_at'	=> Schema::TYPE_INTEGER.' UNSIGNED',
    		'updated_at'	=> Schema::TYPE_INTEGER.' UNSIGNED',

    	]);
    }

    public function down()
    {
        $this->dropTable('users');
    }
}
