<?php

use yii\db\Schema;
use yii\db\Migration;

class m140908_023435_guests extends Migration
{
    public function up()
    {
    	$this->createTable('guests', [
    		'id'			=> Schema::TYPE_INTEGER.' UNSIGNED AUTO_INCREMENT PRIMARY KEY',
    		'name'			=> Schema::TYPE_STRING.'(50) NOT NULL',
    		'email'			=> Schema::TYPE_STRING.'(50) NOT NULL',

    	]);
    }

    public function down()
    {
        $this->dropTable('guests');
    }
}
