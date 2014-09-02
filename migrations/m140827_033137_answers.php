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
    		'email'			=> Schema::TYPE_STRING.'(50) NOT NULL',
            'question_id'   => Schema::TYPE_INTEGER.' UNSIGNED NOT NULL',
    		'votes'			=> Schema::TYPE_INTEGER.' UNSIGNED NOT NULL',
    		'created_at'	=> Schema::TYPE_INTEGER.' UNSIGNED',
    		'updated_at'	=> Schema::TYPE_INTEGER.' UNSIGNED',

    	]);
    }

    public function down()
    {
        $this->dropTable('answers');
    }
}
