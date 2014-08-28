<?php

use yii\db\Schema;
use yii\db\Migration;

class m140827_033147_tags extends Migration
{
    public function up()
    {
    	$this->createTable('tags', [
    		'id'	=> Schema::TYPE_INTEGER.' UNSIGNED AUTO_INCREMENT PRIMARY KEY',
    		'name'	=> Schema::TYPE_STRING.'(50) NOT NULL',
    	]);
    }

    public function down()
    {
        $this->dropTable('tags');
    }
}
