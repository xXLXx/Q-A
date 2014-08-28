<?php

use yii\db\Schema;
use yii\db\Migration;

class m140827_033130_questions extends Migration
{
    public function up()
    {
    	$this->createTable('questions', [
    		'id'			=> Schema::TYPE_INTEGER.' UNSIGNED AUTO_INCREMENT PRIMARY KEY',
    		'question'		=> Schema::TYPE_TEXT.' NOT NULL',
    		'user_id'		=> Schema::TYPE_INTEGER.' UNSIGNED',
    		'email'			=> Schema::TYPE_STRING,
    		'votes'			=> Schema::TYPE_INTEGER,
    		'created_at'	=> Schema::TYPE_INTEGER.' UNSIGNED',
    		'updated_at'	=> Schema::TYPE_INTEGER.' UNSIGNED',

    	]);
    }

    public function down()
    {
        $this->dropTable('questions');
    }
}
