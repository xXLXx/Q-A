<?php

use yii\db\Schema;
use yii\db\Migration;

class m140827_033137_answers extends Migration
{
    public function up()
    {
    	$this->createTable('answers', [
    		'id'			=> Schema::TYPE_INTEGER.' UNSIGNED AUTO_INCREMENT PRIMARY KEY',
    		'answer'		=> Schema::TYPE_TEXT.' NOT NULL',
    		'name'			=> Schema::TYPE_STRING.' NOT NULL',
    		'email'			=> Schema::TYPE_STRING,
    		'best_answer'	=> Schema::TYPE_INTEGER.' UNSIGNED',
    		'votes'			=> Schema::TYPE_INTEGER,
    		'created_at'	=> Schema::TYPE_INTEGER.' UNSIGNED',
    		'updated_at'	=> Schema::TYPE_INTEGER.' UNSIGNED',

    	]);
    }

    public function down()
    {
        $this->dropTable('answers');
    }
}
